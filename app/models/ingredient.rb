class Ingredient < ActiveRecord::Base
  has_many :items
  has_many :ingredients, :through => :items

  attr_accessible :name, :description
end
