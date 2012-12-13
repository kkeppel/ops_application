class PaymentTypesController < ApplicationController
  respond_to :html, :json

  def index
    respond_with(@payment_types = PaymentType.all)
  end

  def show
    respond_with(@payment_type = PaymentType.find(params[:id]))
  end

  def create
    respond_with(@payment_type = PaymentType.create(params[:payment_type]))
  end

  def update
    respond_with(@payment_type = PaymentType.update(params[:id], params[:payment_type]))
  end

  def destroy
    respond_with(@payment_type = PaymentType.destroy(params[:id]))
  end

  #def new
  #  @payment_type = PaymentType.new
  #
  #  respond_to do |format|
  #    format.html # new.html.erb
  #    format.json { render json: @payment_type }
  #  end
  #end

  #def edit
  #  @payment_type = PaymentType.find(params[:id])
  #end
end
