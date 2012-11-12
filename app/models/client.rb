class Client < User

  belongs_to :company

  default_scope where(:is_client => 1, :is_vendor => 0)


end