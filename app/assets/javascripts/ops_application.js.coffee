window.OpsApplication =
  Models: {}
  Collections: {}
  Views: {}
  Routers: {}
  initialize: ->
    new OpsApplication.Routers.Orders
    new OpsApplication.Routers.Companies
    new OpsApplication.Routers.Items
    new OpsApplication.Routers.Allergens
    new OpsApplication.Routers.Tags
    new OpsApplication.Routers.MealTypes
    new OpsApplication.Routers.VendorTypes
    new OpsApplication.Routers.Locations
    new OpsApplication.Routers.Menus
    new OpsApplication.Routers.FoodCategories
#    new OpsApplication.Routers.Ingredients()
    Backbone.history.start({pushState: true})

$(document).ready ->
  OpsApplication.initialize()
