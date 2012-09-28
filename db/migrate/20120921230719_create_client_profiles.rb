class CreateClientProfiles < ActiveRecord::Migration
  def change
    create_table :client_profiles do |t|
      t.string :key
      t.text :value
      t.text :value2
      t.integer :user_id

      t.timestamps
    end
    add_index :client_profiles, :user_id
    add_index :client_profiles, :key
  end
end
