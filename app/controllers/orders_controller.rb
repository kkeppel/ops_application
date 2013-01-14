class OrdersController < ApplicationController

  respond_to :html, :json

  def index
	  @orders = Order.all
	  @companies = Company.all

    respond_to do |format|
	    format.html
	    format.json { render json: @orders }
    end
  end

  def show
    respond_with(@order= Order.find(params[:id]))
  end

  def create
	  @order = Order.new(params[:order])

	  respond_to do |format|
		  if @order.save
			  format.html { redirect_to edit_order_path(@order), notice: 'Order was successfully created.' }
			  format.json { render json: @order, status: :created, location: @order }
		  else
			  format.html { render action: "new" }
			  format.json { render json: @order.errors, status: :unprocessable_entity }
		  end
	  end
  end

  def update
	  @order = Order.find(params[:id])

	  respond_to do |format|
		  if @order.update_attributes(params[:order])
			  format.html { redirect_to orders_path, notice: 'Order was successfully updated.' }
			  format.json { head :no_content }
		  else
			  format.html { render action: "edit" }
			  format.json { render json: @order.errors, status: :unprocessable_entity }
		  end
	  end
  end

  def destroy
    respond_with(@order = Order.destroy(params[:id]))
  end

  def new_order_and_proposal
	  Order.create
	  order_id = Order.last.id
	  redirect_to "/orders/#{order_id}/proposals/new"
  end

  def new
    @order = Order.new
    @companies = Company.all
    @locations = Location.all
    @proposals = Proposal.all

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @order }
    end
  end

  def edit
    @order = Order.find(params[:id])
    @companies = Company.all
    @locations = Location.all
    @proposals = Proposal.where(order_id: params[:id])
    @proposal_lines = ProposalLine.where(proposal_id: @proposals.map{|m| m.id})
    @proposal_statuses = ProposalStatus.all
    @items = Item.all
    @menus = Menu.all
	  #@order.proposals.build if @proposals.empty?

  end

  def import_proposal
		@order_id = params[:id]
		@proposals = Proposal.all

	  render 'proposals/index'
  end

	def clone_proposal
		@proposal_lines = []
		existing_proposal = Proposal.find(params[:id])
		@proposal = Proposal.new(existing_proposal.attributes)
		@proposal.update_attribute(:order_id, params[:order_id])

		existing_proposal_lines = ProposalLine.where(:proposal_id => params[:id])
		existing_proposal_lines.each do |line|
			new_proposal_line = ProposalLine.new(line.attributes)
			new_proposal_line.update_attribute(:proposal_id, @proposal.id)
			@proposal_lines << new_proposal_line
		end

		redirect_to edit_order_path(params[:order_id])
	end

	def update_locations
		company = Company.find(params[:company_id])
		#@locations = Location.where(company_id: company.id)
		@locations = company.locations.map{|l| [l.name, l.id]}.insert(0, "Select a Location")
	end

end
