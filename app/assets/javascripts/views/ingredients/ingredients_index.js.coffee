class OpsApplication.Views.IngredientsIndex extends Backbone.View

  template: JST['ingredients/index']

  events:
    'submit #new_ingredient': 'createIngredient'

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

  createIngredient: (event) ->
    event.preventDefault()
    attributes =
      name: $('#new_ingredient_name').val()
      description: $('#new_ingredient_description').val()
    @collection.create attributes,
      success: -> $('#new_ingredient')[0].reset()
      error: @handleError

  handleError: (entry, response) ->
    if response.status == 422
      errors = $.parseJSON(response.responseText).errors
      for attribute, messages of errors
        alert "#{attribute} #{message}" for message in messages
