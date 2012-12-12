class Contact < ActiveRecord::Base
  belongs_to :companies
  belongs_to :locations
  belongs_to :vendors

  attr_accessible :first_name, :last_name, :email, :direct_phone, :mobile_phone, :carrier, :title, :default_contact,
                  :default_invoiced, :was_lead, :company_id, :vendor_id, :location_id #:payment_type_id
end
