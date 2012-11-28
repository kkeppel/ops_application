class ItemsTags < ActiveRecord::Base
  belongs_to :item
  belongs_to :tag

  attr_accessible :item_id, :tag_id
end
