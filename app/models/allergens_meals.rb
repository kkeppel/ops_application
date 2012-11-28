class AllergensMeals < ActiveRecord::Base
  belongs_to :allergen
  belongs_to :meal
  attr_accessible :allergen_id, :meal_id

  def self.add_allergens(params, meal_id)
    new_record = self.new(allergen_id: params, meal_id: meal_id)
    new_record.save
  end

end
