class Admin::UsersController < ApplicationController
  load_and_authorize_resource

  def index
  end

  def edit
    @roles = Role.find_by_sql('SELECT * from roles group by name').map {|r| [r.name, r.id]}
  end

  def update
    @user.update_attributes(params[:user])
    @user.client_or_vendor(params[:user][:role_ids])
    redirect_to :action => 'index'
    flash[:notice] = "Successfully updated user. Good for you!"
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
