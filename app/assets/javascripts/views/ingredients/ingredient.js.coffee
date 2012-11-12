class OpsApplication.Views.Ingredient extends Backbone.View
  template: JST['ingredients/ingredient']
  tagName: 'tr'

  initialize: ->
    @model.on('change', @render)

  render: =>
    $(@el).html(@template(ingredient: @model))
    this