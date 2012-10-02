# encoding: UTF-8
# This file is auto-generated from the current state of the database. Instead
# of editing this file, please use the migrations feature of Active Record to
# incrementally modify your database, and then regenerate this schema definition.
#
# Note that this schema.rb definition is the authoritative source for your
# database schema. If you need to create the application database on another
# system, you should be using db:schema:load, not running all the migrations
# from scratch. The latter is a flawed and unsustainable approach (the more migrations
# you'll amass, the slower it'll run and the greater likelihood for issues).
#
# It's strongly recommended to check this file into your version control system.

ActiveRecord::Schema.define(:version => 20121001212356) do

  create_table "cities", :force => true do |t|
    t.string  "name"
    t.integer "zipcode"
    t.float   "tax_rate"
    t.string  "long"
    t.string  "lat"
    t.integer "state_id"
  end

  add_index "cities", ["state_id"], :name => "index_cities_on_state_id"
  add_index "cities", ["zipcode"], :name => "index_cities_on_zipcode"

  create_table "client_profiles", :force => true do |t|
    t.string   "key"
    t.text     "value"
    t.text     "value2"
    t.datetime "created_at", :null => false
    t.datetime "updated_at", :null => false
  end

  create_table "companies", :force => true do |t|
    t.string   "company_name"
    t.string   "website"
    t.integer  "nb_employee"
    t.string   "phone"
    t.datetime "created_at",   :null => false
    t.datetime "updated_at",   :null => false
  end

  add_index "companies", ["company_name"], :name => "index_companies_on_company_name"

  create_table "locations", :force => true do |t|
    t.string   "name"
    t.string   "address1"
    t.string   "address2"
    t.integer  "floor"
    t.integer  "city_id"
    t.integer  "vendor_id"
    t.integer  "company_id"
    t.datetime "created_at", :null => false
    t.datetime "updated_at", :null => false
  end

  add_index "locations", ["city_id"], :name => "index_locations_on_city_id"
  add_index "locations", ["company_id"], :name => "index_locations_on_client_profile_id"
  add_index "locations", ["vendor_id"], :name => "index_locations_on_vendor_profile_id"

  create_table "roles", :force => true do |t|
    t.string   "name"
    t.text     "description"
    t.datetime "created_at",  :null => false
    t.datetime "updated_at",  :null => false
  end

  create_table "roles_users", :id => false, :force => true do |t|
    t.integer "role_id"
    t.integer "user_id"
  end

  create_table "staffs", :force => true do |t|
    t.datetime "created_at", :null => false
    t.datetime "updated_at", :null => false
  end

  create_table "states", :force => true do |t|
    t.string "name"
    t.string "code"
  end

  create_table "users", :force => true do |t|
    t.string   "email",                                :default => "",    :null => false
    t.string   "encrypted_password",                   :default => "",    :null => false
    t.string   "reset_password_token"
    t.datetime "reset_password_sent_at"
    t.datetime "remember_created_at"
    t.integer  "sign_in_count",                        :default => 0
    t.datetime "current_sign_in_at"
    t.datetime "last_sign_in_at"
    t.string   "current_sign_in_ip"
    t.string   "last_sign_in_ip"
    t.datetime "created_at",                                              :null => false
    t.datetime "updated_at",                                              :null => false
    t.string   "first_name",             :limit => 50
    t.string   "last_name",              :limit => 50
    t.string   "title"
    t.string   "fax_number",             :limit => 20
    t.boolean  "newsletter",                           :default => false
    t.boolean  "active",                               :default => true
    t.boolean  "is_client",                            :default => false
    t.boolean  "is_vendor",                            :default => false
    t.integer  "client_profile_id"
    t.integer  "vendor_profile_id"
    t.string   "confirmation_token"
    t.string   "unconfirmed_email"
    t.datetime "confirmed_at"
    t.datetime "confirmation_sent_at"
  end

  add_index "users", ["client_profile_id"], :name => "index_users_on_client_profile_id"
  add_index "users", ["email"], :name => "index_users_on_email", :unique => true
  add_index "users", ["reset_password_token"], :name => "index_users_on_reset_password_token", :unique => true
  add_index "users", ["vendor_profile_id"], :name => "index_users_on_vendor_profile_id"

  create_table "vendor_profiles", :force => true do |t|
    t.string   "key"
    t.text     "value"
    t.text     "value2"
    t.integer  "vendor_type_id"
    t.datetime "created_at",     :null => false
    t.datetime "updated_at",     :null => false
  end

  add_index "vendor_profiles", ["key"], :name => "index_vendor_profiles_on_key"
  add_index "vendor_profiles", ["vendor_type_id"], :name => "index_vendor_profiles_on_vendor_type_id"

  create_table "vendors", :force => true do |t|
    t.string   "name"
    t.string   "public_name"
    t.text     "tagline"
    t.string   "website"
    t.text     "bio"
    t.integer  "vendor_type"
    t.datetime "created_at",  :null => false
    t.datetime "updated_at",  :null => false
  end

  add_index "vendors", ["public_name"], :name => "index_vendors_on_public_name"

end
