class CreateMealProfiles < ActiveRecord::Migration
  def change
    create_table :meal_profiles do |t|
      t.string :key
      t.string :value
      t.string :value2
      t.integer :meal_id

      t.timestamps
    end

    add_index :meal_profiles, :meal_id

  end
end
