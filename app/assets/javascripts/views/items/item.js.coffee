class OpsApplication.Views.Item extends Backbone.View
  template: JST['items/item']
  tagName: 'tr'

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
    $(@el).html(@template(item: @model, vendor: vendor))
    this