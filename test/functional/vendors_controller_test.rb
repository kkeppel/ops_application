require 'test_helper'

class VendorsControllerTest < ActionController::TestCase
  setup do
    @vendor = vendors(:one)
  end

  test "should get index" do
    get :index
    assert_response :success
    assert_not_nil assigns(:vendors)
  end

  test "should get new" do
    get :new
    assert_response :success
  end

  test "should create vendor" do
    assert_difference('Vendor.count') do
      post :create, vendor: { bio: @vendor.bio, name: @vendor.name, public_name: @vendor.public_name, tagline: @vendor.tagline, vendor_type: @vendor.vendor_type, website: @vendor.website }
    end

    assert_redirected_to vendor_path(assigns(:vendor))
  end

  test "should show vendor" do
    get :show, id: @vendor
    assert_response :success
  end

  test "should get edit" do
    get :edit, id: @vendor
    assert_response :success
  end

  test "should update vendor" do
    put :update, id: @vendor, vendor: { bio: @vendor.bio, name: @vendor.name, public_name: @vendor.public_name, tagline: @vendor.tagline, vendor_type: @vendor.vendor_type, website: @vendor.website }
    assert_redirected_to vendor_path(assigns(:vendor))
  end

  test "should destroy vendor" do
    assert_difference('Vendor.count', -1) do
      delete :destroy, id: @vendor
    end

    assert_redirected_to vendors_path
  end
end
