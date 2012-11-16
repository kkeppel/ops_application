class MealProfilesController < ApplicationController
  # GET /meal_profiles
  # GET /meal_profiles.json
  def index
    @meal_profiles = MealProfile.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @meal_profiles }
    end
  end

  # GET /meal_profiles/1
  # GET /meal_profiles/1.json
  def show
    @meal_profile = MealProfile.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @meal_profile }
    end
  end

  # GET /meal_profiles/new
  # GET /meal_profiles/new.json
  def new
    @meal_profile = MealProfile.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @meal_profile }
    end
  end

  # GET /meal_profiles/1/edit
  def edit
    @meal_profile = MealProfile.find(params[:id])
  end

  # POST /meal_profiles
  # POST /meal_profiles.json
  def create
    @meal_profile = MealProfile.new(params[:meal_profile])

    respond_to do |format|
      if @meal_profile.save
        format.html { redirect_to @meal_profile, notice: 'Meal profile was successfully created.' }
        format.json { render json: @meal_profile, status: :created, location: @meal_profile }
      else
        format.html { render action: "new" }
        format.json { render json: @meal_profile.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /meal_profiles/1
  # PUT /meal_profiles/1.json
  def update
    @meal_profile = MealProfile.find(params[:id])

    respond_to do |format|
      if @meal_profile.update_attributes(params[:meal_profile])
        format.html { redirect_to @meal_profile, notice: 'Meal profile was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @meal_profile.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /meal_profiles/1
  # DELETE /meal_profiles/1.json
  def destroy
    @meal_profile = MealProfile.find(params[:id])
    @meal_profile.destroy

    respond_to do |format|
      format.html { redirect_to meal_profiles_url }
      format.json { head :no_content }
    end
  end
end
