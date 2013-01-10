OpsApplication::Application.routes.draw do

  get '/items/get_items' => 'items#get_items'
  match '/allergens/get_allergens/:id' => 'allergens#get_allergens', :via => :get
  match '/allergens/get_ingredients' => 'allergens#get_ingredients', :via => :get
  match '/locations/for_company_id/:id' => 'locations#for_company_id', :via => :get

  match '/orders/new_order_and_proposal' => 'orders#new_order_and_proposal', :as => :new_order_and_proposal, :via => :get

  resources :payment_types

  resources :items_menus

  resources :tags

  resources :food_categories

  resources :item_types

  resources :contacts

  resources :proposal_lines

  resources :proposal_statuses

  resources :proposals

  resources :items

  resources :meal_preferences

  resources :meal_types

  resources :vendor_types

  resources :orders do
	  resources :proposals
  end

  resources :proposals do
	  resources :proposal_lines

	  resources :proposal_statuses
  end

  resources :menus

  resources :meals

  resources :items do
    match '/ingredients/:id(.:format)' => 'ingredients#destroy', :via => :delete, :as => :remove_ingredient
    resources :ingredients
  end

  resources :ingredients do
    resources :allergens
  end

  resources :allergens

  resources :meal_profiles

  resources :company_profiles

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


  resources :vendors do
    resources :locations
    resources :contacts
	  resources :items
  end

  resources :companies do
    resources :locations
    resources :contacts
  end

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
  #     # Directs /admin/products/* to ProductsController
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
