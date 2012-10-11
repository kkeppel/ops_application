class CreateItemsTable < ActiveRecord::Migration
  def up
    create_table :items do |t|
      t.string  :name
      t.text    :description
      t.float   :price
      t.boolean :hot
      t.boolean :allergen_free
      t.integer :headcount
      t.integer :nb_time_used
      t.integer :serving_instructions_id, :null => false
      t.integer :vendor_profiles_id, :null => false

      t.timestamps
    end

    add_index :items, :vendor_profiles_id
    add_index :items, :serving_instructions_id
  end

  def down
    drop_table :items
  end
end
