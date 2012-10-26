class IngredientsController < ApplicationController
  # GET /ingredients
  # GET /ingredients.json
  def index
    @ingredients = IngredientsItems.all
    @item = Item.find(params[:item_id])

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @ingredients }
    end
  end

  # GET /ingredients/1
  # GET /ingredients/1.json
  def show
    @ingredient = Ingredient.find(params[:id])
    @item = Item.find(params[:item_id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @ingredient }
    end
  end

  # GET /ingredients/new
  # GET /ingredients/new.json
  def new
    @ingredient = Ingredient.new
    @items = Item.all
    @allergens = Allergen.all

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @ingredient }
    end
  end

  # GET /ingredients/1/edit
  def edit
    @ingredient = Ingredient.find(params[:id])
    @item = Item.find(params[:item_id])
    @allergens = Allergen.all
  end

  # POST /ingredients
  # POST /ingredients.json
  def create
    @ingredient = Ingredient.new(params[:ingredient])
    @item = Item.find(params[:item_id])

    respond_to do |format|
      if @ingredient.save
        format.html { redirect_to item_ingredient_path(@item, @ingredient), notice: 'Ingredient was successfully created.' }
        format.json { render json: @ingredient, status: :created, location: @ingredient }
      else
        format.html { render action: "new" }
        format.json { render json: @ingredient.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /ingredients/1
  # PUT /ingredients/1.json
  def update
    @ingredient = Ingredient.find(params[:id])
    @item = Item.find(params[:item_id])

    respond_to do |format|
      if @ingredient.update_attributes(params[:ingredient])
        format.html { redirect_to @ingredient, notice: 'Ingredient was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @ingredient.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /ingredients/1
  # DELETE /ingredients/1.json
  def destroy
    @ingredient = Ingredient.find(params[:id])
    @item = Item.find(params[:item_id])
    @ingredient.destroy

    respond_to do |format|
      format.html { render action: "index" }
      format.json { head :no_content }
    end
  end
end
