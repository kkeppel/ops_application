class CreateOrders < ActiveRecord::Migration
  def change
    create_table :orders do |t|
      t.string :name
      t.string :tip
      t.integer :meal_id
      t.integer :company_id
      t.integer :location_id

      t.timestamps
    end

    add_index :orders, :company_id
    add_index :orders, :meal_id
    add_index :orders, :location_id

  end
end
