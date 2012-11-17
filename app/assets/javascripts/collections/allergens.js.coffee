class OpsApplication.Collections.Allergens extends Backbone.Collection
  url: '/ingredients/' + this.id + '/allergens'
  model: OpsApplication.Models.Allergen

  initialize: (models, options) ->
    this.id = options.id


