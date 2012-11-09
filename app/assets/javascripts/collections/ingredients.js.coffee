class OpsApplication.Collections.Ingredients extends Backbone.Collection
#  url_path = window.location.pathname
#  id = url_path.substring(url_path.lastIndexOf('/') + 1)

  url: (id) ->
    "/items/" + id + "ingredients"
  model: OpsApplication.Models.Ingredient


