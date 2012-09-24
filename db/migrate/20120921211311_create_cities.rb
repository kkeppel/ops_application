class CreateCities < ActiveRecord::Migration
  def change
    create_table :cities do |t|
      t.string :name
      t.integer :zipcode
      t.float :tax_rate
      t.string :long
      t.string :lat
      t.integer :state_id
    end
    add_index :cities, :state_id
    add_index :cities, :zipcode
  end
end
