class City < ActiveRecord::Base

  has_many :locations

  attr_accessible :lat, :long, :name, :state_id, :tax_rate, :zipcode

end
