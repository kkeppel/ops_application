class IngredientsController < ApplicationController
  respond_to :html, :json

  def index
    @item = Item.find([params[:item_id]])
    @ingredient = IngredientsItems.where(item_id: params[:item_id])

    respond_with(@item = Item.find(params[:item_id]), @ingredients = IngredientsItems.where(item_id: params[:item_id]))
  end

  def show
    @item = Item.find([params[:item_id]])
    @ingredient = Ingredient.find(params[:id])

    respond_with(@item, @ingredient)
  end

  def create
    @item = Item.find([params[:item_id]])
    @ingredient = Ingredient.create(params[:ingredient])

    respond_to do |format|
      format.json { render :json => [@ingredient, @item] }
    end



  end

  def update
    @item = Item.find([params[:item_id]])
    @ingredient = Ingredient.update(params[:id], params[:item])

    respond_with(@item, @ingredient)
  end

  def destroy
    @ingredient = Ingredient.destroy(params[:id])
    @item = Item.find(params[:item_id])

    respond_with(@item, @ingredient)
  end

  #def new
  #  @ingredient = Ingredient.new
  #  @items = Item.all
  #  @allergens = Allergen.all
  #
  #  respond_to do |format|
  #    format.html # new.html.erb
  #    format.json { render json: @ingredient }
  #  end
  #end
  #
  #def edit
  #  @ingredient = Ingredient.find(params[:id])
  #  @item = Item.find(params[:item_id])
  #  @allergens = Allergen.all
  #end

end
