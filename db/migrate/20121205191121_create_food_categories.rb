class CreateFoodCategories < ActiveRecord::Migration
  def change
    create_table :food_categories do |t|
      t.string :name
      t.string :description

      t.timestamps
    end
  end
end
