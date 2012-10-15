class IngredientsAllergens < ActiveRecord::Base
  belongs_to :ingredient
  belongs_to :allergen

  attr_accessible :ingredients_id, :allergens_id
end
