class AddVendorTypeForeignKeyToVendors < ActiveRecord::Migration
  def change
    add_index :vendors, :vendor_type_id
  end
end
