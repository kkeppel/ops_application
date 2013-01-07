class LocationsController < ApplicationController

  def for_company_id

  end

  def index
	  if params.include?(:company_id)
		  @locations = Location.where(company_id: params[:company_id])
		  @company = Company.find(params[:company_id])
	  elsif params.include?(:vendor_id)
		  @locations = Location.where(vendor_id: params[:vendor_id])
		  @vendor = Vendor.find(params[:vendor_id])
	  end

	  respond_to do |format|
		  format.html # show.html.erb
	  end

  end

  def show
    respond_with(@location = Location.find(params[:id]))
  end

  def create
	  @company = Company.find(params[:company_id]) if params[:company_id]
	  @vendor = Vendor.find(params[:vendor_id]) if params[:vendor_id]
	  @location = Location.new(params[:location])

	  respond_to do |format|
		  if @location.save
			  format.html {
				  redirect_to params[:company_id] ? company_locations_path(@company) : vendor_locations_path(@vendor),
				              notice: 'Location was successfully created.' }
			  format.json { render json: @location, status: :created, location: @location }
		  else
			  format.html { render action: "new" }
			  format.json { render json: @location.errors, status: :unprocessable_entity }
		  end
	  end
  end

  def update
	  @company = Company.find(params[:company_id]) if params[:company_id]
	  @vendor = Vendor.find(params[:vendor_id]) if params[:vendor_id]
	  @location = Location.find(params[:id])

	  respond_to do |format|
		  if @location.update_attributes(params[:location])
			  format.html {
				  redirect_to params[:company_id] ? company_locations_path(@company) : vendor_locations_path(@vendor),
				              notice: 'Location was successfully updated.' }
			  format.json { head :no_content }
		  else
			  format.html { render action: "edit" }
			  format.json { render json: @location.errors, status: :unprocessable_entity }
		  end
	  end
  end

  def destroy
	  @company = Company.find(params[:company_id]) if params[:company_id]
	  @vendor = Vendor.find(params[:vendor_id]) if params[:vendor_id]
	  @location = Location.find(params[:id])
	  @location.destroy

	  respond_to do |format|
		  format.html { redirect_to params[:company_id] ? company_locations_path(@company) : vendor_locations_path(@vendor)}
		  format.json { head :no_content }
	  end
  end

  def new
    @location = Location.new
    @company = Company.find(params[:company_id]) if params[:company_id]
    @vendor = Vendor.find(params[:vendor_id]) if params[:vendor_id]

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @location }
    end
  end

  def edit
    @location = Location.find(params[:id])
    @company = Company.find(params[:company_id]) if params[:company_id]
    @vendor = Vendor.find(params[:vendor_id]) if params[:vendor_id]
  end
end
