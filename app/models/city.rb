class City < ActiveRecord::Base

  belongs_to :location

  attr_accessible :lat, :long, :name, :state_id, :tax_rate, :zipcode

end
