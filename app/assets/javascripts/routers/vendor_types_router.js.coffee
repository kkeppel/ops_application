class OpsApplication.Routers.VendorTypes extends Backbone.Router
  routes:
    'vendor_types': 'index'

  initialize: ->
    @collection = new OpsApplication.Collections.VendorTypes()
    @collection.fetch()
  
  index: ->
    view = new OpsApplication.Views.VendorTypesIndex(collection: @collection)
    $('#vendor_types_container').html(view.render().el)
