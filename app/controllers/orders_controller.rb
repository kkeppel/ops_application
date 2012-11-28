class OrdersController < ApplicationController

  respond_to :html, :json

  def index
    respond_with(@orders = Order.all)
  end

  def show
    respond_with(@order= Order.find(params[:id]))
  end

  def create
    respond_with(@order = Order.create(params[:order]))
  end

  def update
    respond_with(@order = Order.update(params[:id], params[:order]))
  end

  def destroy
    respond_with(@order = Order.destroy(params[:id]))
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
