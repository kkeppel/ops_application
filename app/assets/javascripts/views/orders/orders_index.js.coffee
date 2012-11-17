class OpsApplication.Views.OrdersIndex extends Backbone.View

  template: JST['orders/index']

  events:
    'click #datepicker': 'loadDatepicker'
    'click #company_select': 'filterVendors'

  initialize: ->
    @vendors = new OpsApplication.Collections.Vendors()
    @vendors.fetch()
    @companies = new OpsApplication.Collections.Companies()
    @companies.fetch()
    @company_profiles = new OpsApplication.Collections.CompanyProfiles()
    @company_profiles.fetch()
    @companies.on('reset', @render)

  render: =>
    $(@el).html(@template({companies: @companies, vendors: @vendors, company_profiles: @company_profiles}))
    this

  loadDatepicker: (event) ->
    event.preventDefault()
    $('#datepicker').datepicker()

  loadVendorsAndItems: (event) ->
    company_id = $("option:selected").val()
    filtered_profiles = @company_profiles.filter (cp) ->
      cp.get('company_id') == parseInt(company_id) && cp.get('key') == "allergies"
    console.log filtered_profiles
    @filtered_vendors = @vendors.filter (v) ->
      v.get('id') == parseInt(company_id)
    $(@el).html(@template({companies: @companies, vendors: @filtered_vendors}))
    this
