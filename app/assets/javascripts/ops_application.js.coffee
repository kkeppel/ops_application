window.OpsApplication =
  Models: {}
  Collections: {}
  Views: {}
  Routers: {}
  initialize: ->
    new OpsApplication.Routers.Orders()
    new OpsApplication.Routers.Companies()
    new OpsApplication.Routers.Items()
    new OpsApplication.Routers.Ingredients()
    new OpsApplication.Routers.IngredientsItems()
    Backbone.history.start({pushState: true})

$(document).ready ->
  OpsApplication.initialize()
