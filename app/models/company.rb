class Company < ActiveRecord::Base

  has_many :users
  has_many :locations

  validates :company_name, :presence => true
  validates :nb_employee, :presence => true

  validates_associated :locations

  accepts_nested_attributes_for :locations

  attr_accessible :company_name, :nb_employee, :website, :phone, :locations_attributes

end
