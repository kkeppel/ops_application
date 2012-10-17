class Company < ActiveRecord::Base

  has_many :clients
  has_many :locations
  has_many :company_profiles, :foreign_key => :user_id

  validates :company_name, :presence => true
  validates :nb_employee, :presence => true

  validates_associated :locations

  accepts_nested_attributes_for :locations



  attr_accessible :company_name, :nb_employee, :website, :phone, :locations_attributes,
                  :allergies, :favorite_foods # add attributes here for the key-value pairs in CompanyProfile

  CompanyProfile::KEYS.each{|k|
    define_method("#{k}_obj") {
      values = company_profiles.where(:key => k)
      if ExpertApplicationProfile::MULTIVALUE_KEYS.include?(k)
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
        profile_record = company_profiles.build(:key => k, :value => parameter.try(:to_s).try(:strip))
        profile_record.save unless new_record?
      end
    }
  }
  CompanyProfile::MULTIVALUE_KEYS.each{|k|
    define_method("add_#{k}") {|parameter, value_2 = nil|
      profile_record = company_profiles.build(:key => k, :value => parameter.try(:to_s).try(:strip), :value2 => value_2.try(:to_s).try(:strip))
      profile_record.save unless new_record?
    }
  }


  def update_profile(params)
    params['company'].try(:each){|key, value|
      if CompanyProfile::KEYS.include?(key)
        if value.is_a?(Array)
          company_profiles.delete(company_profiles.where(:key => key))
          value.each{|v|
            send("add_#{key}", v) unless v.blank?
          }
        elsif value.is_a?(Hash)
          company_profiles.delete(company_profiles.where(:key => key))
          value[:value].each_with_index{|v,i|
            send("add_#{key}", v, value[:additional_values].try(:[],i), value[:value_2].try(:[], i)) unless v.blank?
          }
        else
          send("#{key}=", value)
        end
      end
    }
  end

end
