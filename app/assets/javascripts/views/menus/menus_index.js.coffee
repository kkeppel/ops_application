class OpsApplication.Views.MenusIndex extends Backbone.View

  template: JST['menus/index']

  events:
    'submit #new_menu': 'createMenu'
    'click #vendor_select': 'loadItems'

  initialize: ->
    @items = new OpsApplication.Collections.Items
    @items.fetch(success: -> console.log(@items))
    @items_menus = new OpsApplication.Collections.ItemsMenus
    @items_menus.fetch(success: -> console.log(@items_menus))
    @vendors = new OpsApplication.Collections.Vendors
    @vendors.fetch(success: -> console.log(@vendors))
    @food_categories = new OpsApplication.Collections.FoodCategories
    @food_categories.fetch(success: -> console.log(@food_categories))
    @food_categories.on('reset', @render)
    @vendors.on('reset', @render)
    @items.on('reset', @render)
    @collection.on('reset', @render)
    @collection.on('add', @appendMenu)
    @collection.on('remove', @render)

  render: =>
    $(@el).html(@template(collection: @collection, vendors: @vendors, food_categories: @food_categories, items: @items))
    @collection.each(@appendMenu)
    this

  appendMenu: (menu) =>
    view = new OpsApplication.Views.Menu(model: menu, food_categories: @food_categories, vendors: @vendors)
    @$('#menus').append(view.render().el)

  loadItems: (event) ->
    kids = event.target.children
    for k in kids
      vendor_id = k.value if k.selected
    items = @items.filter (i) ->
      i.get('vendor_id') == parseInt(vendor_id)
    vendor = @vendors.filter (v) ->
      v.get('id') == parseInt(vendor_id)
    $("#items_title").html(
      "<h4>Items for " + vendor[0].get('name') + "</h4>"
    )
    $("div#items").html(
      for item in items
        "</div><div class='row'><input type='checkbox' id='items_menus_item_id' value='"+item.get('id')+"'/>   "+item.get('name')+"</div>"
    )
    this

  createMenu: (event) ->
    event.preventDefault()
    new_items = []
    items = document.getElementById('items').children
    for i in items
      if i.children[0].checked
        new_items.push(parseInt(i.children[0].value))
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
      success: (menu, response) ->
        for item in new_items
          $.ajax
            url: '/items_menus'
            type: 'POST'
            dataType: 'json'
            data:
              items_menus:
                item_id: item
                menu_id: response.id
                quantity: 2
            async: false
            silent: true
            success: ->
              console.log "brilliant!!"
        $('#new_menu')[0].reset()
      error: @handleError

  handleError: (entry, response) ->
    if response.status == 422
      errors = $.parseJSON(response.responseText).errors
      for attribute, messages of errors
        alert "#{attribute} #{message}" for message in messages
