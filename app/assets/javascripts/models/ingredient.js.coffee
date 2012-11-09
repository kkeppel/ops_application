#= require models/ingredients_item

OpsApplication.Models.Ingredient = Backbone.RelationalModel.extend({
  relations: [
    {
      type: 'HasMany'
      keySource: 'item_ids'
      key: 'items'
      relatedModel: OpsApplication.Models.IngredientsItem()
      reverseRelation: {
        key: 'item_id'
        includeInJSON: 'id'
      }
    }
  ]
})
