class OpsApplication.Views.VendorTypesIndex extends Backbone.View

  template: JST['vendor_types/index']

  events:
    'submit #new_vendor_type': 'createVendorType'

  initialize: ->
    @collection.on('reset', @render)
    @collection.on('add', @appendVendorType)
    @collection.on('remove', @render)

  render: =>
    $(@el).html(@template(collection: @collection))
    @collection.each(@appendVendorType)
    this

  appendVendorType: (vendor_type) =>
    view = new OpsApplication.Views.VendorType(model: vendor_type)
    @$('#vendor_types').append(view.render().el)

  createVendorType: (event) ->
    event.preventDefault()
    attributes =
      vendor_type:
        name: $('#vendor_type_name').val()
        description: $('#vendor_type_description').val()
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_vendor_type')[0].reset()
      error: @handleError

  handleError: (entry, response) ->
    if response.status == 422
      errors = $.parseJSON(response.responseText).errors
      for attribute, messages of errors
        alert "#{attribute} #{message}" for message in messages


