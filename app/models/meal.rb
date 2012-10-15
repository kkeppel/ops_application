class Meal < ActiveRecord::Base

  attr_accessible :name, :headcount, :max_price, :serving_time, :active, :private, :default, :location_id,
                  :company_profile_id, :meal_type_id

end
