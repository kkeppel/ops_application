class ProposalStatuses < ActiveRecord::Migration
  def up
    create_table :proposal_statuses do |t|
      t.string :name
      t.string :description

      t.timestamps
    end
  end

  def down
    drop_table :proposal_statuses
  end
end
