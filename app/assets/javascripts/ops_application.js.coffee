window.OpsApplication =
  Models: {}
  Collections: {}
  Views: {}
  Routers: {}
  initialize: ->
    new OpsApplication.Routers.Orders()
    new OpsApplication.Routers.Companies()
    Backbone.history.start({pushState: true})

$(document).ready ->
  OpsApplication.initialize()
