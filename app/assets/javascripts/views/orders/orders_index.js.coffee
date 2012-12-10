class OpsApplication.Views.OrdersIndex extends Backbone.View

  template: JST['orders/index']
  tagName: 'div'
  className: 'row'


  events:
    'click #datepicker': 'loadDatepicker'
    'click #company_select': 'loadMeals'
    'click #meal_select': 'loadVendors'
    'click #create_order': 'createOrder'


  initialize: ->
    @vendors = new OpsApplication.Collections.Vendors
    @vendors.fetch(success: -> console.log(@vendors))
    @companies = new OpsApplication.Collections.Companies
    @companies.fetch(success: -> console.log(@companies))
    @items = new OpsApplication.Collections.Items
    @items.fetch(success: -> console.log(@items))
    @meals = new OpsApplication.Collections.Meals
    @meals.fetch(success: -> console.log(@meals))
    @menus = new OpsApplication.Collections.Menus
    @menus.fetch(success: -> console.log(@menus))
    @collection = new OpsApplication.Collections.Orders
    @collection.fetch()
    @companies.on('reset', @render)
    @collection.on('add', @appendOrder)
    @collection.on('reset', @render)


  render: =>
    $(@el).html(@template(
      collection: @collection,
      companies: @companies,
      vendors: @vendors,
      meals: @meals,
      menus: @menus,
      items: @items
    ))
    @collection.each(@appendOrder)
    this


  appendOrder: (order) =>
    view = new OpsApplication.Views.Order(model: order)
    @$('#orders_container').append(view.render().el)


  loadDatepicker: (event) ->
    event.preventDefault()
    $('#datepicker').datepicker()


  loadMeals: (event) ->
    # grab company_id
    company_id = $("option:selected").val()
    # record chosen company
    $.chosen_company = @companies.filter (c) ->
      parseInt(c.id) == parseInt(company_id)
    # filter meals by the company_id
    filtered_meals = @meals.filter (m) ->
      m.get('company_id') == parseInt(company_id)
    $(@el).html(@template({companies: $.chosen_company, meals: filtered_meals, vendors: @vendors, menus: @menus, items: @items}))
    @collection.each(@appendOrder)
    this


  loadVendors: (event) ->
    #declare variables
    filtered_ingredient_ids = []
    all_ingredients_items = []
    unsafe_item_ids = []
    unsafe_items = []
    all_allergens_ingredients = []
    all_allergens = []
    allergen_ids = []
    all_items_menus = []
    unsafe_menu_ids = []

    meal_id = $("#meal_select option:selected").val()
    # record chosen meal
    $.chosen_meal = @meals.filter (m) ->
      parseInt(m.id) == parseInt(meal_id)
    # use meal id to get allergen ids from allergens_meals
    $.ajax
      url: '/allergens/get_allergens/' + meal_id
      type: 'GET'
      dataType: 'json'
      async: false
      success: (data) ->
        all_allergens = data
    for ids in all_allergens
      allergen_ids.push(ids.allergen_id)
    # get all ingredients
    $.ajax
      url: '/allergens/get_ingredients'
      type: 'GET'
      async: false
      success: (data) ->
        all_allergens_ingredients = data
    # filter all allergens_ingredients by the ids from allergens_meals
    all_allergens_ingredients.filter (a) ->
      filtered_ingredient_ids.push(a.ingredient_id) if _.contains(allergen_ids, a.allergen_id)
    # get all items
    $.ajax
      url: '/items/get_items'
      type: 'GET'
      async: false
      success: (data) ->
        all_ingredients_items = data
    # filter all ingredients_items by the ids from allergens_ingredients
    all_ingredients_items.filter (a) ->
      unsafe_item_ids.push(a.item_id) if _.contains(filtered_ingredient_ids, a.ingredient_id)
      unsafe_item_ids = _.unique(unsafe_item_ids)
    # get all items_menus
    $.ajax
      url: '/items_menus'
      type: 'GET'
      async: false
      success: (data) ->
        all_items_menus = data
    # get unsafe_menu_ids using the list of unsafe items
    all_items_menus.filter (menu) ->
      unsafe_menu_ids.push(menu.menu_id) if _.contains(unsafe_item_ids, menu.item_id)
    # reset unsafe_item_ids and filter all_items again by both unsafe_menu_ids (so you don't get safe items that are in
    #   menus with an unsafe item)
    unsafe_item_ids = []
    all_items_menus.filter (item) ->
      unsafe_item_ids.push(item.item_id) if _.contains(unsafe_menu_ids, item.menu_id)
    # get safe menu objects
    safe_menus = @menus.reject (m) ->
      _.contains(unsafe_menu_ids, m.id)
    # get safe items objects
    safe_items = @items.reject (i) ->
      _.contains(unsafe_item_ids, i.id) || _.contains((safe_menus.map (si) -> si.get('id')), i.get('menu_id'))
#    # filter out all vendors who have those item ids (because those items contain the allergens)
    safe_vendors = @vendors.filter (v) ->
      v if _.contains((safe_items.map (si) -> si.get('vendor_id')), v.id)

    #load it all up!!!
    $(@el).html(@template({
      companies: $.chosen_company,
      vendors: safe_vendors,
      items: safe_items,
      meals: $.chosen_meal
      menus: safe_menus
    }))
    @collection.each(@appendOrder)
    this


  createOrder: (event) ->
    event.preventDefault()
    attributes =
#      name: $('#new_order_name').val()
#      tip: $('#new_order_tip').val()
      order:
        company_id: $.chosen_company[0].id
        meal_id: $.chosen_meal[0].id
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_order')[0].reset()
      error: @handleError
