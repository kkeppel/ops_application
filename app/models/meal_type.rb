class MealType < ActiveRecord::Base
  belongs_to :meal

  attr_accessible :meal_type, :description
end
