class AddTimestampsToVendorTypes < ActiveRecord::Migration
  def change
    add_column :vendor_types, :created_at, :timestamp
    add_column :vendor_types, :updated_at, :timestamp
  end
end
