class AddFoodCategoriesToItems < ActiveRecord::Migration
  def change
	  add_column :items, :food_category_id, :integer
	  add_column :items, :menu_id, :integer
	  add_column :items, :vegetarian, :boolean
	  add_column :items, :dairy, :boolean
	  add_column :items, :nuts, :boolean
	  add_column :items, :eggs, :boolean
	  add_column :items, :soy, :boolean
	  add_column :items, :honey, :boolean
	  add_column :items, :shellfish, :boolean
	  add_column :items, :alcohol, :boolean
	  add_column :items, :taxed, :boolean
	  add_column :items, :individual_menus, :boolean
	  add_column :items, :old, :boolean
		add_column :items, :calories_per_serving, :integer
	  add_column :items, :notes, :text
	  add_column :items, :nutritional_information, :text

	  remove_column :items, :vendor_profiles_id
  end
end
