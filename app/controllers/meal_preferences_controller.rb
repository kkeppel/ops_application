class MealPreferencesController < ApplicationController
  # GET /meal_preferences
  # GET /meal_preferences.json
  def index
    @meal_preferences = MealPreference.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @meal_preferences }
    end
  end

  # GET /meal_preferences/1
  # GET /meal_preferences/1.json
  def show
    @meal_preference = MealPreference.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @meal_preference }
    end
  end

  # GET /meal_preferences/new
  # GET /meal_preferences/new.json
  def new
    @meal_preference = MealPreference.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @meal_preference }
    end
  end

  # GET /meal_preferences/1/edit
  def edit
    @meal_preference = MealPreference.find(params[:id])
  end

  # POST /meal_preferences
  # POST /meal_preferences.json
  def create
    @meal_preference = MealPreference.new(params[:meal_preference])

    respond_to do |format|
      if @meal_preference.save
        format.html { redirect_to @meal_preference, notice: 'Meal preference was successfully created.' }
        format.json { render json: @meal_preference, status: :created, location: @meal_preference }
      else
        format.html { render action: "new" }
        format.json { render json: @meal_preference.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /meal_preferences/1
  # PUT /meal_preferences/1.json
  def update
    @meal_preference = MealPreference.find(params[:id])

    respond_to do |format|
      if @meal_preference.update_attributes(params[:meal_preference])
        format.html { redirect_to @meal_preference, notice: 'Meal preference was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @meal_preference.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /meal_preferences/1
  # DELETE /meal_preferences/1.json
  def destroy
    @meal_preference = MealPreference.find(params[:id])
    @meal_preference.destroy

    respond_to do |format|
      format.html { redirect_to meal_preferences_url }
      format.json { head :no_content }
    end
  end
end
