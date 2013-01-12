class Order < ActiveRecord::Base
  has_and_belongs_to_many :tags
  has_many :proposals
  has_many :proposal_lines, :through => :proposals

  attr_accessible :company_id, :vendor_id, :meal_id, :proposals_attributes, :name, :tip, :proposal_line

	accepts_nested_attributes_for :proposals, :proposal_lines
end
