class ProposalStatus < ActiveRecord::Base
  has_many :proposals

  attr_accessible :name, :description
end
