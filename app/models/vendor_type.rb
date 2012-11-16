class VendorType < ActiveRecord::Base
  has_one :vendor

  attr_accessible :name, :description
end
