class OpsApplication.Routers.Items extends Backbone.Router
  routes:
    'items': 'index'

  initialize: ->
    @vendors = new OpsApplication.Collections.Vendors()
    @vendors.fetch()
    @collection = new OpsApplication.Collections.Items()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.ItemsIndex({collection: @collection, vendors: @vendors})
    $('#items_container').html(view.render().el)


