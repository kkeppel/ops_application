class Menu < ActiveRecord::Base
  has_many :items

  attr_accessible :headcount, :total, :total_per_head, :food_category_id, :vendor_profile_id, :name, :vendor_id
end
