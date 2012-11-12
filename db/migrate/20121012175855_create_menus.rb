class CreateMenus < ActiveRecord::Migration
  def change
    create_table :menus do |t|

      t.integer :headcount
      t.float :total
      t.float :total_per_head
      t.integer :food_category_id
      t.integer :vendor_profile_id

      t.timestamps
    end

  end
end
