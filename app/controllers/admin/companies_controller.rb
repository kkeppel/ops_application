class Admin::CompaniesController < ApplicationController
  respond_to :html, :json

  def index
    respond_with(@companies = Company.all)
  end

  def show
    @company = Company.find(params[:id])
    @location = Location.where(company_id: params[:id]).last
    @contact = Contact.where(company_id: params[:id]).last
    @company_profile = CompanyProfile.where(company_id: params[:id])
    @company_profile_keys = @company_profile.group('company_profiles.key')

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @company }
    end
  end

  def new
    @company = Company.new
    @company.locations.build
    @company.contacts.build

    @company_profile = CompanyProfile.where(company_id: params[:id])
    @company_profile_keys = @company_profile.group('company_profiles.key')
    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @company }
    end
  end

  def edit
    @company = Company.find(params[:id])
    @company_profile = CompanyProfile.where(company_id: params[:id])
    @company_profile_keys = @company_profile.group('company_profiles.key')

  end

  def create
    @company = Company.new(params[:company])

    respond_to do |format|
      if @company.save
        new_contact = Contact.last
        new_contact.update_attribute(:location_id, Location.last.id)
        #update key value table
        #@company.update_profile(params)
        CompanyProfile.delete_all("value LIKE '%=>%' or company_id = 0 or value LIKE ''")
        format.html { redirect_to admin_company_path(@company), notice: 'Company was successfully created.' }
        format.json { render json: @company, status: :created, location: @company }
      else
        format.html { render action: "new" }
        format.json { render json: @company.errors, status: :unprocessable_entity }
      end
    end
  end

  def update
    @company = Company.find(params[:id])

    respond_to do |format|
      if @company.update_attributes(params[:company].except(:allergies, :favorite_foods))
        CompanyProfile.delete_all(company_id: @company.id)
        #update key value table
        @company.update_profile(params)
        CompanyProfile.delete_all("value LIKE '%=>%' or company_id = 0")
        format.html { redirect_to admin_company_path(@company), notice: 'Company was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @company.errors, status: :unprocessable_entity }
      end
    end
  end

  def destroy
    @company = Company.find(params[:id])
    @company.destroy

    respond_to do |format|
      format.html { redirect_to admin_companies_url }
      format.json { head :no_content }
    end
  end


end
