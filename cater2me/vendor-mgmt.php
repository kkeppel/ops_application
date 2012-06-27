<?

require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser) != 'staff') notif('Sorry, you are not supposed to be here.');




$template = array(
	'menu_selected' => 'home',
	'header_resources' => '
	
		<script src="/template/js/custom/mgmt.js"></script>
		
		<script src="/template/js/custom/jquery.autocomplete.js"></script>
		<script type="text/javascript">
		var options, a;
		jQuery(function(){
		  options = {
		  	serviceUrl:"/Ajax-mgmt.php",
		  	variableName:"autocomplete_vendor",
		  	onSelect: function(value, data){ c2me_mgmt.loadVendor(data); }
		  	};
		  a = $("#vendor").autocomplete(options);
		});
		</script>
	
	',
	);


require 'header.php';

?>
<div class="c2me_mgmt">

<div class="grid_4 prefix_4 suffix_4 div_company_pick">

<fieldset>
	<legend>Vendors</legend>
	
	<!--
	<select>
		<option>Pan de Mie</option>
		<option>Fleur de Sel</option>
		<option>...</option>
	</select>
	-->
	<input type="text" id="vendor" />
	
</fieldset>

</div>

<div class="grid_10 prefix_1 suffix_1">
	<table>
		<tr><td> Vendor name: </td><td> <input type="text" id="vendor_name" /> </td><td> Website: </td><td> <input type="text" id="website" /> </td></tr>
		<tr><td> Public name: </td><td> <input type="text" id="vendor_public_name" /> </td></tr>
	</table>
</div>

<div class="grid_12">

<fieldset>
	<legend>Location</legend>
	
	<table>
		<tr>
			<td>Address:</td>
			<td>
				<input type="text" value="" id="address" />
			</td>
			<td>City:</td>
			<td>
				<input type="text" value="" id="city" />
			</td>
			<td>State:</td>
			<td>
				<input type="text" value="" id="state" />
			</td>
		</tr>
		<tr>
			<td> </td>
			<td> </td>
			<td>Zip:</td>
			<td>
				<input type="text" value="" id="zip" />
			</td>
			<td>Country:</td>
			<td>
				<input type="text" value="" id="country" />
			</td>
		</tr>
	</table>
</fieldset>

</div>

<div class="grid_12">

<div class="grid_6 alpha">

	<fieldset>
		<legend>$</legend>
	
		<table>
			<tr>
				<td>Start:</td>
				<td>
					<input type="text" value="" size="4" id="delivery_start" />
				</td>
				<td>Max order size:</td>
				<td>
					<input type="text" value="" size="3" id="max_order_size" />
				</td>
			</tr>
			<tr>
				<td>End:</td>
				<td>
					<input type="text" value="" size="4" id="delivery_end" />
				</td>
				<td>Lead time needed:</td>
				<td>
					<input type="text" value="" size="2" id="lead_time_needed" /> days
				</td>
			</tr>
			<tr>
				<td>Areas:</td>
				<td colspan="3">
					<input type="text" value="" id="delivery_area" />
				</td>
			</tr>
			<tr>
				<td>Notes:</td>
				<td colspan="3">
					<input type="text" value="" id="delivery_notes" />
				</td>
			</tr>
		</table>
	</fieldset>

</div>

<div class="grid_6 omega">

	<fieldset>
		<legend>Credits</legend>
	
		TBD?

</div>

</div>


<div class="clear"></div>

</div>
<?
require 'footer.php';
