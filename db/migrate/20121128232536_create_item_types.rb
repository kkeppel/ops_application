class CreateItemTypes < ActiveRecord::Migration
  def change
    create_table :item_types do |t|
      t.string :name
      t.string :description
      t.integer :order

      t.timestamps
    end
  end
end
