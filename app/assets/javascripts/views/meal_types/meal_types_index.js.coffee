class OpsApplication.Views.MealTypesIndex extends Backbone.View

  template: JST['meal_types/index']

  events:
    'click #meal_type_select': 'appendVendors'

  initialize: ->
    @vendors = new OpsApplication.Collections.Vendors
    @vendors.fetch()
    @collection.on('click', @render, this)

  render: ->
    $(@el).html(@template(meal_types: @collection))
    this

  appendVendors: ->
    vendor_view = new OpsApplication.Views.VendorsIndex(collection: @vendors)
    $('#companies_container').append(vendor_view.render().el)
