class OpsApplication.Views.CompaniesIndex extends Backbone.View

  template: JST['companies/index']

  events:
    'click #company_select': 'showCalendar'

  initialize: ->
    @collection.on('reset', @render, this)

  render: ->
    $(@el).html(@template(companies: @collection))
    this

  showCalendar: (event) ->
    event.preventDefault()
    @$('#datepicker').show()
