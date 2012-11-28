class ItemsController < ApplicationController
  respond_to :html, :json

  def index
    respond_with(@items = Item.all)
  end

  def get_items
    @items = IngredientsItems.all
    if request.xhr?
      render :json => @items
    end
  end

  def show
    respond_with(@item = Item.find(params[:id]))
  end

  def create
    respond_with(@item = Item.create(params[:item]))
  end

  def update
    respond_with(@item = Item.update(params[:id], params[:item]))
  end

  def destroy
    respond_with(@item = Item.destroy(params[:id]))
  end

  #def new
  #  @item = Item.new
  #  @ingredients = Ingredient.all
  #  @vendors = Vendor.all
  #
  #  respond_to do |format|
  #    format.html # new.html.erb
  #    format.json { render json: @item }
  #  end
  #end

  #def edit
  #  @item = Item.find(params[:id])
  #end

end
