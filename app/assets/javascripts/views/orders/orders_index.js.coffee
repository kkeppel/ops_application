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
    company_id = $("option:selected").val()
    filtered_meals = @meals.filter (m) ->
      m.get('company_id') == parseInt(company_id)
    $(@el).html(@template({companies: @companies, meals: filtered_meals, vendors: @vendors, menus: @menus, items: @items}))
    this

  createOrder: (event) ->
    event.preventDefault()
    attributes = {
      company_id: $('.new_company_id').val()
#      vendor_id: $('.new_vendor_id').val()
    }
    console.log @collection
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_order')[0].reset()
      error: @handleError

  loadVendors: (event) ->
    filtered_ingredient_ids = []
    all_items = []
    filtered_item_ids = []
    filtered_items = []
    all_allergens_ingredients = []
    all_allergens = []
    allergen_ids = []

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
    $.ajax
      url: '/allergens/get_ingredients'
      type: 'GET'
      async: false
      success: (data) ->
        all_allergens_ingredients = data
    all_allergens_ingredients.filter (a) ->
      filtered_ingredient_ids.push(a.ingredient_id) if _.contains(allergen_ids, a.allergen_id)
    $.ajax
      url: '/items/get_items'
      type: 'GET'
      async: false
      success: (data) ->
        all_items = data
    all_items.filter (a) ->
      filtered_item_ids.push(a.item_id) if _.contains(filtered_ingredient_ids, a.ingredient_id)
      filtered_item_ids = _.unique(filtered_item_ids)
    @items.filter (a) ->
      filtered_items.push(a) if _.contains(filtered_item_ids, a.id)
    filtered_vendors = @vendors.reject (v) ->
      v.get('id') == filtered_items[0].attributes.vendor_id
    console.log filtered_items
    console.log filtered_vendors
    $(@el).html(@template({
      companies: @companies,
      vendors: filtered_vendors,
      items: filtered_items,
      meals: @meals
      menus: @menus
    }))
    this
