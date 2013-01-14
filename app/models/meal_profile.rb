class MealProfile < ActiveRecord::Base
  belongs_to :meal

  attr_accessible :key, :value, :value2, :meal_id

  BOOL_TYPE = [
    :default, :active, :scheduled, :beverages, :utensils, :serving_trays, :paperware, :folding_tables, :tablecloths
  ]

  SELECT_TYPE = [

  ]

  INTEGER_TYPE = [
    :vegetarians, :vegans, :kosher
  ]

  TEXT_TYPE = [
    :title
  ]

  SINGLEVALUE_KEYS = [
    :title, :contact_id, :default, :active, :scheduled, :day, :time, :vegetarians, :vegans, :kosher,
    :beverages, :utensils, :serving_trays, :paperware, :folding_tables, :tablecloths
  ]

  MULTIVALUE_KEYS = [

  ]

  KEYS = SINGLEVALUE_KEYS + MULTIVALUE_KEYS

end
