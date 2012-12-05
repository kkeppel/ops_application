class FoodCategoriesController < ApplicationController
  respond_to :html, :json

  def index
    respond_with(@food_categories = FoodCategory.all)
  end

  def show
    respond_with(@food_category = FoodCategory.find(params[:id]))
  end

  def create
    respond_with(@food_category = FoodCategory.create(params[:food_category]))
  end

  def update
    respond_with(@food_category = FoodCategory.update(params[:id], params[:food_category]))
  end

  def destroy
    respond_with(@food_category = FoodCategory.destroy(params[:id]))
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
