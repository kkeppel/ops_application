class ChangeConfirmationDateDataType < ActiveRecord::Migration
  def change
    change_column :users, :confirmed_at, :datetime
    change_column :users, :confirmation_sent_at, :datetime
  end

end
