class ProposalLinesController < ApplicationController
  # GET /proposal_lines
  # GET /proposal_lines.json
  def index
    @proposal_lines = ProposalLine.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @proposal_lines }
    end
  end

  # GET /proposal_lines/1
  # GET /proposal_lines/1.json
  def show
    @proposal_line = ProposalLine.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @proposal_line }
    end
  end

  # GET /proposal_lines/new
  # GET /proposal_lines/new.json
  def new
    @proposal_line = ProposalLine.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @proposal_line }
    end
  end

  # GET /proposal_lines/1/edit
  def edit
    @proposal_line = ProposalLine.find(params[:id])
  end

  # POST /proposal_lines
  # POST /proposal_lines.json
  def create
    @proposal_line = ProposalLine.new(params[:proposal_line])

    respond_to do |format|
      if @proposal_line.save
        format.html { redirect_to @proposal_line, notice: 'Proposal line was successfully created.' }
        format.json { render json: @proposal_line, status: :created, location: @proposal_line }
      else
        format.html { render action: "new" }
        format.json { render json: @proposal_line.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /proposal_lines/1
  # PUT /proposal_lines/1.json
  def update
    @proposal_line = ProposalLine.find(params[:id])

    respond_to do |format|
      if @proposal_line.update_attributes(params[:proposal_line])
        format.html { redirect_to @proposal_line, notice: 'Proposal line was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @proposal_line.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /proposal_lines/1
  # DELETE /proposal_lines/1.json
  def destroy
    @proposal_line = ProposalLine.find(params[:id])
    @proposal_line.destroy

    respond_to do |format|
      format.html { redirect_to proposal_lines_url }
      format.json { head :no_content }
    end
  end
end
