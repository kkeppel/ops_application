class Allergen < ActiveRecord::Base

  has_and_belongs_to_many :ingredients
  has_and_belongs_to_many :meals

  attr_accessible :name, :meal_ids

end
