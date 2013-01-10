class Proposal < ActiveRecord::Base
  has_many :proposal_lines, dependent: :destroy

  attr_accessible :service_fee, :percentage_fee, :total_pre_taxes, :total_wtaxes, :total, :vendor_tip, :price_per_person,
                  :vendor_confirmed, :client_confirmed, :vendor_id, :proposal_status_id, :menu_id, :item_id, :order_id

  validates_associated :proposal_lines

  accepts_nested_attributes_for :proposal_lines, allow_destroy: true
end
