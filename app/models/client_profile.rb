class ClientProfile < ActiveRecord::Base

  validates :key, :presence => true
  validates :value, :presence => true
  validates :user_id, :presence => true


  SINGLEVALUE_KEYS = [

  ]

  MULTIVALUE_KEYS = [
  ]

  KEYS = SINGLEVALUE_KEYS + MULTIVALUE_KEYS

end
