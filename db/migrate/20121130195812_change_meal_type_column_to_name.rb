class ChangeMealTypeColumnToName < ActiveRecord::Migration
  def change
    rename_column :meal_types, :meal_type, :name
  end
end
