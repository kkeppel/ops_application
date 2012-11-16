class VendorTypesController < ApplicationController
  # GET /vendor_types
  # GET /vendor_types.json
  def index
    @vendor_types = VendorType.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @vendor_types }
    end
  end

  # GET /vendor_types/1
  # GET /vendor_types/1.json
  def show
    @vendor_type = VendorType.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @vendor_type }
    end
  end

  # GET /vendor_types/new
  # GET /vendor_types/new.json
  def new
    @vendor_type = VendorType.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @vendor_type }
    end
  end

  # GET /vendor_types/1/edit
  def edit
    @vendor_type = VendorType.find(params[:id])
  end

  # POST /vendor_types
  # POST /vendor_types.json
  def create
    @vendor_type = VendorType.new(params[:vendor_type])

    respond_to do |format|
      if @vendor_type.save
        format.html { redirect_to @vendor_type, notice: 'Vendor type was successfully created.' }
        format.json { render json: @vendor_type, status: :created, location: @vendor_type }
      else
        format.html { render action: "new" }
        format.json { render json: @vendor_type.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /vendor_types/1
  # PUT /vendor_types/1.json
  def update
    @vendor_type = VendorType.find(params[:id])

    respond_to do |format|
      if @vendor_type.update_attributes(params[:vendor_type])
        format.html { redirect_to @vendor_type, notice: 'Vendor type was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @vendor_type.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /vendor_types/1
  # DELETE /vendor_types/1.json
  def destroy
    @vendor_type = VendorType.find(params[:id])
    @vendor_type.destroy

    respond_to do |format|
      format.html { redirect_to vendor_types_url }
      format.json { head :no_content }
    end
  end
end
