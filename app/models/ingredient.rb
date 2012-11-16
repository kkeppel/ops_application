class Ingredient < ActiveRecord::Base
  has_and_belongs_to_many :items
  has_and_belongs_to_many :allergens
  has_one :meal_preference # I guess?

  attr_accessible :name, :description, :allergen_ids, :item_id
end
