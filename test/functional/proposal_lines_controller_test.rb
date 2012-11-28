require 'test_helper'

class ProposalLinesControllerTest < ActionController::TestCase
  setup do
    @proposal_line = proposal_lines(:one)
  end

  test "should get index" do
    get :index
    assert_response :success
    assert_not_nil assigns(:proposal_lines)
  end

  test "should get new" do
    get :new
    assert_response :success
  end

  test "should create proposal_line" do
    assert_difference('ProposalLine.count') do
      post :create, proposal_line: {  }
    end

    assert_redirected_to proposal_line_path(assigns(:proposal_line))
  end

  test "should show proposal_line" do
    get :show, id: @proposal_line
    assert_response :success
  end

  test "should get edit" do
    get :edit, id: @proposal_line
    assert_response :success
  end

  test "should update proposal_line" do
    put :update, id: @proposal_line, proposal_line: {  }
    assert_redirected_to proposal_line_path(assigns(:proposal_line))
  end

  test "should destroy proposal_line" do
    assert_difference('ProposalLine.count', -1) do
      delete :destroy, id: @proposal_line
    end

    assert_redirected_to proposal_lines_path
  end
end
