class OpsApplication.Views.LocationsIndex extends Backbone.View

  template: JST['locations/index']

  events:
    'submit #new_location': 'createLocation'

  initialize: ->
    @collection.on('reset', @render)
    @collection.on('add', @appendLocation)
    @collection.on('remove', @render)

  render: =>
    $(@el).html(@template(collection: @collection))
    @collection.each(@appendLocation)
    this

  appendLocation: (location) =>
    view = new OpsApplication.Views.Location(model: location)
    @$('#locations').append(view.render().el)

  createLocation: (event) ->
    event.preventDefault()
    attributes =
      location:
        name: $('#location_name').val()
        address1: $('#location_address1').val()
        address2: $('#location_address2').val()
        floor: $('#location_floor').val()
        city_id: $('#location_city_id').val()
        vendor_id: $('#location_vendor_id').val()
        company_id: $('#location_company_id').val()
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_location')[0].reset()
      error: @handleError

  handleError: (entry, response) ->
    if response.status == 422
      errors = $.parseJSON(response.responseText).errors
      for attribute, messages of errors
        alert "#{attribute} #{message}" for message in messages


