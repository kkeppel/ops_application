class OrdersTags < ActiveRecord::Base
  belongs_to :tags
  belongs_to :orders

  attr_accessible :tag_id, :order_id
end
