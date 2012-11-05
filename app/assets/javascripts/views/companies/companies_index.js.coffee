class OpsApplication.Views.CompaniesIndex extends Backbone.View

  template: JST['companies/index']

  events:
    'click #company_select': 'showCalendar'
    'click #datepicker': 'appendMealTypes'
    'click #company_select': 'findCompany'

  initialize: ->
    @meal_types = new OpsApplication.Collections.MealTypes
    @meal_types.fetch()
    @collection.on('reset', @render)

  render: =>
    $(@el).html(@template({companies: @collection}))
    this

  showCalendar: (event) ->
    event.preventDefault()
    $('#datepicker').datepicker()
    @$('#datepicker').show()

  appendMealTypes: ->
    meal_type_view = new OpsApplication.Views.MealTypesIndex(collection: @meal_types)
    $('#companies_container').append(meal_type_view.render().el)

  findCompany: (event) ->
    $.ajax ->
      console.log(event)
      id = this.val()
      url: '/items/find_allergens?company_id=' + id,
      type: 'get',
      dataType: 'html',
      processData: false
