class AddStateAndZipToLocations < ActiveRecord::Migration
  def change
    add_column :locations, :state, :string, :limit => 2
    add_column :locations, :zip, :string, :limit => 10
  end
end
