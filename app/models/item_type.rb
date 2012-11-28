class ItemType < ActiveRecord::Base
  belongs_to :item

  attr_accessible :name, :description, :order
end
