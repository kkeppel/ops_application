class AddCompanyIdToUsers < ActiveRecord::Migration
  def change
    add_column :users, :company_id, :integer
    add_index :users, :company_id
    add_column :users, :vendor_id, :integer
    add_index :users, :vendor_id
  end
end
