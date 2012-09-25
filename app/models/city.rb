class City < ActiveRecord::Base
  attr_accessible :lat, :long, :name, :state_id, :tax_rate, :zipcode
end
