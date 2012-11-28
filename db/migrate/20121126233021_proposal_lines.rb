class ProposalLines < ActiveRecord::Migration
  def up
    create_table :proposal_lines do |t|
      t.integer :quantity
      t.string :description
      t.integer :total
      t.boolean :taxed
      t.string :name
      t.integer :price
      t.boolean :hot
      t.boolean :allergen_free
      t.integer :headcount
      t.integer :proposal_id
      t.integer :item_id

      t.timestamps
    end

    add_index :proposal_lines, :proposal_id
    add_index :proposal_lines, :item_id

  end

  def down
    drop_table :proposal_lines
  end
end
