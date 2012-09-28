class Vendor < ActiveRecord::Base
  attr_accessible :bio, :name, :public_name, :tagline, :vendor_type, :website
end
