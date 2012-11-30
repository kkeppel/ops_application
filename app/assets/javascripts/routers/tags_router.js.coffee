class OpsApplication.Routers.Tags extends Backbone.Router
  routes:
    'tags': 'index'

  initialize: ->
    @collection = new OpsApplication.Collections.Tags()
    @collection.fetch()

  index: ->
    view = new OpsApplication.Views.TagsIndex({collection: @collection})
    $('#tags_container').html(view.render().el)
