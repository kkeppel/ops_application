class OpsApplication.Routers.Ingredients extends Backbone.Router
  routes:
    'items/:id/ingredients': 'index'

  initialize: (id) ->
    @collection = new OpsApplication.Collections.Ingredients()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.IngredientsIndex({collection: @collection})
    $('#ingredients').html(view.render().el)