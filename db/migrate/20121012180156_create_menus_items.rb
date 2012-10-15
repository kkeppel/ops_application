class CreateMenusItems < ActiveRecord::Migration
  def change
    create_table :menus_items do |t|

      t.integer :menu_id
      t.integer :item_id
      t.integer :quantity

    end
  end
end
