class OpsApplication.Routers.Items extends Backbone.Router
  routes:
    'items': 'index'

  initialize: ->
    @collection = new OpsApplication.Collections.Items()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.ItemsIndex({collection: @collection})
    $('#items_container').html(view.render().el)


