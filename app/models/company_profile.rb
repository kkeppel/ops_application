class CompanyProfile < ActiveRecord::Base

  belongs_to :company

  #validates :key, :presence => true
  #validates :value, :presence => true
  #validates :company_id, :presence => true

  attr_accessible :key, :value, :value2, :company_id, :allergies

  SINGLEVALUE_KEYS = [
    :favorite_foods
  ]

  MULTIVALUE_KEYS = [
    :allergies
  ]

  KEYS = SINGLEVALUE_KEYS + MULTIVALUE_KEYS

end
