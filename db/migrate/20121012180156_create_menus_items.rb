class CreateMenusItems < ActiveRecord::Migration
  def change
    create_table :items_menus do |t|

      t.integer :menu_id
      t.integer :item_id
      t.integer :quantity

    end
  end
end
