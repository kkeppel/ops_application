class AddOpsIdToCompany < ActiveRecord::Migration
  def change
	  add_column :companies, :manager_id, :integer
  end
end
