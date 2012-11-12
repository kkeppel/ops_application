require 'test_helper'

class Admin::CompanyProfilesControllerTest < ActionController::TestCase
  setup do
    @admin_company_profile = admin_company_profiles(:one)
  end

  test "should get index" do
    get :index
    assert_response :success
    assert_not_nil assigns(:admin_company_profiles)
  end

  test "should get new" do
    get :new
    assert_response :success
  end

  test "should create admin_company_profile" do
    assert_difference('Admin::CompanyProfile.count') do
      post :create, admin_company_profile: {  }
    end

    assert_redirected_to admin_company_profile_path(assigns(:admin_company_profile))
  end

  test "should show admin_company_profile" do
    get :show, id: @admin_company_profile
    assert_response :success
  end

  test "should get edit" do
    get :edit, id: @admin_company_profile
    assert_response :success
  end

  test "should update admin_company_profile" do
    put :update, id: @admin_company_profile, admin_company_profile: {  }
    assert_redirected_to admin_company_profile_path(assigns(:admin_company_profile))
  end

  test "should destroy admin_company_profile" do
    assert_difference('Admin::CompanyProfile.count', -1) do
      delete :destroy, id: @admin_company_profile
    end

    assert_redirected_to admin_company_profiles_path
  end
end
