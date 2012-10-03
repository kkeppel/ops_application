class RenameClientProfileToCompanyProfile < ActiveRecord::Migration
  def up
    rename_table :client_profiles, :company_profiles
  end

  def down
    rename_table :company_profiles, :client_profiles
  end
end
