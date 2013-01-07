<% if @user.active? %>
  $("#<%= @user.id %>").text "Deactivate"
  $("#<%= @user.id %>").attr('href', $("#<%= @user.id %>").attr('href').replace("activate", "deactivate"))
<% else %>
  $("#<%= @user.id %>").text "Activate"
  $("#<%= @user.id %>").attr('href', $("#<%= @user.id %>").attr('href').replace("deactivate", "activate"))
<% end %>