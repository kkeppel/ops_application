class UserMailer < ActionMailer::Base
  default :from => "bot@cater2.me"

  def registration_confirmation(user)
    @user = user
    attachments["rails.png"] = File.read("#{Rails.root}/public/images/rails.png")
    mail(:to => "#{user.name} <#{user.email}>", :subject => "Confirm Registration")
  end
end