class CreateVendorProfiles < ActiveRecord::Migration
  def change
    create_table :vendor_profiles do |t|
      t.string :key
      t.text :value
      t.text :value2
      t.integer :user_id
      t.integer :vendor_type_id

      t.timestamps
    end
    add_index :vendor_profiles, :user_id
    add_index :vendor_profiles, :vendor_type_id
    add_index :vendor_profiles, :key
  end
end
