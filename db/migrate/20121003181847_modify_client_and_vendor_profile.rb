class ModifyClientAndVendorProfile < ActiveRecord::Migration
  def change
    remove_column :users, :vendor_profile_id
    remove_column :users, :client_profile_id
    add_column :client_profiles, :user_id, :integer, :null => false
    add_column :vendor_profiles, :user_id, :integer, :null => false
    add_index :client_profiles, :user_id
    add_index :vendor_profiles, :user_id
  end
end
