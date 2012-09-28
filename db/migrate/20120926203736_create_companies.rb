class CreateCompanies < ActiveRecord::Migration
  def change
    create_table :companies do |t|
      t.string :company_name
      t.string :website
      t.integer :nb_employee
      t.string :phone

      t.timestamps
    end
    add_index :companies, :company_name
  end
end
