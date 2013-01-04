class ApplicationController < ActionController::Base

  protect_from_forgery
  rescue_from CanCan::AccessDenied do |exception|
    flash[:alert] = exception.message
    redirect_to root_url
  end

  http_basic_authenticate_with :name => 'demO', :password => 'dbAcc3ss!'


end
