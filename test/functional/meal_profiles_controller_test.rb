require 'test_helper'

class MealProfilesControllerTest < ActionController::TestCase
  setup do
    @meal_profile = meal_profiles(:one)
  end

  test "should get index" do
    get :index
    assert_response :success
    assert_not_nil assigns(:meal_profiles)
  end

  test "should get new" do
    get :new
    assert_response :success
  end

  test "should create meal_profile" do
    assert_difference('MealProfile.count') do
      post :create, meal_profile: {  }
    end

    assert_redirected_to meal_profile_path(assigns(:meal_profile))
  end

  test "should show meal_profile" do
    get :show, id: @meal_profile
    assert_response :success
  end

  test "should get edit" do
    get :edit, id: @meal_profile
    assert_response :success
  end

  test "should update meal_profile" do
    put :update, id: @meal_profile, meal_profile: {  }
    assert_redirected_to meal_profile_path(assigns(:meal_profile))
  end

  test "should destroy meal_profile" do
    assert_difference('MealProfile.count', -1) do
      delete :destroy, id: @meal_profile
    end

    assert_redirected_to meal_profiles_path
  end
end
