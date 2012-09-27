require 'test_helper'

class ClientProfilesControllerTest < ActionController::TestCase
  setup do
    @client_profile = client_profiles(:one)
  end

  test "should get index" do
    get :index
    assert_response :success
    assert_not_nil assigns(:client_profiles)
  end

  test "should get new" do
    get :new
    assert_response :success
  end

  test "should create client_profile" do
    assert_difference('ClientProfile.count') do
      post :create, client_profile: { key: @client_profile.key, user_id: @client_profile.user_id, value2: @client_profile.value2, value: @client_profile.value }
    end

    assert_redirected_to client_profile_path(assigns(:client_profile))
  end

  test "should show client_profile" do
    get :show, id: @client_profile
    assert_response :success
  end

  test "should get edit" do
    get :edit, id: @client_profile
    assert_response :success
  end

  test "should update client_profile" do
    put :update, id: @client_profile, client_profile: { key: @client_profile.key, user_id: @client_profile.user_id, value2: @client_profile.value2, value: @client_profile.value }
    assert_redirected_to client_profile_path(assigns(:client_profile))
  end

  test "should destroy client_profile" do
    assert_difference('ClientProfile.count', -1) do
      delete :destroy, id: @client_profile
    end

    assert_redirected_to client_profiles_path
  end
end
