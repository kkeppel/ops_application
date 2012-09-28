class CreateVendors < ActiveRecord::Migration
  def change
    create_table :vendors do |t|
      t.string :name
      t.string :public_name
      t.text :tagline
      t.string :website
      t.text :bio
      t.integer :vendor_type

      t.timestamps
    end
    add_index  :vendors, :public_name
  end
end
