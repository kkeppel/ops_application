class ChangeForeignKeyOnLocation < ActiveRecord::Migration
  def change
    rename_column :locations, :client_profile_id, :company_id
    rename_column :locations, :vendor_profile_id, :vendor_id
  end

end
