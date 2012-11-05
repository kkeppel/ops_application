class OpsApplication.Views.VendorsIndex extends Backbone.View

  template: JST['vendors/index']

  initialize: ->
    @collection.on('click', @render, this)

  render: ->
    $(@el).html(@template(vendors: @collection))
    this
