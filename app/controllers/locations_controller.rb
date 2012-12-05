class LocationsController < ApplicationController
  respond_to :html, :json

  def for_company_id
    @locations = Location.where(company_id: params[:id])
    respond_to do |format|
      format.json { render json: @locations}
    end
  end

  def index
    respond_with(@locations = Location.all)
  end

  def show
    respond_with(@location = Location.find(params[:id]))
  end

  def create
    respond_with(@location = Location.create(params[:location]))
  end

  def update
    respond_with(@location = Location.update(params[:id], params[:location]))
  end

  def destroy
    respond_with(@location = Location.destroy(params[:id]))
  end

  #def new
  #  @location = Location.new
  #
  #  respond_to do |format|
  #    format.html # new.html.erb
  #    format.json { render json: @location }
  #  end
  #end

  #def edit
  #  @location = Location.find(params[:id])
  #end
end
