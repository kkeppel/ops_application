class Meal < ActiveRecord::Base

  has_many :items
  has_many :allergens

  attr_accessible :name, :headcount, :max_price, :serving_time, :active, :private, :default, :location_id,
                  :company_profile_id, :meal_type_id

end
