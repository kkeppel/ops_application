class CreateLocations < ActiveRecord::Migration
  def change
    create_table :locations do |t|
      t.string :name
      t.string :address1
      t.string :address2
      t.integer :floor
      t.integer :city_id
      t.integer :vendor_profile_id
      t.integer :client_profile_id

      t.timestamps
    end
    add_index :locations, :city_id
    add_index :locations, :vendor_profile_id
    add_index :locations, :client_profile_id
  end
end
