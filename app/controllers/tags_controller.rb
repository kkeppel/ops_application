class TagsController < ApplicationController
  respond_to :html, :json

  def index
    respond_with(@tags = Tag.all)
  end

  def show
    respond_with(@tag = Tag.find(params[:id]))
  end

  def create
    respond_with(@tag = Tag.create(params[:tag]))
  end

  def update
    respond_with(@tag = Tag.update(params[:id], params[:tag]))
  end

  def destroy
    respond_with(@tag = Tag.destroy(params[:id]))
  end

  #def new
  #  @tag = Tag.new
  #  @ingredients = Ingredient.all
  #  @vendors = Vendor.all
  #
  #  respond_to do |format|
  #    format.html # new.html.erb
  #    format.json { render json: @tag }
  #  end
  #end

  #def edit
  #  @tag = Tag.find(params[:id])
  #end
end
