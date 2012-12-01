class OpsApplication.Routers.Locations extends Backbone.Router

  routes:
    'locations': 'index'

  initialize: ->
    @collection = new OpsApplication.Collections.Locations()
    @collection.fetch()
  
  index: ->
    view = new OpsApplication.Views.LocationsIndex(collection: @collection)
    $('#locations_container').html(view.render().el)

