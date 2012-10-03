class Vendor < ActiveRecord::Base

  belongs_to :vendor_profile

  attr_accessible :bio, :name, :public_name, :tagline, :vendor_type, :website

  #default_scope where(:is_client => 0, :is_vendor => 1)

end
