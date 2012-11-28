class CreateProposals < ActiveRecord::Migration
  def up
    create_table :proposals do |t|
      t.float :service_fee
      t.integer :percentage_fee
      t.float :total_pre_taxes
      t.float :total_wtaxes
      t.float :total
      t.string :vendor_tip
      t.float :price_per_person
      t.boolean :vendor_confirmed
      t.boolean :client_confirmed
      t.integer :vendor_id
      t.integer :proposal_status_id
      t.integer :menu_id
      t.integer :item_id
      t.integer :order_id

      t.timestamps
    end

    add_index :proposals, :vendor_id
    add_index :proposals, :proposal_status_id
    add_index :proposals, :menu_id
    add_index :proposals, :item_id
    add_index :proposals, :order_id

  end

  def down
    drop_table :proposals
  end
end
