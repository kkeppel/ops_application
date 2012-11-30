class OpsApplication.Views.Tag extends Backbone.View
  template: JST['tags/tag']
  tagName: 'tr'

  events:
    'click #destroy_tag': 'destroyTag'
    'click #save_changes': 'changeTag'

  initialize: ->
    @model.on('change', @render)

  render: =>
    $(@el).html(@template(tag: @model))
    this

  changeTag: (event) ->
    event.preventDefault()
    console.log @el.children[0].innerText
    attributes = {
      name: @el.children[0].innerText
    }
    @model.set attributes
    @model.save
      success: ->
        console.log "GREAT SUCCESS!"
      error: ->
        console.log "FAIL TOWN."

  destroyTag: (event) =>
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
