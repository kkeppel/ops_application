window.OpsApplication =
  Models: {}
  Collections: {}
  Views: {}
  Routers: {}
<<<<<<< HEAD
  initialize: ->
    new OpsApplication.Routers.Orders()
    new OpsApplication.Routers.Companies()
    Backbone.history.start()
=======
  initialize: -> alert 'Hello from Backbone!'
>>>>>>> d99ce67615a2ffa4e4e6994b5288c5ab4b4fd96c

$(document).ready ->
  OpsApplication.initialize()
