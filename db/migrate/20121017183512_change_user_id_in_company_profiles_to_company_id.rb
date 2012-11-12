class ChangeUserIdInCompanyProfilesToCompanyId < ActiveRecord::Migration
  def change
    rename_column :company_profiles, :user_id, :company_id
  end
end
