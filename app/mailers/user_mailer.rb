class UserMailer < ActionMailer::Base
  default :from => "bot@cater2.me"

  def registration_confirmation(user)
    @user = user
    mail(:to => "#{user.name} <#{user.email}>", :subject => "Confirm Registration")
  end

  def send_mail(user = [], page)
    mail(:to => "#{user.first_name} <#{user.email}>", :subject => "#{page}")
  end
end