# Place all the behaviors and hooks related to the matching controller here.
# All this logic will automatically be available in application.js.
# You can use CoffeeScript in this file: http://jashkenas.github.com/coffee-script/

jQuery(document).ready ->
  $("#auto_complete").keyup ->
    $("#auto_complete").typeahead source: autocomplete_items

  $("#auto_complete").keypress (event) ->
    if event.which is 13
      event.preventDefault()
      $("#datepicker").show()
      $("#remove_datepicker").show()

  $("#meal_type").click ->
    $("#vendor").show()
    $("#remove_vendor").show()

  $ ->
    $("#datepicker").datepicker onSelect: ->
      $("#meal_type").show()
      $("#remove_meal_type").show()

  $("#remove_company").click ->
    $("#auto_complete").val ""
    $("#remove_datepicker").hide()
    $("#datepicker").hide().val ""
    $("#remove_meal_type").hide()
    $("#meal_type").hide().val ""
    $("#remove_vendor").hide()
    $("#vendor").hide().val ""

  $("#remove_datepicker").click ->
    $("#remove_datepicker").hide()
    $("#datepicker").hide().val ""
    $("#remove_meal_type").hide()
    $("#meal_type").hide().val ""
    $("#remove_vendor").hide()
    $("#vendor").hide().val ""

  $("#remove_meal_type").click ->
    $("#remove_meal_type").hide()
    $("#meal_type").hide().val ""
    $("#remove_vendor").hide()
    $("#vendor").hide().val ""

  $("#remove_vendor").click ->
    $("#remove_vendor").hide()
    $("#vendor").hide().val ""

