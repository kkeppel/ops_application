# This file should contain all the record creation needed to seed the database with its default values.
# The data can then be loaded with the rake db:seed (or created alongside the db with db:setup).
#
# Examples:
#
#   cities = City.create([{ name: 'Chicago' }, { name: 'Copenhagen' }])
#   Mayor.create(name: 'Emanuel', city: cities.first)

#c2me
Role.create(name: "admin", description: "Can do everything in his own city")
Role.create(name: "ops", description: "ops team of cater2.me")
Role.create(name: "sales", description: "sales team of cater2.me")
#company
Role.create(name: "office_manager", description: "Can access data of his company")
Role.create(name: "employee", description: "employee of the company, can access dashboard")
#vendor
Role.create(name: "vendor", description: "Owner of the restaurants, can admin his businesses")
Role.create(name: "carrier", description: "Deliver food. Get access to the delivery list")