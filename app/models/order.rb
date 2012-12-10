class Order < ActiveRecord::Base
  has_and_belongs_to_many :tags

  attr_accessible :company_id, :vendor_id, :meal_id
end
