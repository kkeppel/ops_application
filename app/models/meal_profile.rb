class MealProfile < ActiveRecord::Base
  belongs_to :meal

  attr_accessible :key, :value, :value2, :meal_id

  SINGLEVALUE_KEYS = [
    :preferences
  ]

  MULTIVALUE_KEYS = [

  ]

  KEYS = SINGLEVALUE_KEYS + MULTIVALUE_KEYS

end
