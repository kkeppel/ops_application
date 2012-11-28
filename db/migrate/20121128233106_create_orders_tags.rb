class CreateOrdersTags < ActiveRecord::Migration
  def change
    create_table :orders_tags, id: false do |t|
      t.integer :tag_id
      t.integer :order_id
    end
  end
end
