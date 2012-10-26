class Admin::CompaniesController < ApplicationController
  # GET /companies
  # GET /companies.json


  def index
    @companies = Company.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @companies }
    end
  end

  # GET /companies/1
  # GET /companies/1.json
  def show
    @company = Company.find(params[:id])
    @company_profile = CompanyProfile.where(company_id: params[:id])
    @company_profile_keys = @company_profile.group('company_profiles.key')

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @company }
    end
  end

  # GET /companies/new
  # GET /companies/new.json
  def new
    @company = Company.new
    @company.locations.build
    @company_profile_keys = @company_profile.group('company_profiles.key')
    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @company }
    end
  end

  # GET /companies/1/edit
  def edit
    @company = Company.find(params[:id])
    @company_profile = CompanyProfile.where(company_id: params[:id])
    @company_profile_keys = @company_profile.group('company_profiles.key')

  end

  # POST /companies
  # POST /companies.json
  def create
    @company = Company.new(params[:company])


    respond_to do |format|
      if @company.save
        #update key value table
        @company.update_profile(params)
        CompanyProfile.delete_all(:value => :value.is_a?(Hash))
        format.html { redirect_to admin_company_path(@company), notice: 'Company was successfully created.' }
        format.json { render json: @company, status: :created, location: @company }
      else
        format.html { render action: "new" }
        format.json { render json: @company.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /companies/1
  # PUT /companies/1.json
  def update
    @company = Company.find(params[:id])

    respond_to do |format|
      if @company.update_attributes(params[:company].except(:allergies, :favorite_foods))
        #update key value table
        @company.update_profile(params)
        format.html { redirect_to admin_company_path(@company), notice: 'Company was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @company.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /companies/1
  # DELETE /companies/1.json
  def destroy
    @company = Company.find(params[:id])
    @company.destroy

    respond_to do |format|
      format.html { redirect_to admin_companies_url }
      format.json { head :no_content }
    end
  end


end
