class CreateAllergensTable < ActiveRecord::Migration
  def up
    create_table :allergens do |t|
      t.string :name

      t.timestamps
    end
  end

  def down
    drop_table :allergens
  end
end
