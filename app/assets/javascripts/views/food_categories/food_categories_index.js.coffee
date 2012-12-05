class OpsApplication.Views.FoodCategoriesIndex extends Backbone.View

  template: JST['food_categories/index']

  events:
    'submit #new_food_category': 'createFoodCategory'

  initialize: ->
    @collection.on('reset', @render)
    @collection.on('add', @appendFoodCategory)
    @collection.on('remove', @render)
  
  render: =>
    $(@el).html(@template(collection: @collection))
    @collection.each(@appendFoodCategory)
    this
  
  appendFoodCategory: (food_category) =>
    view = new OpsApplication.Views.FoodCategory(model: food_category)
    @$('#food_categories').append(view.render().el)
  
  createFoodCategory: (event) ->
    event.preventDefault()
    attributes =
      food_category:
        name: $('#food_category_name').val()
        description: $('#food_category_description').val()
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_food_category')[0].reset()
      error: @handleError
  
  handleError: (entry, response) ->
    if response.status == 422
      errors = $.parseJSON(response.responseText).errors
      for attribute, messages of errors
        alert "#{attribute} #{message}" for message in messages