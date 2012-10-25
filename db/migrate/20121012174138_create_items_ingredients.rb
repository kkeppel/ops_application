class CreateItemsIngredients < ActiveRecord::Migration
  def change
    create_table :ingredients_items do |t|
      t.integer :item_id
      t.integer :ingredient_id
    end
  end
end
