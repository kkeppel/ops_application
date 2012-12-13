class OpsApplication.Views.PaymentType extends Backbone.View

  template: JST['payment_types/payment_type']
  tagName: 'tr'

  events:
    'click #destroy_payment_type': 'destroyPaymentType'
    'click #save_changes': 'changePaymentType'

  initialize: ->
    @model.on('change', @render)

  render: =>
    console.log @model
    $(@el).html(@template(payment_type: @model))
    this

  changePaymentType: (event) ->
    event.preventDefault()
    @model.save({
      payment_type:
        name: @el.children[0].innerText
        description: @el.children[1].innerText
    },
      success: -> console.log "GREAT SUCCESS!"
      error: -> console.log "FAIL TOWN."
      silent: true
    )

  destroyPaymentType: (event) =>
    event.preventDefault()
    @model.destroy
      success: (model, response) ->
        this.remove
        console.log "Success"
      error: (model, response) ->
        console.log "Error"
