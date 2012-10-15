class CreateMealTypes < ActiveRecord::Migration
  def change
    create_table :meal_types do |t|
      t.string :meal_type
      t.text :description

      t.timestamps
    end
  end
end
