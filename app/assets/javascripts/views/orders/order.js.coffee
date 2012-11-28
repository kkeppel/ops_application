class OpsApplication.Views.Order extends Backbone.View
  template: JST['orders/order']

  initialize: ->
    @model.on('change', @render)

  render: =>
    $(@el).html(@template(order: @model))
    this
