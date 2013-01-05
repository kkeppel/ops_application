class Contact < ActiveRecord::Base
  belongs_to :company
  belongs_to :location
  belongs_to :vendor
  belongs_to :payment_type

  attr_accessible :first_name, :last_name, :email, :direct_phone, :mobile_phone, :carrier, :title, :default_contact,
                  :default_invoiced, :was_lead, :company_id, :vendor_id, :location_id,
                  :work_email, :fax, :payment_type_id, :company

  def self.title_options
    options = [
      ["Mr.", "Mr."],
      ["Mrs.", "Mrs."],
      ["Ms.", "Ms."],
      ["Herr", "Herr"],
      ["Frau", "Fraue"]
    ]
    return options
  end

  def self.carrier_options
    options = [
      ["Verizon", "Verizon"],
      ["AT\&T", "AT&T"],
      ["Sprint", "Sprint"],
      ["T-Mobile", "T-Mobile"],
      ["Boost Mobile", "Boost Mobile"],
      ["Cricket", "Cricket"],
      ["Virgin Mobile", "Virgin Mobile"],
      ["U.S. Cellular", "U.S. Cellular"],
      ["Metro PCS", "Metro PCS"]
    ]
    return options
  end

end
