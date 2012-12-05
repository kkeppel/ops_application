class OpsApplication.Views.Menu extends Backbone.View
  template: JST['menus/menu']
  tagName: 'tr'

  events:
    'click #destroy_menu': 'destroyMenu'
    'click #save_changes': 'changeMenu'

  initialize: ->
    @model.on('change', @render)

  render: =>
    $(@el).html(@template(menu: @model))
    this

  changeMenu: (event) ->
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

  destroyMenu: (event) =>
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