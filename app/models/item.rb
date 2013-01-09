class Item < ActiveRecord::Base

  belongs_to :vendor
  belongs_to :menu
  has_and_belongs_to_many :ingredients
  has_and_belongs_to_many :tags
  has_many :allergens, :through => :ingredients
  has_many :item_types

  accepts_nested_attributes_for :ingredients

  attr_accessible :name, :description, :price, :hot, :allergen_free, :headcount,
                  :nb_time_used, :serving_instructions_id, :vendor_id, :ingredient_ids,
                  :calories_per_serving, :nutritional_information, :notes

  #validates :name, :presence => true
  #validates :description, :presence => true
  #validates :price, :presence => true
  #validates :headcount, :presence => true
  #validates :nb_time_used, :presence => true
  #validates :vendor_id, :presence => true

end
