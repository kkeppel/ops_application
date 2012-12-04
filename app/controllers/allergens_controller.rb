class AllergensController < ApplicationController
  respond_to :html, :json
  def index
    respond_with(
      @ingredient ||= Ingredient.find(params[:ingredient_id]),
      @allergens = @ingredient.allergens,
      @item ||= IngredientsItems.where(ingredient_id: @ingredient.id).group(:item_id).first
    )
  end

  def get_allergens
    @allergens = AllergensMeals.where(meal_id: params[:id])
    if request.xhr?
      render :json => @allergens
    end
  end

  def get_ingredients
    @ingredients = AllergensIngredients.all
    if request.xhr?
      render :json => @ingredients
    end
  end

  # GET /allergens/1
  # GET /allergens/1.json
  def show
    @ingredient = Ingredient.find(params[:ingredient_id])
    @allergen = Allergen.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @allergen }
    end
  end

  # GET /allergens/new
  # GET /allergens/new.json
  def new
    @ingredient = Ingredient.find(params[:ingredient_id])
    @allergen = Allergen.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @allergen }
    end
  end

  # GET /allergens/1/edit
  def edit
    @ingredient = Ingredient.find(params[:ingredient_id])
    @allergen = Allergen.find(params[:id])
  end

  # POST /allergens
  # POST /allergens.json
  def create
    @ingredient = Ingredient.find(params[:ingredient_id])
    @allergen = Allergen.new(params[:allergen])

    respond_to do |format|
      if @allergen.save
        AllergensIngredients.create({allergen_id: @allergen.id, ingredient_id: params[:ingredient_id]})
        format.html { redirect_to ingredient_allergen_path(@ingredient, @allergen), notice: 'Allergen was successfully created.' }
        format.json { render json: @allergen, status: :created, location: @allergen }
      else
        format.html { render action: "new" }
        format.json { render json: @allergen.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /allergens/1
  # PUT /allergens/1.json
  def update
    @ingredient = Ingredient.find(params[:ingredient_id])
    @allergen = Allergen.find(params[:id])

    respond_to do |format|
      if @allergen.update_attributes(params[:allergen])
        format.html { redirect_to ingredient_allergen_path(@ingredient, @allergen), notice: 'Allergen was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @allergen.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /allergens/1
  # DELETE /allergens/1.json
  def destroy
    @ingredient = Ingredient.find(params[:ingredient_id])
    @allergen = Allergen.find(params[:id])
    @allergen.destroy

    respond_to do |format|
      format.html { redirect_to ingredient_allergens_path(@ingredient) }
      format.json { head :no_content }
    end
  end
end
