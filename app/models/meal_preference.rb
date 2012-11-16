class MealPreference < ActiveRecord::Base
  belongs_to :meal
  belongs_to :ingredient # Really? What was the plan with this..?

  attr_accessible :percentage, :meal_id, :ingredient_id
end
