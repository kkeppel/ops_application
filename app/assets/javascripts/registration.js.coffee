$(document).ready ->
  $(document.body).on "click", ".management .btn", ->
    $("#users").addClass("loading").html("")

    $("#editUserPopover").tooltip

  # show pencil icon on hover in users index
  $ ->
    $("tr#edit_row").hover (->
      $(this).find("div.edit-pencil").hide()
    ), ->
      $(this).find("div.edit-pencil").show()
