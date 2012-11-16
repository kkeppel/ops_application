require 'test_helper'

class MealPreferencesControllerTest < ActionController::TestCase
  setup do
    @meal_preference = meal_preferences(:one)
  end

  test "should get index" do
    get :index
    assert_response :success
    assert_not_nil assigns(:meal_preferences)
  end

  test "should get new" do
    get :new
    assert_response :success
  end

  test "should create meal_preference" do
    assert_difference('MealPreference.count') do
      post :create, meal_preference: {  }
    end

    assert_redirected_to meal_preference_path(assigns(:meal_preference))
  end

  test "should show meal_preference" do
    get :show, id: @meal_preference
    assert_response :success
  end

  test "should get edit" do
    get :edit, id: @meal_preference
    assert_response :success
  end

  test "should update meal_preference" do
    put :update, id: @meal_preference, meal_preference: {  }
    assert_redirected_to meal_preference_path(assigns(:meal_preference))
  end

  test "should destroy meal_preference" do
    assert_difference('MealPreference.count', -1) do
      delete :destroy, id: @meal_preference
    end

    assert_redirected_to meal_preferences_path
  end
end
