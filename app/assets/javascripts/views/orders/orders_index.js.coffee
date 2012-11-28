class OpsApplication.Views.OrdersIndex extends Backbone.View

  template: JST['orders/index']
  tagName: 'div'
  className: 'row'

  events:
    'click #datepicker': 'loadDatepicker'
    'click #company_select': 'filterVendors'
    'click #new_order': 'createOrder'

  initialize: ->
    @vendors = new OpsApplication.Collections.Vendors()
    @vendors.fetch()
    @companies = new OpsApplication.Collections.Companies()
    @companies.fetch()
    @items = new OpsApplication.Collections.Items
    @items.fetch
      success: ->
        console.log(@items)
    @company_profiles = new OpsApplication.Collections.CompanyProfiles()
    @company_profiles.fetch()
    @collection = new OpsApplication.Collections.Orders()
    @collection.fetch()
#    @collection.on('add', @appendOrder)
    @companies.on('reset', @render)

  render: =>
    $(@el).html(@template(collection: @collection, companies: @companies, vendors: @vendors, company_profiles: @company_profiles))
    @collection.each(@appendOrder)
    this

  appendOrder: (order) =>
    view = new OpsApplication.Views.Order(model: order)
    @$('#orders_container').append(view.render().el)

  loadDatepicker: (event) ->
    event.preventDefault()
    $('#datepicker').datepicker()

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

  filterVendors: (event) ->
    filtered_allergen_ids = []
    filtered_ingredient_ids = []
    all_items = []
    filtered_item_ids = []
    filtered_items = []
    all_allergens_ingredients = []
    company_allergens = []
    all_allergens = []

    company_id = $("option:selected").val()
    filtered_profiles = @company_profiles.filter (cp) ->
      cp.get('company_id') == parseInt(company_id) && cp.get('key') == "allergies"
    for profile in filtered_profiles
      company_allergens.push(profile.get('value'))
    $.ajax
      url: '/allergens/get_allergens'
      type: 'GET'
      dataType: 'json'
      async: false
      success: (data) ->
        all_allergens = data
    all_allergens.filter (a) ->
      filtered_allergen_ids.push(a.id) if _.contains(company_allergens, a.name)
    $.ajax
      url: '/allergens/get_ingredients'
      type: 'GET'
      async: false
      success: (data) ->
        all_allergens_ingredients = data
    all_allergens_ingredients.filter (a) ->
      filtered_ingredient_ids.push(a.ingredient_id) if _.contains(filtered_allergen_ids, a.allergen_id)
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
    console.log filtered_vendors
    $(@el).html(@template({companies: @companies, vendors: filtered_vendors}))
    this
