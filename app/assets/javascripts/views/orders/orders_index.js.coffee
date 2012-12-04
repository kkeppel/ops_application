class OpsApplication.Views.OrdersIndex extends Backbone.View

  template: JST['orders/index']
  tagName: 'div'
  className: 'row'


  events:
    'click #datepicker': 'loadDatepicker'
    'click #company_select': 'loadMeals'
    'click #meal_select': 'loadVendors'
#    'click #new_order': 'createOrder'


  initialize: ->
    @vendors = new OpsApplication.Collections.Vendors()
    @vendors.fetch()
    @companies = new OpsApplication.Collections.Companies()
    @companies.fetch()
    @items = new OpsApplication.Collections.Items
    @items.fetch
      success: ->
        console.log(@items)
    @meals = new OpsApplication.Collections.Meals
    @meals.fetch
      success: ->
        console.log(@meals)
    @menus = new OpsApplication.Collections.Menus
    @menus.fetch
      success: ->
        console.log(@menus)
    @company_profiles = new OpsApplication.Collections.CompanyProfiles()
    @company_profiles.fetch()
    @collection = new OpsApplication.Collections.Orders()
    @collection.fetch()
#    @collection.on('add', @appendOrder)
    @companies.on('reset', @render)


  render: =>
    $(@el).html(@template(
      collection: @collection,
      companies: @companies,
      vendors: @vendors,
      company_profiles: @company_profiles,
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
    this


  loadVendors: (event) ->
    #declare variables
    filtered_ingredient_ids = []
    all_items = []
    unsafe_item_ids = []
    unsafe_items = []
    all_allergens_ingredients = []
    all_allergens = []
    allergen_ids = []
    # use meal idea to get allergen ids from allergens_meals
    meal_id = $("#meal_select option:selected").val()
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
        all_items = data
    # filter all ingredients_items by the ids from allergens_ingredients
    all_items.filter (a) ->
      unsafe_item_ids.push(a.item_id) if _.contains(filtered_ingredient_ids, a.ingredient_id)
      unsafe_item_ids = _.unique(unsafe_item_ids)
    # get the items objects to access their vendor_id
    @items.filter (a) ->
      unsafe_items.push(a) if _.contains(unsafe_item_ids, a.id)
    # filter out all vendors who have those item ids (because those items contain the allergens)
    safe_vendors = @vendors.reject (v) ->
      v.get('id') == unsafe_items[0].attributes.vendor_id
    # record chosen meal
    chosen_meal = @meals.filter (m) ->
      parseInt(m.id) == parseInt(meal_id)
    # get safe items
    safe_items = @items.reject (i) ->
      _.contains(unsafe_item_ids, i.id)
    $(@el).html(@template({
      companies: $.chosen_company,
      vendors: safe_vendors,
      items: safe_items,
      meals: chosen_meal
      menus: @menus
    }))
    this


    createOrder: (event) ->
    event.preventDefault()
    attributes = {
    company_id: $('.new_company_id').val()
    }
    console.log @collection
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_order')[0].reset()
      error: @handleError
