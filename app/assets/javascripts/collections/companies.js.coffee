class OpsApplication.Collections.Companies extends Backbone.Collection
  url: '/admin/companies'
  model: OpsApplication.Models.Company

  chosenCompany: ->
    filteredCompany = this.select((company) ->
      company.get('id') == this.get('id')
    )
    new Companies(filteredCompany)
