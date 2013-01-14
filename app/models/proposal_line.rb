class ProposalLine < ActiveRecord::Base
  belongs_to :proposal

  attr_accessible :quantity, :description, :total, :taxed, :name, :price, :hot, :allergen_free, :headcount,
                  :proposal_id, :item_id, :created_at, :updated_at
end
