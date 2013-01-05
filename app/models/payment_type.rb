class PaymentType < ActiveRecord::Base
  has_many :contacts

  attr_accessible :name, :fee
end
