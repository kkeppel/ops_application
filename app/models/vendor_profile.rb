class VendorProfile < ActiveRecord::Base

  validates :key, :presence => true
  validates :value, :presence => true
  #validates :vendor_type_id => true
  #validates :user_id => true

end
