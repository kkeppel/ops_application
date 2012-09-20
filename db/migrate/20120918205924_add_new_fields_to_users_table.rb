class AddNewFieldsToUsersTable < ActiveRecord::Migration
  def change
     add_column :users, :first_name, :string, :limit => 50
     add_column :users, :last_name, :string , :limit => 50
     add_column :users, :title, :string
     add_column :users, :fax_number, :string, :limit => 20
     add_column :users, :newsletter, :boolean, :default => false
     add_column :users, :active, :boolean, :default => true
     add_column :users, :is_client, :boolean, :default => false
     add_column :users, :is_vendor, :boolean, :default => false
  end
end
