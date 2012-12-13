class OpsApplication.Views.PaymentTypesIndex extends Backbone.View

  template: JST['payment_types/index']

  events:
    'click #create_payment_type': 'createPaymentType'

  initialize: ->
    @collection.on('reset', @render)
    @collection.on('add', @appendPaymentType)
    @collection.on('remove', @render)

  render: =>
    console.log "OH HEY!"
    $(@el).html(@template())
    @collection.each(@appendPaymentType)
    this

  appendPaymentType: (payment_type) =>
    console.log "HI THERE!"
    view = new OpsApplication.Views.PaymentType(
      model: payment_type
    )
    @$('#payment_types').append(view.render().el)

  createPaymentType: (event) ->
    event.preventDefault()
    attributes = {
      payment_type:
        name: $('#payment_type_name').val()
        description: $('#payment_type_description').val()
    }
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_payment_type')[0].reset()
        console.log "You are here!"
      error: @handleError

  handleError: (entry, response) ->
    if response.status == 422
      errors = $.parseJSON(response.responseText).errors
      for attribute, messages of errors
        alert "#{attribute} #{message}" for message in messages
