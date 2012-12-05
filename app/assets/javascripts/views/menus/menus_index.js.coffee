class OpsApplication.Views.MenusIndex extends Backbone.View

  template: JST['menus/index']

  events:
    'submit #new_menu': 'createMenu'

  initialize: ->
    @vendors = new OpsApplication.Collections.Vendors
    @vendors.fetch(success: -> console.log(@vendors))
    @food_categories = new OpsApplication.Collections.FoodCategories
    @food_categories.fetch(success: -> console.log(@food_categories))
    @collection.on('reset', @render)
    @collection.on('add', @appendMenu)
    @collection.on('remove', @render)

  render: =>
    $(@el).html(@template(collection: @collection, vendors: @vendors, food_categories: @food_categories))
    @collection.each(@appendMenu)
    this

  appendMenu: (menu) =>
    view = new OpsApplication.Views.Menu(model: menu)
    @$('#menus').append(view.render().el)

  createMenu: (event) ->
    event.preventDefault()
    attributes =
      menu:
        name: $('#menu_name').val()
        headcount: $('#menu_headcount').val()
        total: $('#menu_total').val()
        total_per_head: $('#menu_total_per_head').val()
        food_category_id: $('#menu_food_category_id').val()
        vendor_id: $('#menu_vendor_id').val()
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_menu')[0].reset()
      error: @handleError

  handleError: (entry, response) ->
    if response.status == 422
      errors = $.parseJSON(response.responseText).errors
      for attribute, messages of errors
        alert "#{attribute} #{message}" for message in messages
