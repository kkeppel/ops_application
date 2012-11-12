class CreateIngredientsAllergens < ActiveRecord::Migration
  def change
    create_table :allergens_ingredients do |t|

      t.integer :ingredient_id
      t.integer :allergen_id
    end
  end
end
