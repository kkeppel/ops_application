class Tag < ActiveRecord::Base
  has_and_belongs_to_many :items
  has_and_belongs_to_many :orders

  attr_accessible :name
end
