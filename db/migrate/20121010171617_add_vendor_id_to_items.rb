class AddVendorIdToItems < ActiveRecord::Migration
  def change
    add_column :items, :vendor_id, :integer, :null => false
    add_index :items, :vendor_id
  end
end
