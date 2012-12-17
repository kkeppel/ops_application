class Company < ActiveRecord::Base

  has_many :clients
  has_many :locations
  has_many :contacts
  has_many :meals
  has_many :meal_profiles, :through => :meals
  has_many :company_profiles, :foreign_key => :company_id


  validates_associated :locations

  accepts_nested_attributes_for :locations



  attr_accessible :company_name, :nb_employee, :website, :phone, :locations_attributes, :company_id,
                  :allergies, :favorite_foods # add attributes here for the key-value pairs in CompanyProfile


  CompanyProfile::KEYS.each{|k|
    define_method("#{k}_obj") {
      values = company_profiles.where(:key => k)
      if CompanyProfile::MULTIVALUE_KEYS.include?(k)
        values
      else
        instance_variable_get("@#{k}_obj").blank? ? values.first : instance_variable_get("@#{k}_obj")
      end
    }
    define_method(k) {
      values = company_profiles.where(:key => k)
      if CompanyProfile::MULTIVALUE_KEYS.include?(k)
        values.map(&:value)
      else
        instance_variable_get("@#{k}").nil? ? (values.first.try(:value) || '') : instance_variable_get("@#{k}")
      end
    }
    define_method("#{k}=") {|parameter|
      company_profiles.delete(company_profiles.where(:key => k))
      instance_variable_set("@#{k}", parameter)
      unless parameter.blank?
        profile_record = company_profiles.build(:key => k, :value => parameter.try(:to_s).try(:strip), :company_id => id)
        profile_record.save unless new_record?
      end
    }
  }
  CompanyProfile::KEYS.each{|k|
    define_method("add_#{k}") {|parameter, value_2 = nil, id|
      profile_record = company_profiles.build(:key => k, :value => parameter.try(:to_s).try(:strip), :value2 => value_2.try(:to_s).try(:strip), :company_id => id)
      profile_record.save unless new_record?
    }
  }


  def update_profile(params, company_id = nil)
    params['company'].try(:each){|key, value|
      key = key.to_sym
      if CompanyProfile::KEYS.include?(key)
        if value.is_a?(Array)
          company_profiles.delete(company_profiles.where(:key => key))
          value.each{|v|
            send("add_#{key}", v, company_id) unless v.blank?
            send("add_#{key}", v, company_id) unless v.blank?
          }
        elsif value.is_a?(Hash)
          company_profiles.delete(company_profiles.where(:key => key))
          value.each_with_index{|v,i|
            send("add_#{key}", v[1], value.try(:[],i), company_id) unless v.blank?
          }
        else
          company_profiles.delete(company_profiles.where(:key => key))
          send("#{key}=", value, params[:id])
        end
      end
    }
  end


end
