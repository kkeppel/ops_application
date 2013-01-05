class Admin::ContactsController < ApplicationController
  load_and_authorize_resource

  def index
    @contacts = Contact.where(company_id: params[:company_id])
    @company = Company.find(params[:company_id]) if params[:company_id]
    @vendor = Vendor.find(params[:vendor_id]) if params[:vendor_id]

    respond_to do |format|
		  format.html
		  format.json { render json: @contacts }
	  end
  end

  def show
    respond_with(@contact = Contact.find(params[:id]))
  end

  def create
	  @company = Company.find(params[:company_id]) if params[:company_id]
	  @vendor = Vendor.find(params[:vendor_id]) if params[:vendor_id]
	  @contact = Contact.new(params[:contact])

	  respond_to do |format|
		  if @contact.save
			  format.html {
				  redirect_to params[:company_id] ? admin_company_contacts_path(@company) : admin_vendor_contacts_path(@vendor),
				              notice: 'Contact was successfully created.' }
			  format.json { render json: @contact, status: :created, location: @contact }
		  else
			  format.html { render action: "new" }
			  format.json { render json: @contact.errors, status: :unprocessable_entity }
		  end
	  end
  end

  def update
	  @company = Company.find(params[:company_id]) if params[:company_id]
	  @vendor = Vendor.find(params[:vendor_id]) if params[:vendor_id]
	  @contact = Contact.find(params[:id])

	  respond_to do |format|
		  if @contact.update_attributes(params[:contact])
			  format.html {
				  redirect_to params[:company_id] ? admin_company_contacts_path(@company) : admin_vendor_contacts_path(@vendor),
				              notice: 'Contact was successfully updated.' }
			  format.json { head :no_content }
		  else
			  format.html { render action: "edit" }
			  format.json { render json: @contact.errors, status: :unprocessable_entity }
		  end
	  end
  end

  def destroy
	  @company = Company.find(params[:company_id]) if params[:company_id]
	  @vendor = Vendor.find(params[:vendor_id]) if params[:vendor_id]
	  @contact = Contact.find(params[:id])
	  @contact.destroy

	  respond_to do |format|
		  format.html { redirect_to params[:company_id] ? admin_company_contacts_path(@company) : admin_vendor_contacts_path(@vendor)}
		  format.json { head :no_content }
	  end
  end

  def new
    @contact = Contact.new
    @payment_types = PaymentType.all
    if params[:company_id]
      @company = Company.find(params[:company_id])
      @locations = Location.where(company_id: params[:company_id])
    elsif params[:vendor_id]
      @vendor = Vendor.find(params[:vendor_id])
      @locations = Location.where(vendor_id: params[:vendor_id])
    end

    respond_to do |format|
	    format.html # new.html.erb
	    format.json { render json: contact }
    end
  end

  def edit
	  @payment_types = PaymentType.all
	  if params[:company_id]
		  @company = Company.find(params[:company_id])
		  @locations = Location.where(company_id: params[:company_id])
	  elsif params[:vendor_id]
		  @vendor = Vendor.find(params[:vendor_id])
		  @locations = Location.where(vendor_id: params[:vendor_id])
	  end
  end

end
