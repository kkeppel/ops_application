class MealType < ActiveRecord::Base
  belongs_to :meal

  attr_accessible :name, :start_time, :end_time
end
