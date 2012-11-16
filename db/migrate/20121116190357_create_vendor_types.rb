class CreateVendorTypes < ActiveRecord::Migration
  def up
    create_table :vendor_types do |t|
      t.string :name
      t.string :description
    end
  end

  def down
    drop_table :vendor_types
  end
end
