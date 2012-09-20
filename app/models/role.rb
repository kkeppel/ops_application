class Role < ActiveRecord::Base
  has_and_belongs_to_many :users

  attr_accessible :description, :name

  def to_s
    name.to_s
  end
end
