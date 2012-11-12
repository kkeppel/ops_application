class OpsApplication.Routers.Ingredients extends Backbone.Router
  routes:
    'items/:id/ingredients': 'index'
    'items/:item_id/ingredients/:id': 'show'

  index: (id) ->
    @collection = new OpsApplication.Collections.Ingredients([], {id: id})
    @collection.fetch()
    view = new OpsApplication.Views.IngredientsIndex({collection: @collection})
    $('#ingredients').html(view.render().el)

  show: (item_id, id) ->
    Backbone.history.navigate("items/#{item_id}/ingredients#{id}", true)
