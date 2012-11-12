# Place all the behaviors and hooks related to the matching controller here.
# All this logic will automatically be available in application.js.
# You can use CoffeeScript in this file: http://jashkenas.github.com/coffee-script/


$(document).ready ->
  $(".add_allergies_field").click ->
    divName = $(".add_allergies_field").parent().attr 'id'
    addTextField(divName)
  $(".add_favorite_foods_field").click ->
    divName = $(".add_favorite_foods_field").parent().attr 'id'
    addTextField(divName)


addTextField = (divName) ->
#  UNCOMMENT TO ADD A LIMIT
#  if counter is limit
#    alert "You have reached the limit of adding " + counter + " inputs"
#  else
  modelName = divName.split("_")[0]
  keyName = divName.split("_")[1..-1]
  if keyName instanceof Array
    keyName = keyName.join "_"

  newdiv = document.createElement("div")
  newdiv.setAttribute("class","field")

  counter++

  newbutton = document.createElement("input")
  newbutton.setAttribute("type", "button")
  newbutton.setAttribute("value", "Remove")
  newbutton.setAttribute("id","remove_" + keyName + "_" + counter )

  newdiv.innerHTML = "<input type='text' id='" + divName + "_" + counter + "' name='" + modelName + "[" + keyName + "][" + counter + "]' size='30'/>"

  newbutton.setAttribute("onclick", "$('#" + modelName + "_" + keyName + "_" + counter + "').remove();$('#remove_" + keyName + "_" + counter + "').remove();")
  newbutton.innerHTML = "<input type='button' value='Remove' id='remove_" + keyName + "_" + counter + "'"


  document.getElementById(divName).appendChild newdiv
  newdiv.appendChild newbutton

counter = 100
#limit = 3

