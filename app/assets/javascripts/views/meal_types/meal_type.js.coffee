class OpsApplication.Views.MealType extends Backbone.View
  template: JST['meal_types/meal_type']
  tagName: 'tr'

  events:
    'click #destroy_meal_type': 'destroyMealType'
    'click #save_changes': 'changeMealType'

  initialize: ->
    @model.on('change', @render)

  render: =>
    $(@el).html(@template(meal_type: @model))
    this

  changeMealType: (event) ->
    event.preventDefault()
    attributes =
      name: @el.children[0].innerText
      start_time: @el.children[1].innerText
      end_time: @el.children[2].innerText
    @model.set attributes
    @model.save
      success: ->
        console.log "GREAT SUCCESS!"
      error: ->
        console.log "FAIL TOWN."

  destroyMealType: (event) =>
    event.preventDefault()
    @model.destroy
      success: (model, response) ->
        this.remove
        console.log "Success"
        console.log model
        console.log response
      error: (model, response) ->
        console.log "Error"
        console.log model
        console.log response


