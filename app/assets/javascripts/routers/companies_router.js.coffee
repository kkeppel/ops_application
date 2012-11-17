class OpsApplication.Routers.Companies extends Backbone.Router

  initialize: ->
    @collection = new OpsApplication.Collections.Companies()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.CompaniesIndex({
      collection: @collection
    })
    $('#companies_container').html(view.render().el)
