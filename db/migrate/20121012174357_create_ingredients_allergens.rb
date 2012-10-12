class CreateIngredientsAllergens < ActiveRecord::Migration
  def change
    create_table :ingredients_allergens do |t|

      t.integer :ingredients_id
      t.integer :allergens_id
    end
  end
end
