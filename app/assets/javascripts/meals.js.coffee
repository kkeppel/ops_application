$(document).ready ->
  $("#meal_company_id").change ->
    company_id = this.value
    $.ajax
      dataType: "json"
      url: "/locations/for_company_id/" + company_id
      timeout: 2000
      success: (data) ->
        $('select#meal_location_id option').remove()
        row = "<option value=\"" + "" + "\">" + "" + "</option>"
        $(row).appendTo("select#meal_location_id")
        $.each data, (i, j) ->
          row = "<option value=\"" + j.id + "\">" + j.name + "</option>"
          $(row).appendTo "select#meal_location_id"


  $(".add_preferences_field").click ->
    divName = $(".add_preferences_field").parent().attr 'id'
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