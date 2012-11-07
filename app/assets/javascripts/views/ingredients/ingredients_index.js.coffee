class OpsApplication.Views.IngredientsIndex extends Backbone.View

  template: JST['ingredients/index']

  initialize: ->
    @collection.on('reset', @render)
    @collection.on('add', @appendIngredient)

  render: =>
    $(@el).html(@template())
    @collection.each(@appendIngredient)
    this

  appendIngredient: (ingredient) =>
    view = new OpsApplication.Views.Ingredient(model: ingredient)
    @$('#ingredients').append(view.render().el)
