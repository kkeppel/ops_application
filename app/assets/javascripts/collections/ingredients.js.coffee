class OpsApplication.Collections.Ingredients extends Backbone.Collection
  initialize: (models, options) ->
    this.id = options.id

  url: ->
    "/items/" + this.id + "/ingredients"
  model: OpsApplication.Models.Ingredient


