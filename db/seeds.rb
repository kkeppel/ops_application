# This file should contain all the record creation needed to seed the database with its default values.
# The data can then be loaded with the rake db:seed (or created alongside the db with db:setup).
#
# Examples:
#
#   cities = City.create([{ name: 'Chicago' }, { name: 'Copenhagen' }])
#   Mayor.create(name: 'Emanuel', city: cities.first)

#c2me
Role.find_or_create_by_name(name: "admin", description: "Can do everything in his own city")
Role.find_or_create_by_name(name: "ops", description: "ops team of cater2.me")
Role.find_or_create_by_name(name: "sales", description: "sales team of cater2.me")
#company
Role.find_or_create_by_name(name: "client_contact", description: "Can access data of his company")
Role.find_or_create_by_name(name: "employee", description: "employee of the company, can access dashboard")
#vendor
Role.find_or_create_by_name(name: "vendor", description: "Owner of the restaurants, can admin his businesses")
Role.find_or_create_by_name(name: "delivery_staff", description: "Deliver food. Get access to the delivery list")


State.find_or_create_by_name([
  {:name => 'Alabama', :code => 'AL'},
  {:name => 'Alaska', :code => 'AK'},
  {:name => 'Arizona', :code => 'AZ'},
  {:name => 'Arkansas', :code => 'AR'},
  {:name => 'California', :code => 'CA'},
  {:name => 'Colorado', :code => 'CO'},
  {:name => 'Connecticut', :code => 'CT'},
  {:name => 'Delaware', :code => 'DE'},
  {:name => 'Florida', :code => 'FL'},
  {:name => 'Georgia', :code => 'GA'},
  {:name => 'Hawaii', :code => 'HI'},
  {:name => 'Idaho', :code => 'ID'},
  {:name => 'Illinois', :code => 'IL'},
  {:name => 'Indiana', :code => 'IN'},
  {:name => 'Kansas', :code => 'KS'},
  {:name => 'Kentucky', :code => 'KY'},
  {:name => 'Louisiana', :code => 'LA'},
  {:name => 'Maine', :code => 'ME'},
  {:name => 'Maryland', :code => 'MD'},
  {:name => 'Massachusetts', :code => 'MA'},
  {:name => 'Michigan', :code => 'MI'},
  {:name => 'Minnesota', :code => 'MN'},
  {:name => 'Mississippi', :code => 'MS'},
  {:name => 'Missouri', :code => 'MO'},
  {:name => 'Montana', :code => 'MT'},
  {:name => 'Nebraska', :code => 'NE'},
  {:name => 'Nevada', :code => 'NV'},
  {:name => 'New Hampshire', :code => 'NH'},
  {:name => 'New Mexico', :code => 'NM'},
  {:name => 'New York', :code => 'NY'},
  {:name => 'New Jersey', :code => 'NJ'},
  {:name => 'North Carolina', :code => 'NC'},
  {:name => 'North Dakota', :code => 'ND'},
  {:name => 'Ohio', :code => 'OH'},
  {:name => 'Oklahoma', :code => 'OK'},
  {:name => 'Oregon', :code => 'OR'},
  {:name => 'Pennsylvania', :code => 'PA'},
  {:name => 'Rhode Island', :code => 'RI'},
  {:name => 'South Carolina', :code => 'SC'},
  {:name => 'South Dakota', :code => 'SD'},
  {:name => 'Tennessee', :code => 'TN'},
  {:name => 'Texas', :code => 'TX'},
  {:name => 'Utah', :code => 'UT'},
  {:name => 'Vermont', :code => 'VT'},
  {:name => 'Virginia', :code => 'VA'},
  {:name => 'Washington', :code => 'WA'},
  {:name => 'West Virginia', :code => 'WV'},
  {:name => 'Wisconsin', :code => 'WI'},
  {:name => 'Wyoming', :code => 'WY'},
  {:name => 'Wisconsin', :code => 'WI'}
])

City.find_or_create_by_name(:name => "San Francisco", :zipcode => "94100", :tax_rate => "8.5", :state_id => 5)