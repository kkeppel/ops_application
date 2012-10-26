class Ingredient < ActiveRecord::Base
  has_and_belongs_to_many :items
  has_and_belongs_to_many :allergens

  attr_accessible :name, :description, :allergen_ids
end
