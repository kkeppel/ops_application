class ItemsController < ApplicationController
  respond_to :html, :json

  def index
		@items = Item.where(vendor_id: params[:vendor_id])
		@vendor = Vendor.find(params[:vendor_id])

    respond_with(@items)
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
	  @vendor = Vendor.find(params[:vendor_id])
	  @item = Item.new(params[:item])

	  respond_to do |format|
		  if @item.save
			  format.html {
				  redirect_to vendor_items_path(@vendor), notice: 'Item was successfully created.' }
			  format.json { render json: @item, status: :created, location: @item }
		  else
			  format.html { render action: "new" }
			  format.json { render json: @item.errors, status: :unprocessable_entity }
		  end
	  end
  end

  def update
	  @vendor = Vendor.find(params[:vendor_id])
	  @item = Item.find(params[:id])

	  respond_to do |format|
		  if @item.update_attributes(params[:item])
			  format.html {
				  redirect_to vendor_items_path(@vendor), notice: 'Item was successfully updated.' }
			  format.json { head :no_content }
		  else
			  format.html { render action: "edit" }
			  format.json { render json: @item.errors, status: :unprocessable_entity }
		  end
	  end
  end

  def destroy
	  @vendor = Vendor.find(params[:vendor_id])
	  @item = Item.find(params[:id])
	  @item.destroy

	  respond_to do |format|
		  format.html { redirect_to vendor_items_path(@vendor)}
		  format.json { head :no_content }
	  end
  end

  def new
	  @item = Item.new
		@vendor = Vendor.find(params[:vendor_id])
		@food_categories = FoodCategory.all

	  respond_to do |format|
		  format.html # new.html.erb
		  format.json { render json: @item}
	  end
  end

  def edit
	  @item = Item.find(params[:id])
	  @vendor = Vendor.find(params[:vendor_id])
	  @food_categories = FoodCategory.all
  end

end
