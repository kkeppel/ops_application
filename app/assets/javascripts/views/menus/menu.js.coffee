class OpsApplication.Views.Menu extends Backbone.View
  template: JST['menus/menu']
  tagName: 'tr'

  events:
    'click #destroy_menu': 'destroyMenu'
    'click #save_changes': 'changeMenu'
    'click #edit_vendor_select': 'saveVendor'
    'click #edit_food_category_select': 'saveFoodCategory'

  initialize: ->
    @model.on('change', @render)

  render: =>
    menu = @model
    vendors = @options.vendors
    food_categories = @options.food_categories
    $(@el).html(@template(menu: @model, vendors: vendors, food_categories: food_categories))
    this

  saveFoodCategory: (event) ->
    event.preventDefault
    kids = event.target.children
    for k in kids
      fc_id = k.value if k.selected
      option_id = k.id if k.selected
    console.log option_id
    @model.save({
      food_category_id: fc_id
    },
      success: ->
        console.log "you can haz a new food category"
      error: ->
        console.log "wah wah"
    )
    $("#edit_food_category_select option[id='" + option_id + "']").attr("selected","selected")


  saveVendor: (event) ->
    event.preventDefault
    kids = event.target.children
    for k in kids
      v_id = k.value if k.selected
      option_id = k.id if k.selected
    @model.save({
      vendor_id: v_id
    },
      success: ->
        console.log "You the man now dog."
      error: ->
        console.log "OMG STILL DOES NOT WORK."
    )
    $("#edit_vendor_select option[id='" + option_id + "']").attr("selected","selected")

  changeMenu: (event) ->
    event.preventDefault()
    console.log @el.children
    @model.save({
      menu:
        name: @el.children[0].innerText
        headcount: @el.children[1].innerText
        total_per_head: @el.children[2].innerText
        total: @el.children[3].innerText
    },
      success: ->
        console.log "GREAT SUCCESS!"
      error: ->
        console.log "FAIL TOWN."
      silent: true
    )

  destroyMenu: (event) =>
    event.preventDefault()
    @model.destroy
      success: (model, response) ->
        this.remove
        this.unbind
        console.log "Success"
      error: (model, response) ->
        console.log "Error"
