class OpsApplication.Views.ContactsIndex extends Backbone.View

  template: JST['contacts/index']

  events:
    'click #create_contact': 'createContact'

  initialize: ->
    @collection.on('reset', @render)
    @collection.on('add', @appendContact)
    @collection.on('remove', @render)

  render: =>
    console.log "OH HEY!"
    $(@el).html(@template(vendors: @options.vendors, companies: @options.companies, locations: @options.locations))
    @collection.each(@appendContact)
    this

  appendContact: (contact) =>
    console.log "HI THERE!"
    view = new OpsApplication.Views.Contact(
      model: contact,
      vendors: @options.vendors,
      companies: @options.companies,
      locations: @options.locations
    )
    @$('#contacts').append(view.render().el)

  createContact: (event) ->
    alert "OMG HI!"
    event.preventDefault()
    attributes = {
      first_name: $('#contact_first_name').val()
      last_name: $('#contact_last_name').val()
      email: $('#contact_email').val()
      direct_phone: $('.contact_direct_phone').val()
      mobile_phone: $('#contact_mobile_phone').val()
      carrier: $('#contact_carrier').val()
      title: $('#contact_title').val()
      default_contact: $('#contact_default_contact').val()
      default_invoiced: $('#contact_default_invoiced').val()
      was_lead: $('#contact_was_lead').val()
      company_id: $('#contact_company_id').val()
      vendor_id: $('#contact_vendor_id').val()
      location_id: $('#contact_location_id').val()
    }
    @collection.create attributes,
      wait: true
      success: ->
        $('#new_contact')[0].reset()
        console.log "You are here!"
      error: @handleError

  handleError: (entry, response) ->
    if response.status == 422
      errors = $.parseJSON(response.responseText).errors
      for attribute, messages of errors
        alert "#{attribute} #{message}" for message in messages
