class Location < ActiveRecord::Base

  belongs_to :company
  belongs_to :vendor
  belongs_to :city

  accepts_nested_attributes_for :city, :reject_if => proc { |attributes| attributes['name'].blank? }

  attr_accessible :address1, :address2, :city_id, :client_profile_id, :floor, :name,
                  :perimeter, :time_required, :vendor_profile_id, :city_attributes, :vendor_id, :company_id

  validates :address1, :presence => true
  validates :address2, :presence => true
  validates :name, :presence => true
  validates :floor, :presence => true



end
