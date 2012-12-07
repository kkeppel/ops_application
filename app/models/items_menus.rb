class ItemsMenus < ActiveRecord::Base
  belongs_to :menu
  belongs_to :item

  attr_accessible :menu_id, :item_id, :quantity
  # attr_accessible :title, :body
end
