class OpsApplication.Routers.MealTypes extends Backbone.Router
  routes:
    'meal_types': 'index'

  initialize: ->
    @collection = new OpsApplication.Collections.MealTypes()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.MealTypesIndex(collection: @collection)
    $('#meal_types_container').html(view.render().el)
