class Menu < ActiveRecord::Base
  has_many :items

  attr_accessible :heacount, :total, :total_per_head, :food_category_id, :vendor_profile_id
end
