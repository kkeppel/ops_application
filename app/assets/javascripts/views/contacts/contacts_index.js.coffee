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
    $(@el).html(@template(
      vendors: @options.vendors,
      companies: @options.companies,
      locations: @options.locations,
      payment_types: @options.payment_types
    ))
    @collection.each(@appendContact)
    this

  appendContact: (contact) =>
    console.log "HI THERE!"
    view = new OpsApplication.Views.Contact(
      model: contact,
      payment_types: @options.payment_types,
      vendors: @options.vendors,
      companies: @options.companies,
      locations: @options.locations
    )
    @$('#contacts').append(view.render().el)

  createContact: (event) ->
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
      payment_type_id: $('#contact_payment_type_id').val()
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
