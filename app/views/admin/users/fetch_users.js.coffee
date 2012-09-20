$("#users").removeClass "loading"
$("#users").hide().html("<%=raw escape_javascript render :partial => 'admin/users/users_list'%>").fadeIn(500)
