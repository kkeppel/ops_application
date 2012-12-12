class ContactsController < ApplicationController
  respond_to :html, :json

  def index
    respond_with(@contacts = Contact.all)
  end

  def show
    respond_with(@contact = Contact.find(params[:id]))
  end

  def create
    respond_with(@contact = Contact.create(params[:contact]))
  end

  def update
    respond_with(@contact = Contact.update(params[:id], params[:contact]))
  end

  def destroy
    respond_with(@contact = Contact.destroy(params[:id]))
  end

  #def new
  #  @contact = Contact.new
  #
  #  respond_to do |format|
  #    format.html # new.html.erb
  #    format.json { render json: @contact }
  #  end
  #end

  #def edit
  #  @contact = Contact.find(params[:id])
  #end

end
