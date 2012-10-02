class ApplicationController < ActionController::Base
  protect_from_forgery

  #http_basic_authenticate_with :name => 'demO', :password => 'dbAcc3ss!'

  rescue_from CanCan::AccessDenied do |exception|
    redirect_to root_url, :alert => exception.message
  end
  before_filter :authenticate_user!

end
