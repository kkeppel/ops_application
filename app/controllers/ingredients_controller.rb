class IngredientsController < ApplicationController

  def index
    @item = Item.find(params[:item_id])
    @ingredients = Ingredient.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @ingredients }
    end
  end

  # GET /Ingredients/1
  # GET /Ingredients/1.json
  def show
    @item = Item.find(params[:item_id])
    @ingredient = Ingredient.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @ingredient }
    end
  end

  # GET /Ingredients/new
  # GET /Ingredients/new.json
  def new
    @item = Item.find(params[:item_id])
    @ingredient = Ingredient.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @ingredient }
    end
  end

  # GET /Ingredients/1/edit
  def edit
    @item = Item.find(params[:item_id])
    @ingredient = Ingredient.find(params[:id])
  end

  # POST /Ingredients
  # POST /Ingredients.json
  def create
    @item = Item.find(params[:item_id])
    @ingredient = Ingredient.new(params[:ingredient])

    respond_to do |format|
      if @ingredient.save
        format.html { redirect_to item_ingredient_url(@item, @ingredient), notice: 'Ingredient was successfully created.' }
        format.json { render json: @ingredient, status: :created, ingredient: @ingredient }
      else
        format.html { render action: "new" }
        format.json { render json: @ingredient.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /Ingredients/1
  # PUT /Ingredients/1.json
  def update
    @item = Item.find(params[:item_id])
    @ingredient = Ingredient.find(params[:id])

    respond_to do |format|
      if @ingredient.update_attributes(params[:ingredient])
        format.html { redirect_to item_ingredient_url(@item, @ingredient), notice: 'Ingredient was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @ingredient.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /Ingredients/1
  # DELETE /Ingredients/1.json
  def destroy
    @item = Item.find(params[:item_id])
    @ingredient = Ingredient.find(params[:id])
    @ingredient.destroy

    respond_to do |format|
      format.html { redirect_to item_ingredients_url }
      format.json { head :no_content }
    end
  end
end
