class User < ActiveRecord::Base

  has_and_belongs_to_many :roles
  has_one :client_profile
  has_one :vendor_profile

  # Include default devise modules. Others available are:
  # :confirmable,
  # :lockable, :timeoutable and :omniauthable
  devise :database_authenticatable, :registerable,:token_authenticatable,
         :recoverable, :rememberable, :trackable, :validatable

  attr_accessible :email, :password, :password_confirmation, :remember_me, :first_name, :last_name, :newsletter, :role_ids


  #return true if the user is not vendor or client
  def is_c2me?
    is_client? || is_vendor?  ? true : false
  end

  #return the user Role
  def role?(role)
    return !!self.roles.find_by_name(role.to_s.camelize)
  end

end
