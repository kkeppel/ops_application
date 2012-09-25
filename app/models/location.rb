class Location < ActiveRecord::Base

  has_one :client_profile
  has_one :vendor_profile

  attr_accessible :address1, :address2, :city_id, :client_profile_id, :floor, :name, :perimeter, :time_required, :vendor_profile_id

  validates :address1, :presence => true
  validates :city_id, :presence => true
  validates :name, :presence => true


end
