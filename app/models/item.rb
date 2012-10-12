class Item < ActiveRecord::Base

  belongs_to :vendor
  belongs_to :meal
  has_many :allergens

  attr_accessible :name, :description, :price, :hot, :allergen_free, :headcount,
                  :nb_time_used, :serving_instructions_id, :vendor_id, :vendor_profiles_id

  validates :name, :presence => true
  validates :description, :presence => true
  validates :price, :presence => true
  validates :hot, :presence => true
  validates :allergen_free, :presence => true
  validates :headcount, :presence => true
  validates :nb_time_used, :presence => true
  validates :vendor_id, :presence => true

end
