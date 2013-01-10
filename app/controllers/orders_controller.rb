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

  def new_order_and_proposal
	  Order.create
	  order_id = Order.last.id
	  redirect_to "/orders/#{order_id}/proposals/new"
  end

  def new
    @order = Order.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @order }
    end
  end

  def edit
    @order = Order.find(params[:id])
  end

end
