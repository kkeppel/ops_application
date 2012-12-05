class MenusController < ApplicationController
  respond_to :html, :json

  def index
    respond_with(@menus = Menu.all)
  end

  def show
    respond_with(@menu = Menu.find(params[:id]))
  end

  def create
    respond_with(@menu = Menu.create(params[:menu]))
  end

  def update
    respond_with(@menu = Menu.update(params[:id], params[:menu]))
  end

  def destroy
    respond_with(@menu = Menu.destroy(params[:id]))
  end

  #def new
  #  @menu = Menu.new
  #
  #  respond_to do |format|
  #    format.html # new.html.erb
  #    format.json { render json: @menu }
  #  end
  #end

  #def edit
  #  @menu = Menu.find(params[:id])
  #end
end
