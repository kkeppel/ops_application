class OpsApplication.Views.OrdersIndex extends Backbone.View

  template: JST['orders/index']

  initialize: ->
    @collection.on('reset', @render, this)

  render: ->
    $(@el).html(@template(entries: @collection))
    this
