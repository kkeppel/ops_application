$(document).ready ->
  $(document.body).on "click", ".management .btn", ->
    $("#users").addClass("loading").html("")