class ItemsController < ApplicationController
  respond_to :html, :json

  def index
    respond_with(@items = Item.all)
  end

  def show
    respond_with(@item = Item.find(params[:id]))
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

  def create
    respond_with (@item = Item.create(params[:item]))

    #respond_to do |format|
    #  if @item.save
    #    format.html { redirect_to @item, notice: 'Item was successfully created.' }
    #    format.json { render json: @item, status: :created, location: @item }
    #  else
    #    format.html { render action: "new" }
    #    format.json { render json: @item.errors, status: :unprocessable_entity }
    #  end
    #end
  end

  def update
    respond_with(@item = Item.update(params[:id], params[:item]))

    #@item = Item.find(params[:id])
    #
    #respond_to do |format|
    #  if @item.update_attributes(params[:item])
    #    format.html { redirect_to @item, notice: 'Item was successfully updated.' }
    #    format.json { head :no_content }
    #  else
    #    format.html { render action: "edit" }
    #    format.json { render json: @item.errors, status: :unprocessable_entity }
    #  end
    #end
  end

  def destroy
    respond_with(@item = Item.destroy(params[:id]))
    #@item = Item.find(params[:id])
    #@item.destroy
    #
    #respond_to do |format|
    #  format.html { redirect_to items_url }
    #  format.json { head :no_content }
    #end
  end

  def find_allergens
    company = Company.find(params[:company_id])

  end

end
