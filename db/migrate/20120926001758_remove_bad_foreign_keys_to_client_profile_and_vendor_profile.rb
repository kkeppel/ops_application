class RemoveBadForeignKeysToClientProfileAndVendorProfile < ActiveRecord::Migration
  def change
    remove_column :client_profiles, :user_id
    remove_column :vendor_profiles, :user_id
    add_column :users, :client_profile_id, :integer
    add_column :users, :vendor_profile_id, :integer
    add_index :users, :client_profile_id
    add_index :users, :vendor_profile_id
  end
end
