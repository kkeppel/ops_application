# Place all the behaviors and hooks related to the matching controller here.
# All this logic will automatically be available in application.js.
# You can use CoffeeScript in this file: http://jashkenas.github.com/coffee-script/


#show edit button on Users table
$("#users table tr").on mouseenter: ->
  $(this).find("i").removeClass "hide"
, mouseleave: ->
  $(this).find("i").addClass "hide"
, "tr"
