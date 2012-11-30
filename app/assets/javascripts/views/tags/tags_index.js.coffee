class OpsApplication.Views.TagsIndex extends Backbone.View

  template: JST['tags/index']

  events:
    'submit #new_tag': 'createTag'

  initialize: ->
    @collection.on('reset', @render)
    @collection.on('add', @appendTag)
    @collection.on('remove', @render)

  render: =>
    $(@el).html(@template(collection: @collection))
    @collection.each(@appendTag)
    this

  appendTag: (tag) =>
    view = new OpsApplication.Views.Tag(model: tag)
    @$('#tags').append(view.render().el)

  createTag: (event) ->
    event.preventDefault()
    attributes =
      tag:
        name: $('#tag_name').val()
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_tag')[0].reset()
      error: @handleError

  handleError: (entry, response) ->
    if response.status == 422
      errors = $.parseJSON(response.responseText).errors
      for attribute, messages of errors
        alert "#{attribute} #{message}" for message in messages

