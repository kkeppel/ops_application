require 'test_helper'

class VendorProfilesControllerTest < ActionController::TestCase
  setup do
    @vendor_profile = vendor_profiles(:one)
  end

  test "should get index" do
    get :index
    assert_response :success
    assert_not_nil assigns(:vendor_profiles)
  end

  test "should get new" do
    get :new
    assert_response :success
  end

  test "should create vendor_profile" do
    assert_difference('VendorProfile.count') do
      post :create, vendor_profile: { key: @vendor_profile.key, user_id: @vendor_profile.user_id, value2: @vendor_profile.value2, value: @vendor_profile.value, vendor_type_id: @vendor_profile.vendor_type_id }
    end

    assert_redirected_to vendor_profile_path(assigns(:vendor_profile))
  end

  test "should show vendor_profile" do
    get :show, id: @vendor_profile
    assert_response :success
  end

  test "should get edit" do
    get :edit, id: @vendor_profile
    assert_response :success
  end

  test "should update vendor_profile" do
    put :update, id: @vendor_profile, vendor_profile: { key: @vendor_profile.key, user_id: @vendor_profile.user_id, value2: @vendor_profile.value2, value: @vendor_profile.value, vendor_type_id: @vendor_profile.vendor_type_id }
    assert_redirected_to vendor_profile_path(assigns(:vendor_profile))
  end

  test "should destroy vendor_profile" do
    assert_difference('VendorProfile.count', -1) do
      delete :destroy, id: @vendor_profile
    end

    assert_redirected_to vendor_profiles_path
  end
end
