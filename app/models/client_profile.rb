class ClientProfile < ActiveRecord::Base

  has_many :users
  has_many :locations

  validates :key, :presence => true
  validates :value, :presence => true
  validates :user_id, :presence => true

  validates_associated :locations

  accepts_nested_attributes_for :locations

  attr_accessor :company_name, :nb_employee, :website, :phone
  attr_accessible :company_name, :nb_employee, :website, :phone, :locations_attributes



  SINGLEVALUE_KEYS = [
      :nb_employee, :company_name, :website, :phone
  ]

  MULTIVALUE_KEYS = [
  ]

  KEYS = SINGLEVALUE_KEYS + MULTIVALUE_KEYS

end
