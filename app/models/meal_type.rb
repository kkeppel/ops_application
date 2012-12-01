class MealType < ActiveRecord::Base
  belongs_to :meal

  attr_accessible :name, :description
end
