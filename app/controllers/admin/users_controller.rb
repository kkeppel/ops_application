class Admin::UsersController < ApplicationController
  load_and_authorize_resource

  def index
  end

  def fetch_users
    if params[:type] == 'client'
      @users = User.where(:is_client =>true).all
    elsif params[:type] == 'vendor'
      @users = User.where(:is_vendor =>true).all
    elsif params[:type] == 'other'
      @users = User.where(:is_vendor => 0, :is_client => 0).all
    end
  end

  def activation
      if params[:type] == "activate"
        @user.update_attribute(:active, 1)
      else
        @user.update_attribute(:active, 0)
      end
    end
end
