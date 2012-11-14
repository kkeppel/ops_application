class OpsApplication.Views.ItemsIndex extends Backbone.View

  template: JST['items/index']

  events:
    'submit #new_item': 'createItem'

  initialize: ->
    @collection.on('reset', @render)
    @collection.on('add', @appendItem)

  render: =>
    $(@el).html(@template(vendors: @options.vendors))
    @collection.each(@appendItem)
    this

  appendItem: (item) =>
    view = new OpsApplication.Views.Item(model: item, vendors: @options.vendors)
    @$('#items_container').append(view.render().el)

  createItem: (event) ->
    event.preventDefault()
    attributes = {
      name: $('#new_item_name').val()
      description: $('#new_item_description').val()
      price: $('#new_item_price').val()
      hot: $('.new_item_hot').val()
      headcount: $('#new_item_headcount').val()
      vendor_id: $('#new_item_vendor_id').val()
      ingredient_ids: $('#new_ingredient_ids').val()
      serving_instructions_id: 2
      vendor_profiles_id: 2
    }
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_item')[0].reset()
      error: @handleError

  handleError: (entry, response) ->
    if response.status == 422
      errors = $.parseJSON(response.responseText).errors
      for attribute, messages of errors
        alert "#{attribute} #{message}" for message in messages
