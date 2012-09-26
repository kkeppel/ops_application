class User < ActiveRecord::Base

  has_and_belongs_to_many :roles
  has_one :client_profile
  has_one :vendor_profile

  # Include default devise modules. Others available are:
  # :confirmable,
  # :lockable, :timeoutable and :omniauthable
  devise :database_authenticatable, :registerable,:token_authenticatable,
         :recoverable, :rememberable, :trackable, :validatable

  attr_accessible :email, :password, :password_confirmation, :remember_me,
                  :first_name, :last_name, :newsletter, :role_ids, :is_client, :is_vendor

  #return true if the user is not vendor or client
  def is_c2me?
    is_client? || is_vendor?  ? true : false
  end

  #return the user Role
  def role?(role)
    return !!self.roles.find_by_name(role.to_s.camelize)
  end

  def client_or_vendor(role_id)
    client_roles = %w(employee office_manager)
    vendor_roles = %w(vendor carrier)
    role_name = Role.where(:id => role_id).select(:name).first.to_s
    if client_roles.include?(role_name)
      self.is_client = true
    elsif vendor_roles.include?(role_name)
      self.is_vendor = true
    end
    self.save
  end

end
