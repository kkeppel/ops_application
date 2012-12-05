class AddVendorIdToMenus < ActiveRecord::Migration
  def change
    add_column :menus, :vendor_id, :integer
    remove_column :items_menus, :id
  end
end
