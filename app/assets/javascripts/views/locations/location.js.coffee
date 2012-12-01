class OpsApplication.Views.Location extends Backbone.View
  template: JST['locations/location']
  tagName: 'tr'

  events:
    'click #destroy_location': 'destroyLocation'
    'click #save_changes': 'changeLocation'

  initialize: ->
    @model.on('change', @render)

  render: =>
    $(@el).html(@template(location: @model))
    this

  changeLocation: (event) ->
    event.preventDefault()
    attributes =
      name: @el.children[0].innerText
      description: @el.children[1].innerText
    @model.set attributes
    @model.save
      success: ->
        console.log "GREAT SUCCESS!"
      error: ->
        console.log "FAIL TOWN."

  destroyLocation: (event) =>
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


