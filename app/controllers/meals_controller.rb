class MealsController < ApplicationController

  def index
    @meals = Meal.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @meals }
    end
  end

  def show
    @meal = Meal.find(params[:id])
    @meal_profile = MealProfile.where(meal_id: params[:id])
    @meal_profile_keys = @meal_profile.group('meal_profiles.key')

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @meal }
    end
  end

  def new
    @meal = Meal.new
    @meal_profile = MealProfile.where(meal_id: params[:id])
    @meal_profile_keys = @meal_profile.group('meal_profiles.key')
    @allergens = Allergen.all

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @meal }
    end
  end

  def edit
    @meal = Meal.find(params[:id])
    @meal_profile = MealProfile.where(meal_id: params[:id])
    @meal_profile_keys = @meal_profile.group('meal_profiles.key')
    @allergens_for_meal = AllergensMeals.where(meal_id: params[:id]).collect { |a| a.allergen_id }
    @allergens = Allergen.all

  end

  def create
    @meal = Meal.new(params[:meal])

    respond_to do |format|
      if @meal.save
        @meal.update_profile(params)
        MealProfile.delete_all("value LIKE '%=>%' or meal_id = 0")
        format.html { redirect_to @meal, notice: 'Meal was successfully created.' }
        format.json { render json: @meal, status: :created, location: @meal }
      else
        format.html { render action: "new" }
        format.json { render json: @meal.errors, status: :unprocessable_entity }
      end
    end
  end

  def update
    new_allergens = params[:meal][:allergen_ids]
    @meal = Meal.find(params[:id])

    respond_to do |format|
      if @meal.update_attributes(params[:meal].except(params[:meal][:allergen_ids]))
        AllergensMeals.where(meal_id: params[:id]).delete_all
        new_allergens.each do |a|
          AllergensMeals.add_allergens(a, params[:id])
        end
        @meal.update_profile(params)
        MealProfile.delete_all("value LIKE '%=>%' or meal_id = 0")
        format.html { redirect_to @meal, notice: 'Meal was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @meal.errors, status: :unprocessable_entity }
      end
    end
  end

  def destroy
    @meal = Meal.find(params[:id])
    @meal.destroy

    respond_to do |format|
      format.html { redirect_to meals_url }
      format.json { head :no_content }
    end
  end
end
