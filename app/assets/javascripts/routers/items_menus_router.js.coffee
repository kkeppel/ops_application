class OpsApplication.Routers.ItemsMenus extends Backbone.Router
  routes:
    'items_menus': 'index'

  initialize: ->
    @collection = new OpsApplication.Collections.ItemsMenus()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.ItemsMenusIndex({collection: @collection})
    $('#items_menus_container').html(view.render().el)
