class VendorProfilesController < ApplicationController
  # GET /vendor_profiles
  # GET /vendor_profiles.json
  def index
    @vendor_profiles = VendorProfile.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @vendor_profiles }
    end
  end

  # GET /vendor_profiles/1
  # GET /vendor_profiles/1.json
  def show
    @vendor_profile = VendorProfile.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @vendor_profile }
    end
  end

  # GET /vendor_profiles/new
  # GET /vendor_profiles/new.json
  def new
    @vendor_profile = VendorProfile.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @vendor_profile }
    end
  end

  # GET /vendor_profiles/1/edit
  def edit
    @vendor_profile = VendorProfile.find(params[:id])
  end

  # POST /vendor_profiles
  # POST /vendor_profiles.json
  def create
    @vendor_profile = VendorProfile.new(params[:vendor_profile])

    respond_to do |format|
      if @vendor_profile.save
        format.html { redirect_to @vendor_profile, notice: 'Vendor profile was successfully created.' }
        format.json { render json: @vendor_profile, status: :created, location: @vendor_profile }
      else
        format.html { render action: "new" }
        format.json { render json: @vendor_profile.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /vendor_profiles/1
  # PUT /vendor_profiles/1.json
  def update
    @vendor_profile = VendorProfile.find(params[:id])

    respond_to do |format|
      if @vendor_profile.update_attributes(params[:vendor_profile])
        format.html { redirect_to @vendor_profile, notice: 'Vendor profile was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @vendor_profile.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /vendor_profiles/1
  # DELETE /vendor_profiles/1.json
  def destroy
    @vendor_profile = VendorProfile.find(params[:id])
    @vendor_profile.destroy

    respond_to do |format|
      format.html { redirect_to vendor_profiles_url }
      format.json { head :no_content }
    end
  end
end
