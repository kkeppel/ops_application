class AddColumnsForCompanies < ActiveRecord::Migration
  def change
    add_column :companies, :commission_id, :integer
    add_column :companies, :fee, :float
    add_column :companies, :notes, :text
    add_column :companies, :default_tip, :float
    add_column :companies, :planning_type_id, :integer

    add_column :locations, :cross_streets, :string
    add_column :locations, :delivery_zone_id, :integer

    add_column :contacts, :work_email, :string
    add_column :contacts, :fax, :string
    add_column :contacts, :floor, :string, limit: 4
    add_column :contacts, :payment_frequency_id, :integer
  end
end
