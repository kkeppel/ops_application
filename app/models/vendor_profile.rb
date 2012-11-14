class VendorProfile < ActiveRecord::Base

  belongs_to :vendor

  #validates :key, :presence => true
  #validates :value, :presence => true

  attr_accessible :key, :value, :value2, :vendor_id

  SINGLEVALUE_KEYS = [
    :preferences
  ]

  MULTIVALUE_KEYS = [

  ]

  KEYS = SINGLEVALUE_KEYS + MULTIVALUE_KEYS

end
