class ChangeUserIdToVendorIdInVendorProfiles < ActiveRecord::Migration
  def change
    rename_column :vendor_profiles, :user_id, :vendor_id
  end
end
