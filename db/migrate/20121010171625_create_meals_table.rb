class CreateMealsTable < ActiveRecord::Migration
  def up
    create_table :meals do |t|
      t.string  :name
      t.integer :headcount
      t.float   :max_price
      t.string  :serving_time
      t.boolean :active, :null => false, :default => true
      t.boolean :private
      t.boolean :default, :null => false, :default => false
      t.integer :location_id, :null => false
      t.integer :client_profile_id, :null => false
      t.integer :meal_type_id, :null => false

      t.timestamps
    end

    add_index :meals, :location_id
    add_index :meals, :client_profile_id
    add_index :meals, :meal_type_id
  end

  def down
    drop_table :meals
  end
end
