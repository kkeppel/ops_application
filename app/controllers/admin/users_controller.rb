class Admin::UsersController < ApplicationController
  before_filter :authenticate_user!
  load_and_authorize_resource

  def index
  end

  def edit
    @roles = Role.find_by_sql('SELECT * from roles group by name').map {|r| [r.name, r.id]}
    @companies = Company.all.map {|c| [c.name, c.id] }
    @vendors = Vendor.all.map {|v| [v.name, v.id] }
  end

  def update
    @user.update_attributes(params[:user])
    @user.update_attribute(:company_id, nil) if params[:user][:company_id].nil?
    @user.update_attribute(:vendor_id, nil) if params[:user][:vendor_id].nil?
    @user.client_or_vendor(params[:user][:role_ids])
    redirect_to :action => 'index'
    flash[:notice] = "Successfully updated user. Good for you!"
  end

  def new
    @user = User.new
  end

  def create
    @user = User.new(params[:user])
    if @user.save
      #RolesUser.create(role_id: params[:user][:role_ids], user_id: @user.id)
      flash[:notice] = "Successfully created User."
      redirect_to admin_users_path
    else
      render action: "new"
    end
  end

  def fetch_users
    if params[:type] == 'client'
      @users = User.where("company_id IS NOT NULL AND vendor_id IS NULL").all
    elsif params[:type] == 'vendor'
      @users = User.where("vendor_id IS NOT NULL AND company_id IS NULL").all
    elsif params[:type] == 'other'
      @users = User.where(company_id: nil, vendor_id: nil).all
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
