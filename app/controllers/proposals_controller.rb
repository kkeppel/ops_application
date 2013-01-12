class ProposalsController < ApplicationController
  # GET /proposals
  # GET /proposals.json
  def index
    @proposals = Proposal.all
    @orders = Order.all
    @order = Order.find(params[:order_id]) if params[:order_id]

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @proposals }
    end
  end

  # GET /proposals/1
  # GET /proposals/1.json
  def show
    @proposal = Proposal.find(params[:id])
    @order = Order.find(params[:order_id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @proposal }
    end
  end

  # GET /proposals/new
  # GET /proposals/new.json

  def new
	  @order = Order.find(params[:order_id])
	  @proposal = Proposal.new
	  @vendors = Vendor.all
	  @items = Item.all
    @proposal.proposal_lines.build

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @proposal }
    end
  end

  # GET /proposals/1/edit
  def edit
    @proposal = Proposal.find(params[:id])
    @order = Order.find(params[:order_id])
    @vendors = Vendor.all
    @items = Item.all
  end

  # POST /proposals
  # POST /proposals.json
  def create
    @proposal = Proposal.new(params[:proposal])

    respond_to do |format|
      if @proposal.save
        format.html { redirect_to order_proposals_path(@order), notice: 'Proposal was successfully created.' }
        format.json { render json: @proposal, status: :created, location: @proposal }
      else
        format.html { render action: "new" }
        format.json { render json: @proposal.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /proposals/1
  # PUT /proposals/1.json
  def update
    @proposal = Proposal.find(params[:id])
    @order = Order.find(params[:order_id])

    respond_to do |format|
      if @proposal.update_attributes(params[:proposal])
        format.html { redirect_to order_proposals_path(@order), notice: 'Proposal was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @proposal.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /proposals/1
  # DELETE /proposals/1.json
  def destroy
    @proposal = Proposal.find(params[:id])
    @order = Order.find(params[:order_id])
    @proposal.destroy

    respond_to do |format|
      format.html { redirect_to order_proposals_path(@order) }
      format.json { head :no_content }
    end
  end
end
