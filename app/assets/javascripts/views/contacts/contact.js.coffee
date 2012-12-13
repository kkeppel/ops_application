class OpsApplication.Views.Contact extends Backbone.View
  template: JST['contacts/contact']
  tagName: 'tr'

  events:
    'click #destroy_contact': 'destroyContact'
    'click #save_changes': 'changeContact'
    'click #edit_vendor_select_contact': 'saveVendor'
    'click #edit_company_select_contact': 'saveCompany'
    'click #edit_location_select_contact': 'saveLocation'
    'click #edit_payment_type_select_contact': 'savePaymentType'

  initialize: ->
    @model.on('change', @render)

  render: =>
    contact = @model
    payment_types = @options.payment_types
    vendors = @options.vendors
    companies = @options.companies
    locations = @options.locations
    console.log payment_types
    console.log locations
    console.log vendors
    console.log companies
    payment_type_filter = payment_types.filter (payment_type) ->
      p_id = parseInt(payment_type.id)
      i_id = payment_type.get('payment_type_id')
      p_id == i_id
    payment_type = new OpsApplication.Models.PaymentType(payment_type_filter)
    location_filter = locations.filter (location) ->
      l_id = parseInt(location.id)
      i_id = contact.get('location_id')
      l_id == i_id
    location = new OpsApplication.Models.Location(location_filter)
    company_filter = companies.filter (company) ->
      c_id = parseInt(company.id)
      i_id = contact.get('company_id')
      c_id == i_id
    company = new OpsApplication.Models.Company(company_filter)
    vendor_filter = vendors.filter (vendor) ->
      v_id = parseInt(vendor.id)
      i_id = contact.get('vendor_id')
      v_id == i_id
    vendor = new OpsApplication.Models.Vendor(vendor_filter)
    $(@el).html(@template(
      contact: @model,
      payment_type: payment_type,
      payment_types: payment_types,
      vendor: vendor,
      vendors: vendors,
      company: company,
      companies: companies,
      location: location,
      locations: locations
    ))
    this

  savePaymentType: (event) ->
    event.preventDefault
    kids = event.target.children
    for k in kids
      p_id = k.value if k.selected
      option_id = k.id if k.selected
    @model.save({payment_type_id: p_id},
      success: -> console.log "New Payment Type, brah!"
      error: -> console.log "You are teh suck."
    )
    $("#edit_payment_type_select_contact option[id='" + option_id + "']").attr("selected","selected")

  saveLocation: (event) ->
    event.preventDefault
    kids = event.target.children
    for k in kids
      l_id = k.value if k.selected
      option_id = k.id if k.selected
    @model.save({location_id: l_id},
      success: -> console.log "New Location, brah!"
      error: -> console.log "You are teh suck."
    )
    $("#edit_location_select_contact option[id='" + option_id + "']").attr("selected","selected")

  saveCompany: (event) ->
    event.preventDefault
    kids = event.target.children
    for k in kids
      c_id = k.value if k.selected
      option_id = k.id if k.selected
    @model.save({company_id: c_id},
      success: -> console.log "New Company, brah!"
      error: -> console.log "You are teh suck."
    )
    $("#edit_company_select_contact option[id='" + option_id + "']").attr("selected","selected")

  saveVendor: (event) ->
    event.preventDefault
    kids = event.target.children
    for k in kids
      v_id = k.value if k.selected
      option_id = k.id if k.selected
    @model.save({vendor_id: v_id},
      success: -> console.log "You the man now dog."
      error: -> console.log "OMG STILL DOES NOT WORK."
    )
    $("#edit_vendor_select_contact option[id='" + option_id + "']").attr("selected","selected")


  changeContact: (event) ->
    event.preventDefault()
    d_contact = if @el.children[7].children[0].checked then true else false
    d_invoiced = if @el.children[8].children[0].checked then true else false
    was_lead = if @el.children[9].children[0].checked then true else false
    @model.save({
      contact:
        first_name: @el.children[1].innerText
        last_name: @el.children[2].innerText
        email: @el.children[3].innerText
        direct_phone: @el.children[4].innerText
        mobile_phone: @el.children[5].innerText
        carrier: @el.children[6].innerText
        default_contact: d_contact
        default_invoiced: d_invoiced
        was_lead: was_lead
      },
        success: -> console.log "GREAT SUCCESS!"
        error: -> console.log "FAIL TOWN."
        silent: true
      )

  destroyContact: (event) =>
    event.preventDefault()
    @model.destroy
      success: (model, response) ->
        this.remove
        console.log "Success"
      error: (model, response) ->
        console.log "Error"
