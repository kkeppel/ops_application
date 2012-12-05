class OpsApplication.Routers.Menus extends Backbone.Router

  routes:
    'menus': 'index'

  initialize: ->
    @collection = new OpsApplication.Collections.Menus()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.MenusIndex(collection: @collection)
    $('#menus_container').html(view.render().el)
