class OpsApplication.Routers.Orders extends Backbone.Router
  routes:
    'staff_dashboard': 'index'

  initialize: ->
    @collection = new OpsApplication.Collections.Orders()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.OrdersIndex(collection: @collection)
    $('#container').html(view.render().el)
