class CreateContacts < ActiveRecord::Migration
  def change
    create_table :contacts do |t|
      t.string :first_name
      t.string :last_name
      t.string :email
      t.string :direct_phone
      t.string :mobile_phone
      t.string :carrier
      t.string :title
      t.boolean :default_contact
      t.boolean :default_invoiced
      t.boolean :was_lead
      t.integer :payment_type_id
      t.integer :company_id
      t.integer :vendor_id
      t.integer :location_id

      t.timestamps
    end
  end
end
