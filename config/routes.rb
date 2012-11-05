OpsApplication::Application.routes.draw do

  namespace :admin do resources :company_profiles end

  resources :meal_types

  resources :orders

  resources :menus

  resources :meals

  resources :items do
    match '/ingredients/:id(.:format)' => 'ingredients#destroy', :via => :delete, :as => :remove_ingredient
    resources :ingredients do
      resources :allergens
    end
    collection do
      get '/items/find_allergens?company_id=:id' => 'items#find_allergens'
    end
  end


  resources :vendor_profiles

  resources :locations

  resources :roles

  devise_for :users, :controllers => {:registrations => "registrations"} do
    get "/" => "dashboard#index"
    get "/staff_dashboard" => "dashboard#staff_dashboard"
    get "/vendor_dashboard" => "dashboard#vendor_dashboard"
    get "/client_dashboard" => "dashboard#client_dashboard"
  end

  resources :dashboard

  namespace "admin" do

    resources :vendors
    resources :companies
    resources :users do
      collection do
        get "clients/" => "users#fetch_users"
        get "vendors/" => "users#fetch_users"
        get "others/" => "users#fetch_users"
      end
      member do
        get "activation/" => "users#activation"
      end
    end
  end

  get "home" => "static_pages#home"

  root :to => "dashboard#index"



  # The priority is based upon order of creation:

  # first created -> highest priority.

  # Sample of regular route:
  #   match 'products/:id' => 'catalog#view'
  # Keep in mind you can assign values other than :controller and :action

  # Sample of named route:
  #   match 'products/:id/purchase' => 'catalog#purchase', :as => :purchase
  # This route can be invoked with purchase_url(:id => product.id)

  # Sample resource route (maps HTTP verbs to controller actions automatically):
  #   resources :products

  # Sample resource route with options:
  #   resources :products do
  #     member do
  #       get 'short'
  #       post 'toggle'
  #     end
  #
  #     collection do
  #       get 'sold'
  #     end
  #   end

  # Sample resource route with sub-resources:
  #   resources :products do
  #     resources :comments, :sales
  #     resource :seller
  #   end

  # Sample resource route with more complex sub-resources
  #   resources :products do
  #     resources :comments
  #     resources :sales do
  #       get 'recent', :on => :collection
  #     end
  #   end

  # Sample resource route within a namespace:
  #   namespace :admin do
  #     # Directs /admin/products/* to Admin::ProductsController
  #     # (app/controllers/admin/products_controller.rb)
  #     resources :products
  #   end

  # You can have the root of your site routed with "root"
  # just remember to delete public/index.html.
  # root :to => 'welcome#index'

  # See how all your routes lay out with "rake routes"

  # This is a legacy wild controller route that's not recommended for RESTful applications.
  # Note: This route will make all actions in every controller accessible via GET requests.
  # match ':controller(/:action(/:id))(.:format)'
end
