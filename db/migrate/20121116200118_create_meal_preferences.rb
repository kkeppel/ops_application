class CreateMealPreferences < ActiveRecord::Migration
  def change
    create_table :meal_preferences do |t|
      t.integer :percentage
      t.integer :meal_id
      t.integer :ingredient_id

      t.timestamps
    end

    add_index :meal_preferences, :meal_id
    add_index :meal_preferences, :ingredient_id

  end
end
