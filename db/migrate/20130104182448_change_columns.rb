class ChangeColumns < ActiveRecord::Migration
  def change
    remove_column :meal_types, :description
    add_column :meal_types, :start_time, :datetime
    add_column :meal_types, :end_time, :datetime

    remove_column :payment_types, :description
    add_column :payment_types, :fee, :float

    rename_column :companies, :name, :name
  end
end
