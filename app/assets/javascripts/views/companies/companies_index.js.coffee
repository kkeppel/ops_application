class OpsApplication.Views.CompaniesIndex extends Backbone.View

  template: JST['companies/index']

  events:
    'click #datepicker': 'loadDatepicker'
    'change #company_select': 'loadVendorsAndItems'

  initialize: ->
    @vendors = new OpsApplication.Collections.Vendors()
    @vendors.fetch()
    @collection = new OpsApplication.Collections.Companies()
    @collection.fetch()
    @collection.on('reset', @render)

  render: =>
    $(@el).html(@template({companies: @collection, vendors: @vendors}))
    this

  loadDatepicker: (event) ->
    event.preventDefault()
    $('#datepicker').datepicker()

  loadVendorsAndItems: (event) ->
    value = $("option:selected").val()
    @filtered_vendors = @vendors.filter (v) ->
      v.get('id') == parseInt(value)
    $(@el).html(@template({companies: @collection, vendors: @filtered_vendors}))
    this
