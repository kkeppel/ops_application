class VendorsController < ApplicationController


  def index
    @vendors = Vendor.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @vendors }
    end
  end

  def show
    @vendor = Vendor.find(params[:id])
    @location = Location.where(vendor_id: params[:id]).last
    @contact = Contact.where(vendor_id: params[:id]).last
    @vendor_profile = VendorProfile.where(vendor_id: params[:id])
    @vendor_profile_keys = @vendor_profile.group('vendor_profiles.key')

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @vendor }
    end
  end

  def new
    @vendor = Vendor.new
    @vendor.locations.build
    @vendor.contacts.build

    @vendor_profile = VendorProfile.where(vendor_id: params[:id])
    @vendor_profile_keys = @vendor_profile.group('vendor_profiles.key')

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @vendor }
    end
  end

  def edit
    @vendor = Vendor.find(params[:id])
    @vendor_profile = VendorProfile.where(vendor_id: params[:id])
    @vendor_profile_keys = @vendor_profile.group('vendor_profiles.key')
  end

  def create
    @vendor = Vendor.new(params[:vendor])

    respond_to do |format|
      if @vendor.save
	      new_contact = Contact.last
	      new_contact.update_attribute(:location_id, Location.last.id)

        #@vendor.update_profile(params)
        VendorProfile.delete_all("value LIKE '%=>%' or vendor_id = 0")
        format.html { redirect_to vendors_path, notice: 'Vendor was successfully created.' }
        format.json { render json: @vendor, status: :created, location: @vendor }
      else
        format.html { render action: "new" }
        format.json { render json: @vendor.errors, status: :unprocessable_entity }
      end
    end
  end

  def update
    @vendor = Vendor.find(params[:id])

    respond_to do |format|
	    if @vendor.update_attributes(params[:vendor])
		    format.html { redirect_to vendor_path(@vendor), notice: 'Vendor was successfully updated.' }
		    format.json { head :no_content }
	    else
		    format.html { render action: "edit" }
		    format.json { render json: @vendor.errors, status: :unprocessable_entity }
	    end
    end
    #
    #respond_to do |format|
    #  if @vendor.update_attributes(params[:vendor])
    #    VendorProfile.delete_all(vendor_id: @vendor.id)
    #    @vendor.update_profile(params)
    #    VendorProfile.delete_all("value LIKE '%=>%' or vendor_id = 0")
    #    format.html { redirect_to vendor_path(@vendor), notice: 'Vendor was successfully updated.' }
    #    format.json { head :no_content }
    #  else
    #    format.html { render action: "edit" }
    #    format.json { render json: @vendor.errors, status: :unprocessable_entity }
    #  end
    #end
  end

  def destroy
    @vendor = Vendor.find(params[:id])
    @vendor.destroy

    respond_to do |format|
      format.html { redirect_to vendors_url }
      format.json { head :no_content }
    end
  end
end
