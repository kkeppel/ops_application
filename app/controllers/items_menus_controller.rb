class ItemsMenusController < ApplicationController
  respond_to :json

  def index
    respond_with(@items = ItemsMenus.all)
  end

  def show
    respond_with(@items_menus = ItemsMenus.find(params[:id]))
  end

  def create
    @items_menus = ItemsMenus.create(params[:items_menus])
  end

  def update
    respond_with(@items_menus = ItemsMenus.update(params[:id], params[:items_menus]))
  end

  def destroy
    respond_with(@items_menus = ItemsMenus.destroy(params[:id]))
  end

  #def new
  #  @items_menus = ItemsMenus.new
  #  @ingredients = Ingredient.all
  #  @vendors = Vendor.all
  #
  #  respond_to do |format|
  #    format.html # new.html.erb
  #    format.json { render json: @items_menus }
  #  end
  #end

  #def edit
  #  @items_menus = ItemsMenus.find(params[:id])
  #end
end
