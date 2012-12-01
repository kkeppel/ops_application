class OpsApplication.Views.VendorType extends Backbone.View
  template: JST['vendor_types/vendor_type']
  tagName: 'tr'

  events:
    'click #destroy_vendor_type': 'destroyVendorType'
    'click #save_changes': 'changeVendorType'

  initialize: ->
    @model.on('change', @render)

  render: =>
    $(@el).html(@template(vendor_type: @model))
    this

  changeVendorType: (event) ->
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

  destroyVendorType: (event) =>
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


