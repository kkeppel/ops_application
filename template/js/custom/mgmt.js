
c2me_mgmt = {
	
	curCompanyId:0,
	companyUsers:Array(),
	
	loadCompany:function(id) {
		
		$.getJSON("/Ajax-mgmt.php", { company: id }, function(json) {
		
			if(typeof json.info != "undefined") {
				alert(json.info);
				return;
			}
			
			//basic company info
			 c2me_mgmt.curCompanyId = json.id_company;
			 $('#company_name').val(json.name);
			 $('#address').val(json.address);
			 $('#cross_streets').val(json.cross_streets);
			 $('#city').val(json.city);
			 $('#zip').val(json.zip);
			 $('#state').val(json.state);
			 $('#country').val(json.country);
			 $('#website').val(json.website);
			 $('#notes').val(json.notes);
			 $('#fee').val(json.fee);
			 $('#invoice_first_name').val(json.invoice_first_name);
			 $('#invoice_last_name').val(json.invoice_last_name);
			 $('#invoice_email').val(json.invoice_email);
			 $('#default_tip').val(json.default_tip);
			 
			 
			 //users
			 c2me_mgmt.companyUsers=json.users; //init
			 
			 c2me_mgmt.genCompanyUsers();
		});
		
	},
	
	genCompanyUsers:function() {
		tmp="<table>";
		tmp+="<tr><th> Username </th><th> First name </th><th> Last name </th><th> Title </th><th> Email </th><th> Email 2 </th><th> Phone </th><th> Personal # </th><th> Extension </th><th> Fax </th><th> Notes </th>";
		for(user in c2me_mgmt.companyUsers) {
			console.log(user);
			tmp+="<tr>";
			tmp+='<td> <input type="text" id="" value="'+c2me_mgmt.companyUsers[user].username+'" /> </td>';
			tmp+='<td> <input type="text" id="" value="'+c2me_mgmt.companyUsers[user].first_name+'" /> </td>';
			tmp+='<td> <input type="text" id="" value="'+c2me_mgmt.companyUsers[user].last_name+'" /> </td>';
			tmp+='<td> <input type="text" id="" value="'+c2me_mgmt.companyUsers[user].title+'" /> </td>';
			tmp+='<td> <input type="text" id="" value="'+c2me_mgmt.companyUsers[user].email+'" /> </td>';
			tmp+='<td> <input type="text" id="" value="'+c2me_mgmt.companyUsers[user].email2+'" /> </td>';
			tmp+='<td> <input type="text" id="" value="'+c2me_mgmt.companyUsers[user].phone_number+'" /> </td>';
			tmp+='<td> <input type="text" id="" value="'+c2me_mgmt.companyUsers[user].personal_number+'" /> </td>';
			tmp+='<td> <input type="text" id="" value="'+c2me_mgmt.companyUsers[user].extension+'" /> </td>';
			tmp+='<td> <input type="text" id="" value="'+c2me_mgmt.companyUsers[user].fax_number+'" /> </td>';
			tmp+='<td> <input type="text" id="" value="'+c2me_mgmt.companyUsers[user].notes+'" /> </td>';
			tmp+="</tr>";
		}
		tmp+="</table>";
		
		$("#div_company_users").html(tmp);
		
	},
	
	
	
	
	curVendorId:0,
	
	loadVendor:function(id) {
		
		$.getJSON("/Ajax-mgmt.php", { vendor: id }, function(json) {
		
			if(typeof json.info != "undefined") {
				alert(json.info);
				return;
			}
			
			//basic vendor info
			 c2me_mgmt.curVendorId = json.id_vendor;
			 $('#vendor_name').val(json.name);
			 $('#vendor_public_name').val(json.public_name);
			 $('#address').val(json.address);
			 $('#city').val(json.city);
			 $('#zip').val(json.zip);
			 $('#state').val(json.state);
			 $('#country').val(json.country);
			 $('#website').val(json.website);
			 $('#delivery_start').val(json.delivery_start);
			 $('#delivery_end').val(json.delivery_end);
			 $('#max_order_size').val(json.max_order_size);
			 $('#lead_time_needed').val(json.lead_time_needed);
			 $('#delivery_area').val(json.delivery_area);
			 $('#delivery_notes').val(json.delivery_notes);
			 
		});
		
	},
	
	
	
	
	curOrderId:0,
	
	loadOrder:function(id) {
		
		$.getJSON("/Ajax-mgmt.php", { order: id }, function(json) {
			
			if(typeof json.info != "undefined") {
				alert(json.info);
				return;
			}
			
			// (some fields missing)
			
			//order info
			 c2me_mgmt.curOrderId = json.id_order;
			 $('#span_oid').html(json.id_order);
			 $('#order_status').val(json.order_status_id);
			 $('#payment_method').val(json.payment_method_id);
			 $('#meal_type').val(json.meal_type_id);
			 $('#order_created').html(json.order_created);
			 
			 $('#when_date').val(json.order_for.substring(0,10));
			 $('#when_time').val(json.order_for.substring(11));
			 
			 $('#employees').val(json.employees);
			 $('#max_price').val(json.max_price);
			 
			 $('#notes').val(json.notes);
			 $('#tip').val(json.tip);
			 
			 
			 $('#max_order_size').val(json.max_order_size);
			 $('#lead_time_needed').val(json.lead_time_needed);
			 $('#delivery_area').val(json.delivery_area);
			 $('#delivery_notes').val(json.delivery_notes);
			 
			 c2me_mgmt.loadOrderProposals(json.id_order);
		});
		
	},
	
	loadOrderProposals:function(oid) {
		
		$.getJSON("/Ajax-mgmt.php", { proposals_for: oid }, function(json) {
			
			if(typeof json.info != "undefined") {
				alert(json.info);
				return;
			}
			
			//console.log(json);
			$("#div_order_proposals").html('');
			
			var proposals=Array();
			
			for(prop in json)
			{
				id_prop = json[prop].id_order_proposal;
				
				
				var append = "<h3>"+json[prop].name+"</h3> <div id='prop_"+id_prop+"'>";
				
				
				
				
				append+= "<fieldset><legend>C2me details</legend>";
				append+= "<div style='float:left'>";
				append+= "<table>";
				append+= "	<tr>";
				append+= "		<td> Total: </td>";
				append+= "		<td> <span id='prop_total_" + id_prop + "'>$1234.00</span> </td>";
				append+= "		<td> Without tax: </td>";
				append+= "		<td> <span id='prop_total_without_tax_" + id_prop + "'>$1234.00</span> </td>";
				append+= "	</tr>";
				append+= "	<tr>";
				append+= "		<td> Service fee: </td>";
				append+= "		<td> $ <input type='text' class='prop_service_fee' id='prop_service_fee_" + id_prop + "' value='" + json[prop].service_fee + "'> </span> </td>";
				append+= "		<td> Total with fee: </td>";
				append+= "		<td> <span id='prop_total_with_fee_" + id_prop + "'>$1234.00</span> </td>";
				append+= "	</tr>";
				append+= "</table>";
				append+= "</div>";
				append+= "<div style='float:left'>";
				append+= "<input type='button' value='select' disabled='true' />";
				append+= "</div>";
				append+= "</fieldset>";
				
				
				
				
				
				append+= "<fieldset class='fldt_items'><legend>Items</legend>";
				append+= "<table >";
				append+= "<tr>";
				append+= "<th>Name</th> <th>Qty</th> <th>Price</th> <th>Taxed?</th> <th>Notes</th> <th>Non menu notes</th>";
				append+= "</tr>";
				
				for(item in json[prop]["items"])
				{
					id_item = json[prop]["items"][item].id_proposal_item;
					
					append+= "<tr>";
					append+= "	<td>" + json[prop]["items"][item].name + "</td>";
					append+= "	<td> <input type='number' class='prop_item_quantity' id='prop_item_quantity_" + id_item + "' value='" + json[prop]["items"][item].quantity + "' /></td>";
					append+= "	<td> <input type='text' class='prop_item_price' id='prop_item_price_" + id_item + "' value='"+json[prop]["items"][item].fprice + "' /></td>";
					append+= "	<td> <span class='prop_item_taxed' id='prop_item_taxed_" + id_item +"'>" + json[prop]["items"][item].ftax + "</span> </td>";
					append+= '	<td> <textarea class="prop_item_notes" id="prop_item_notes_' + id_item + '">'+json[prop]["items"][item].notes + '</textarea></td>';
					append+= "	<td> <textarea class='prop_item_non_menu_notes' id='prop_item_non_menu_notes_" + id_item + "'>"+json[prop]["items"][item].non_menu_notes + "</textarea></td>";
					append+= "</tr>";
				}
				
				append+= "<tr><td> <input type='button' value='+' onclick='c2me_mgmt.addItemField(" + id_prop + ")' /> </td></tr>";
				append+= "</table>";
				append+= "</fieldset>";
				
				
				
				
				
				append+= "<fieldset class='fldt_servings_instructions'><legend>Serving Instructions</legend>";
				append+= "<div class='div_submit'><input type='button' value='+' onclick='c2me_mgmt.addSIfield(" + id_prop + ")' /></div>";
				
				for(si in json[prop]["serving_instructions"])
				{
					//json[prop]["items"][item].serving_instruction_id
					append+='<input type="text" class="prop_serving_instruction" value="'+json[prop]["serving_instructions"][si].label+'" />';
				}
				
				append+= "</fieldset>";
				
				
				
				append+= "</div>";
				
				
				
				$("#div_order_proposals").append(append);
				
				proposals.push(id_prop);
			}
			
			
			//generate accordions
			$("#div_order_proposals").accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
			
			
			
			for(p in proposals)
			{
				//generate prop details
				c2me_mgmt.genProposalDetails(proposals[p]);
			}
			
			
			//generate autocomplete for serving instruction fields
			$(".prop_serving_instruction").each(function(index) {
			  	$(this).autocomplete({
			  	serviceUrl:"/Ajax-mgmt.php",
			  	width:600,
			  	variableName:"autocomplete_serving_instruction",
			  	onSelect: function(value, data){ ; }
				});
			});
			
			
			//generate resize on click for item notes
			$(".prop_item_notes, .prop_item_non_menu_notes").focus(function() {
			  		$(this).css("height","120px");
				});
			$(".prop_item_notes, .prop_item_non_menu_notes").blur(function() {
			  		$(this).css("height","20px");
				});
			
		});
		
	},
	
	
	genProposalDetails:function(proposal_id) {
		
		//calculate total
		var sum_items_taxed=0;
		var sum_items_not_taxed=0;
		
		//loop each item price
		$('#prop_'+proposal_id+' .prop_item_price').each(function(index) {
		    
		    //get current ID of item (ex: prop_item_price_1234 => 1234)
    		    var array = $(this).attr("id").match(/\d+/g);
    		    id = array[0];
    		    
    		    //item taxed?
    		    if($("#prop_item_taxed_"+id).html() == "1")
    		    	  sum_items_taxed+= parseFloat($(this).val()) * $("#prop_item_quantity_"+id).val();
    		    else
    		    	  sum_items_not_taxed+= parseFloat($(this).val()) * $("#prop_item_quantity_"+id).val();
		    	
		    	
		    });
		    		    
		    
		var total = Math.round(((1+tax_rate) * sum_items_taxed + sum_items_not_taxed)*100)/100;  // *100/100 => 2 decimals
		var total_without_tax = Math.round((sum_items_taxed + sum_items_not_taxed)*100)/100;
		
		$("#prop_total_"+proposal_id).html( "$ " + total);
		$("#prop_total_without_tax_"+proposal_id).html( "$ " + total_without_tax );
		
		var fee = parseFloat($("#prop_service_fee_"+proposal_id).val());
		
		$("#prop_total_with_fee_"+proposal_id).html("$ " +(total+fee));
	},
	
	addSIfield:function(id_prop) {
	
		var append='<input type="text" class="prop_serving_instruction" value="" />';
		
		$("#prop_"+id_prop+" .fldt_servings_instructions").append(append);
		
	  	$(".prop_serving_instruction input:last").autocomplete({
	  	serviceUrl:"/Ajax-mgmt.php",
	  	width:600,
	  	variableName:"autocomplete_serving_instruction",
	  	onSelect: function(value, data){ ; }
		});
	},
	
	addItemField:function(id_prop) {
	
		append = "<tr>";
		append+= "	<td> " + json[prop]["items"][item].name + "</td>";
		append+= "	<td> <input type='number' class='prop_item_quantity' id='prop_item_quantity_" + id_item + "' value='" + json[prop]["items"][item].quantity + "' /></td>";
		append+= "	<td> <input type='text' class='prop_item_price' id='prop_item_price_" + id_item + "' value='"+json[prop]["items"][item].fprice + "' /></td>";
		append+= "	<td> <span class='prop_item_taxed' id='prop_item_taxed_" + id_item +"'>" + json[prop]["items"][item].ftax + "</span> </td>";
		append+= '	<td> <textarea class="prop_item_notes" id="prop_item_notes_' + id_item + '">'+json[prop]["items"][item].notes + '</textarea></td>';
		append+= "	<td> <textarea class='prop_item_non_menu_notes' id='prop_item_non_menu_notes_" + id_item + "'>"+json[prop]["items"][item].non_menu_notes + "</textarea></td>";
		append+= "</tr>";
	
		$('.fldt_items table tr:last').after(append);
	
	}


}


