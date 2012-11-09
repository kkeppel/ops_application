#= require models/ingredients_item

OpsApplication.Models.Item = Backbone.RelationalModel.extend({
  urlRoot: 'items'
  relations: [
    {
      type: 'HasMany'
      keySource: 'ingredients_ids'
      key: 'ingredients'
      relatedModel: OpsApplication.Models.IngredientsItem
      includeInJSON: Backbone.Model.prototype.idAttribute
      reverseRelation: {
        key: 'item_id'
        includeInJSON: 'id'
      }
    }
  ]
})


