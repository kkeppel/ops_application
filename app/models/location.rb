class Location < ActiveRecord::Base

  belongs_to :company
  belongs_to :vendor
  belongs_to :city
  has_many :meals
  has_many :contacts

  accepts_nested_attributes_for :city, :reject_if => proc { |attributes| attributes['name'].blank? }

  attr_accessible :address1, :address2, :city_id, :client_profile_id, :floor, :name,
                  :perimeter, :time_required, :vendor_profile_id, :city_attributes, :vendor_id, :company_id





end
