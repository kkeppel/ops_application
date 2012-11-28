class CreateAllergensMeals < ActiveRecord::Migration
  def change
    create_table :allergens_meals, id: false do |t|
      t.integer :allergen_id
      t.integer :meal_id
    end
  end
end
