class Allergen < ActiveRecord::Base

  belongs_to :item
  belongs_to :meal

  attr_accessible :name

end
