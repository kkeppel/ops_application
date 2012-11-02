window.OpsApplication =
  Models: {}
  Collections: {}
  Views: {}
  Routers: {}
  initialize: ->
    new OpsApplication.Routers.Orders()
    new OpsApplication.Routers.Companies()
    Backbone.history.start()

$(document).ready ->
  OpsApplication.initialize()
