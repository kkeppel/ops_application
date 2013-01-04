class DashboardController < Devise::SessionsController
  before_filter :authenticate_user!


  def index
    if user_signed_in?
      if current_user.is_client
        redirect_to :action => "client_dashboard"
      elsif current_user.is_vendor
        redirect_to :action => "vendor_dashboard"
      else
        render :action => "staff_dashboard"
      end
    else
      redirect_to :controller => "static_pages", :action => "home"
    end
  end


  def client_dashboard

  end

  def vendor_dashboard

  end

  def staff_dashboard
    @autocomplete_items = Company.all
    @meal_types = MealType.all
    @vendors = Vendor.all
  end


end
