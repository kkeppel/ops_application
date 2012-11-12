class MealTypesController < ApplicationController
  # GET /meal_types
  # GET /meal_types.json
  def index
    @meal_types = MealType.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @meal_types }
    end
  end

  # GET /meal_types/1
  # GET /meal_types/1.json
  def show
    @meal_type = MealType.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @meal_type }
    end
  end

  # GET /meal_types/new
  # GET /meal_types/new.json
  def new
    @meal_type = MealType.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @meal_type }
    end
  end

  # GET /meal_types/1/edit
  def edit
    @meal_type = MealType.find(params[:id])
  end

  # POST /meal_types
  # POST /meal_types.json
  def create
    @meal_type = MealType.new(params[:meal_type])

    respond_to do |format|
      if @meal_type.save
        format.html { redirect_to @meal_type, notice: 'Meal type was successfully created.' }
        format.json { render json: @meal_type, status: :created, location: @meal_type }
      else
        format.html { render action: "new" }
        format.json { render json: @meal_type.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /meal_types/1
  # PUT /meal_types/1.json
  def update
    @meal_type = MealType.find(params[:id])

    respond_to do |format|
      if @meal_type.update_attributes(params[:meal_type])
        format.html { redirect_to @meal_type, notice: 'Meal type was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @meal_type.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /meal_types/1
  # DELETE /meal_types/1.json
  def destroy
    @meal_type = MealType.find(params[:id])
    @meal_type.destroy

    respond_to do |format|
      format.html { redirect_to meal_types_url }
      format.json { head :no_content }
    end
  end
end
