class ApplicationController < ActionController::Base

  http_basic_authenticate_with :name => 'demO', :password => 'dbAcc3ss!'

  rescue_from CanCan::AccessDenied do |exception|
    redirect_to root_url, :alert => exception.message
  end

  protect_from_forgery


end
