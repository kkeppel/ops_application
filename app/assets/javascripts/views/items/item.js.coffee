class OpsApplication.Views.Item extends Backbone.View
  template: JST['items/item']
  tagName: 'tr'

  initialize: ->
    @model.on('change', @render)

  render: =>
    $(@el).html(@template(item: @model, vendor: @vendor))
    this