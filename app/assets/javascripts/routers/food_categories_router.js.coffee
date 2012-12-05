class OpsApplication.Routers.FoodCategories extends Backbone.Router

  routes:
    'food_categories': 'index'

  initialize: ->
    @collection = new OpsApplication.Collections.FoodCategories()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.FoodCategoriesIndex(collection: @collection)
    $('#food_categories_container').html(view.render().el)
