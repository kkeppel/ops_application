class ClientProfilesController < ApplicationController
  # GET /client_profiles
  # GET /client_profiles.json
  def index
    @client_profiles = ClientProfile.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @client_profiles }
    end
  end

  # GET /client_profiles/1
  # GET /client_profiles/1.json
  def show
    @client_profile = ClientProfile.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @client_profile }
    end
  end

  # GET /client_profiles/new
  # GET /client_profiles/new.json
  def new
    @client_profile = ClientProfile.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @client_profile }
    end
  end

  # GET /client_profiles/1/edit
  def edit
    @client_profile = ClientProfile.find(params[:id])
  end

  # POST /client_profiles
  # POST /client_profiles.json
  def create
    @client_profile = ClientProfile.new(params[:client_profile])

    respond_to do |format|
      if @client_profile.save
        format.html { redirect_to @client_profile, notice: 'Client profile was successfully created.' }
        format.json { render json: @client_profile, status: :created, location: @client_profile }
      else
        format.html { render action: "new" }
        format.json { render json: @client_profile.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /client_profiles/1
  # PUT /client_profiles/1.json
  def update
    @client_profile = ClientProfile.find(params[:id])

    respond_to do |format|
      if @client_profile.update_attributes(params[:client_profile])
        format.html { redirect_to @client_profile, notice: 'Client profile was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @client_profile.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /client_profiles/1
  # DELETE /client_profiles/1.json
  def destroy
    @client_profile = ClientProfile.find(params[:id])
    @client_profile.destroy

    respond_to do |format|
      format.html { redirect_to client_profiles_url }
      format.json { head :no_content }
    end
  end
end
