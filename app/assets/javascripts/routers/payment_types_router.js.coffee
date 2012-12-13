class OpsApplication.Routers.PaymentTypes extends Backbone.Router
  routes:
    'payment_types': 'index'

  initialize: ->
    @collection = new OpsApplication.Collections.PaymentTypes
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.PaymentTypesIndex(collection: @collection)
    $('#payment_types_container').html(view.render().el)
