class OpsApplication.Routers.Contacts extends Backbone.Router

  routes:
    'contacts': 'index'

  initialize: ->
    @vendors = new OpsApplication.Collections.Vendors()
    @vendors.fetch(success: -> console.log(@vendors))
    @companies = new OpsApplication.Collections.Companies
    @companies.fetch(success: -> console.log(@companies))
    @locations = new OpsApplication.Collections.Locations()
    @locations.fetch(success: -> console.log(@locations))
    @payment_types = new OpsApplication.Collections.PaymentTypes()
    @payment_types.fetch(success: -> console.log(@payment_types))
    @collection = new OpsApplication.Collections.Contacts()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.ContactsIndex(
      collection: @collection,
      payment_types: @payment_types,
      vendors: @vendors,
      companies: @companies,
      locations: @locations
    )
    $('#contacts_container').html(view.render().el)
