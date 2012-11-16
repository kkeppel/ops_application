require 'test_helper'

class VendorTypesControllerTest < ActionController::TestCase
  setup do
    @vendor_type = vendor_types(:one)
  end

  test "should get index" do
    get :index
    assert_response :success
    assert_not_nil assigns(:vendor_types)
  end

  test "should get new" do
    get :new
    assert_response :success
  end

  test "should create vendor_type" do
    assert_difference('VendorType.count') do
      post :create, vendor_type: {  }
    end

    assert_redirected_to vendor_type_path(assigns(:vendor_type))
  end

  test "should show vendor_type" do
    get :show, id: @vendor_type
    assert_response :success
  end

  test "should get edit" do
    get :edit, id: @vendor_type
    assert_response :success
  end

  test "should update vendor_type" do
    put :update, id: @vendor_type, vendor_type: {  }
    assert_redirected_to vendor_type_path(assigns(:vendor_type))
  end

  test "should destroy vendor_type" do
    assert_difference('VendorType.count', -1) do
      delete :destroy, id: @vendor_type
    end

    assert_redirected_to vendor_types_path
  end
end
