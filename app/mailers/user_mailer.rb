class UserMailer < ActionMailer::Base
  default :from => "bot@cater2.me"

  def registration_confirmation(user)
    @user = user
    mail(:to => "#{user.name} <#{user.email}>", :subject => "Confirm Registration")
  end

  def send_user_mail(user, template_name)
    @user = user
    mail(
      :to => user.email,
      :template_name => template_name)
  end

  def send_mail(email, template_name)
    mail(
      :to => email,
      :template_name => template_name
    )
  end
end