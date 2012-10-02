class Staff < User

  default_scope where(:is_client => 0, :is_vendor => 0)

  # attr_accessible :title, :body
end
