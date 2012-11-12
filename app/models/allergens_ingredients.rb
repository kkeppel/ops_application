class AllergensIngredients < ActiveRecord::Base
  belongs_to :ingredient
  belongs_to :allergen

  attr_accessible :ingredient_id, :allergen_id
end
