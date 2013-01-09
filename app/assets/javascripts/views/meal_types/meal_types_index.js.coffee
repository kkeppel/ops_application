class OpsApplication.Views.MealTypesIndex extends Backbone.View

  template: JST['meal_types/index']

  events:
    'submit #new_meal_type': 'createMealType'

  initialize: ->
    @collection.on('reset', @render)
    @collection.on('add', @appendMealType)
    @collection.on('remove', @render)

  render: =>
    $(@el).html(@template(collection: @collection))
    @collection.each(@appendMealType)
    this

  appendMealType: (meal_type) =>
    view = new OpsApplication.Views.MealType(model: meal_type)
    @$('#meal_types').append(view.render().el)

  createMealType: (event) ->
    event.preventDefault()
    attributes =
      meal_type:
        name: $('#meal_type_name').val()
        start_time: $('#meal_type_start_time').val()
        end_time: $('#meal_type_end_time').val()
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_meal_type')[0].reset()
      error: @handleError

  handleError: (entry, response) ->
    if response.status == 422
      errors = $.parseJSON(response.responseText).errors
      for attribute, messages of errors
        alert "#{attribute} #{message}" for message in messages

