class Vendor < ActiveRecord::Base

  has_many :vendor_profiles, :foreign_key => :vendor_id
  belongs_to :vendor_type
  has_many :items

  attr_accessible :bio, :name, :public_name, :tagline, :vendor_type_id, :website, :vendor_id,
                  :preferences


  VendorProfile::KEYS.each{|k|
    define_method("#{k}_obj") {
      values = vendor_profiles.where(:key => k)
      if VendorProfile::MULTIVALUE_KEYS.include?(k)
        values
      else
        instance_variable_get("@#{k}_obj").blank? ? values.first : instance_variable_get("@#{k}_obj")
      end
    }
    define_method(k) {
      values = vendor_profiles.where(:key => k)
      if VendorProfile::MULTIVALUE_KEYS.include?(k)
        values.map(&:value)
      else
        instance_variable_get("@#{k}").nil? ? (values.first.try(:value) || '') : instance_variable_get("@#{k}")
      end
    }
    define_method("#{k}=") {|parameter|
      instance_variable_set("@#{k}", parameter)
      unless parameter.blank?
        profile_record = vendor_profiles.build(:key => k, :value => parameter.try(:to_s).try(:strip), :vendor_id => id)
        profile_record.save unless new_record?
      end
    }
  }
  VendorProfile::KEYS.each{|k|
    define_method("add_#{k}") {|parameter, value_2 = nil, id|
      profile_record = vendor_profiles.build(:key => k, :value => parameter.try(:to_s).try(:strip), :value2 => value_2.try(:to_s).try(:strip), :vendor_id => id)
      profile_record.save unless new_record?
    }
  }


  def update_profile(params, vendor_id = nil)
    params['vendor'].try(:each){|key, value|
      key = key.to_sym
      if VendorProfile::KEYS.include?(key)
        if value.is_a?(Array)
          value.each{|v|
            send("add_#{key}", v, vendor_id) unless v.blank?
          }
        elsif value.is_a?(Hash)
          value.each_with_index{|v,i|
            send("add_#{key}", v[1], value.try(:[],i), vendor_id) unless v.blank?
          }
        else
          send("#{key}=", value, params[:id])
        end
      end
    }
  end

end
