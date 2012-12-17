class OpsApplication.Routers.Orders extends Backbone.Router
  routes:
    'staff_dashboard': 'index'

  initialize: ->
    @vendors = new OpsApplication.Collections.Vendors
    @vendors.fetch(success: -> console.log(@vendors))
    @companies = new OpsApplication.Collections.Companies
    @companies.fetch(success: -> console.log(@companies))
    @items = new OpsApplication.Collections.Items
    @items.fetch(success: -> console.log(@items))
    @meals = new OpsApplication.Collections.Meals
    @meals.fetch(success: -> console.log(@meals))
    @menus = new OpsApplication.Collections.Menus
    @menus.fetch(success: -> console.log(@menus))
    @contacts = new OpsApplication.Collections.Contacts
    @contacts.fetch(success: -> console.log(@contacts))
    @collection = new OpsApplication.Collections.Orders()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.OrdersIndex(
      collection: @collection,
      vendors: @vendors,
      companies: @companies,
      items: @items,
      meals: @meals,
      menus: @menus,
      contacts: @contacts
    )
    $('#container').html(view.render().el)
