class OpsApplication.Views.Item extends Backbone.View
  template: JST['items/item']
  tagName: 'tr'

  events:
    'click #destroy_item': 'destroyItem'
    'click #save_changes': 'changeItem'
    'click #edit_vendor_select': 'saveVendor'

  initialize: ->
    @model.on('change', @render)

  render: =>
    item = @model
    vendors = @options.vendors
    @filter = vendors.filter (vendor) ->
      v_id = parseInt(vendor.id)
      i_id = item.get('vendor_id')
      v_id == i_id
    vendor = new OpsApplication.Models.Vendor(@filter)
    $(@el).html(@template(item: @model, vendor: vendor, vendors: vendors))
    this

  saveVendor: (event) ->
    event.preventDefault
    kids = event.target.children
    for k in kids
      v_id = k.value if k.selected
    attributes = {vendor_id: v_id}
    @model.set attributes
    @model.save
      success: ->
        console.log "You the man now dog."
      error: ->
        console.log "OMG STILL DOES NOT WORK."
    $("#edit_vendor_select option[id='" + v_id + "']").attr("selected","selected")


  changeItem: (event) ->
    event.preventDefault()
    temp_bool = @el.children[2].innerText == 'yes' ? true : false
    attributes = {
      name: @el.children[0].innerText
      description: @el.children[1].innerText
      hot: temp_bool
      price: @el.children[3].innerText
    }
    @model.set attributes
    @model.save
      success: ->
        console.log "GREAT SUCCESS!"
      error: ->
        console.log "FAIL TOWN."

  destroyItem: (event) =>
    event.preventDefault()
    @model.destroy
      success: (model, response) ->
        this.remove
        console.log "Success"
        console.log model
        console.log response
      error: (model, response) ->
        console.log "Error"
        console.log model
        console.log response
