class Meal < ActiveRecord::Base
  has_many :meal_profiles, :foreign_key => :meal_id
  has_one :meal_preference # I guess? Gotta read up on this.. doesn't really make sense...
  has_and_belongs_to_many :allergens
  belongs_to :location
  belongs_to :meal_type
  belongs_to :company
  attr_accessible :name, :headcount, :max_price, :serving_time, :active, :private, :default, :location_id,
                  :company_profile_id, :meal_type_id, :company_id, :allergen_ids,
                  #meal_profile fields
                  :meal_id, :contact_id, :default, :active, :scheduled, :day, :time, :vegetarians, :vegans, :kosher,
                  :beverages, :utensils, :serving_trays, :paperware, :folding_tables, :tablecloths, :title

  MealProfile::KEYS.each{|k|
    define_method("#{k}_obj") {
      values = meal_profiles.where(:key => k)
      if MealProfile::MULTIVALUE_KEYS.include?(k)
        values
      else
        instance_variable_get("@#{k}_obj").blank? ? values.first : instance_variable_get("@#{k}_obj")
      end
    }
    define_method(k) {
      values = meal_profiles.where(:key => k)
      if MealProfile::MULTIVALUE_KEYS.include?(k)
        values.map(&:value)
      else
        instance_variable_get("@#{k}").nil? ? (values.first.try(:value) || '') : instance_variable_get("@#{k}")
      end
    }
    define_method("#{k}=") {|parameter|
      instance_variable_set("@#{k}", parameter)
      unless parameter.blank?
        profile_record = meal_profiles.build(:key => k, :value => parameter.try(:to_s).try(:strip), :meal_id => id)
        profile_record.save unless new_record?
      end
    }
  }
  MealProfile::KEYS.each{|k|
    define_method("add_#{k}") {|parameter, value_2 = nil, id|
      profile_record = meal_profiles.build(:key => k, :value => parameter.try(:to_s).try(:strip), :value2 => value_2.try(:to_s).try(:strip), :meal_id => id)
      profile_record.save unless new_record?
    }
  }


  def update_profile(params, meal_id = nil)
    params['meal'].try(:each){|key, value|
      key = key.to_sym
      if MealProfile::KEYS.include?(key)
        if value.is_a?(Array)
          value.each{|v|
            send("add_#{key}", v, meal_id) unless v.blank?
          }
        elsif value.is_a?(Hash)
          value.each_with_index{|v,i|
            send("add_#{key}", v[1], value.try(:[],i), meal_id) unless v.blank?
          }
        else
          meal_profiles.where(:key => key).delete_all
          send("#{key}=", value)
        end
      end
    }
  end

end
