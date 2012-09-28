class Client < User

  belongs_to :client_profile

  default_scope where(:is_client => 1)

  ClientProfile::KEYS.each{|k|
    define_method(k) {
      values = client_profile.where(:key => k)
      if ClientProfile::MULTIVALUE_KEYS.include?(k)
        values.map(&:value)
      else
        instance_variable_get("@#{k}").nil? ? (values.first.try(:value) || '') : instance_variable_get("@#{k}")
      end
    }
    define_method("#{k}=") {|parameter|
      client_profile.delete(client_profile.where(:key => k))
      instance_variable_set("@#{k}", parameter)
      unless parameter.blank?
        profile_record = client_profile.build(:key => k, :value => parameter.try(:to_s).try(:strip))
        profile_record.save unless new_record?
      end
    }
  }

end