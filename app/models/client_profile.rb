class ClientProfile < ActiveRecord::Base

  validates :key, :presence => true
  validates :value, :presence => true
  validates :user_id, :presence => true

  attr_accessor :company_name, :nb_employee, :website

  has_many :users
  has_many :locations

  SINGLEVALUE_KEYS = [
      :nb_employee, :company_name, :website, :phone, :invoice_email, :calendar_version, :if_same_day_appointments
  ]

  MULTIVALUE_KEYS = [
  ]

  KEYS = SINGLEVALUE_KEYS + MULTIVALUE_KEYS

end
