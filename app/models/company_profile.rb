class CompanyProfile < ActiveRecord::Base

  belongs_to :company

  validates :key, :presence => true
  validates :value, :presence => true
  validates :user_id, :presence => true

  attr_accessible :key, :value, :value2

  SINGLEVALUE_KEYS = [
        :preference, :allergies, :favorite_foods
  ]

  MULTIVALUE_KEYS = [
  ]

  KEYS = SINGLEVALUE_KEYS + MULTIVALUE_KEYS

end
