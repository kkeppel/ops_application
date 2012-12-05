class OpsApplication.Views.FoodCategory extends Backbone.View
  template: JST['food_categories/food_category']
  tagName: 'tr'

  events:
    'click #destroy_food_category': 'destroyFoodCategory'
    'click #save_changes': 'changeFoodCategory'

  initialize: ->
    @model.on('change', @render)

  render: =>
    $(@el).html(@template(food_category: @model))
    this

  changeFoodCategory: (event) ->
    event.preventDefault()
    @model.save({
      food_category:
        name: @el.children[0].innerText
        description: @el.children[1].innerText
    },
    success: ->
      console.log "GREAT SUCCESS!"
    error: ->
      console.log "FAIL TOWN."
    silent: true
    )


  destroyFoodCategory: (event) =>
    event.preventDefault()
    @model.destroy
      success: (model, response) ->
        this.remove
        this.unbind
        console.log "Success"
      error: (model, response) ->
        console.log "Error"
