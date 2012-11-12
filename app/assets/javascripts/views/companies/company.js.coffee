class OpsApplication.Views.Company extends Backbone.View
  tagName: "option"

  initialize: ->
    _.bindAll(this, 'render')

  render: ->
    $(this.el).attr('value', this.model.get('id')).html(this.model.get('company_name'))
    this

