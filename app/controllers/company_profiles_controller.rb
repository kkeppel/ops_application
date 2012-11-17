class Admin::CompanyProfilesController < ApplicationController
  # GET /admin/company_profiles
  # GET /admin/company_profiles.json
  def index
    @admin_company_profiles = Admin::CompanyProfile.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @admin_company_profiles }
    end
  end

  # GET /admin/company_profiles/1
  # GET /admin/company_profiles/1.json
  def show
    @admin_company_profile = Admin::CompanyProfile.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @admin_company_profile }
    end
  end

  # GET /admin/company_profiles/new
  # GET /admin/company_profiles/new.json
  def new
    @admin_company_profile = Admin::CompanyProfile.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @admin_company_profile }
    end
  end

  # GET /admin/company_profiles/1/edit
  def edit
    @admin_company_profile = Admin::CompanyProfile.find(params[:id])
  end

  # POST /admin/company_profiles
  # POST /admin/company_profiles.json
  def create
    @admin_company_profile = Admin::CompanyProfile.new(params[:admin_company_profile])

    respond_to do |format|
      if @admin_company_profile.save
        format.html { redirect_to @admin_company_profile, notice: 'Company profile was successfully created.' }
        format.json { render json: @admin_company_profile, status: :created, location: @admin_company_profile }
      else
        format.html { render action: "new" }
        format.json { render json: @admin_company_profile.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /admin/company_profiles/1
  # PUT /admin/company_profiles/1.json
  def update
    @admin_company_profile = Admin::CompanyProfile.find(params[:id])

    respond_to do |format|
      if @admin_company_profile.update_attributes(params[:admin_company_profile])
        format.html { redirect_to @admin_company_profile, notice: 'Company profile was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @admin_company_profile.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /admin/company_profiles/1
  # DELETE /admin/company_profiles/1.json
  def destroy
    @admin_company_profile = Admin::CompanyProfile.find(params[:id])
    @admin_company_profile.destroy

    respond_to do |format|
      format.html { redirect_to admin_company_profiles_url }
      format.json { head :no_content }
    end
  end
end
