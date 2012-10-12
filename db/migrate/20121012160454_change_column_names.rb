class ChangeColumnNames < ActiveRecord::Migration
  def change
    add_column :meals, :company_id, :integer
    rename_column :meals, :client_profile_id, :company_profile_id
  end
end
