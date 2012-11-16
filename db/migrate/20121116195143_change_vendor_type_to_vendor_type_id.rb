class ChangeVendorTypeToVendorTypeId < ActiveRecord::Migration
  def change
    rename_column :vendors, :vendor_type, :vendor_type_id
  end
end
