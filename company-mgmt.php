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
		jQuery(function(){
		  $("#company").autocomplete({
		  	serviceUrl:"/Ajax-mgmt.php",
		  	variableName:"autocomplete_company",
		  	onSelect: function(value, data){ c2me_mgmt.loadCompany(data); }
		  	});
		});
		</script>
		
	',
	);


require 'header.php';

?>
<div class="c2me_mgmt">

<div class="grid_4 prefix_4 suffix_4 div_company_pick">

<fieldset>
	<legend>Companies</legend>
	<!--
	<select>
		<option>TPG</option>
		<option>ngmoco</option>
		<option>...</option>
	</select>-->
	<input type="text" id="company" />
	
</fieldset>

</div>

<div class="grid_5 prefix_1">
Company name: <input type="text" id="company_name" />
</div>
<div class="grid_6">
Website: <input type="text" id="website" />
</div>

<div class="grid_12">

<fieldset>
	<legend>Location</legend>
	
	<table>
		<tr>
			<td>Address:</td>
			<td>
				<input type="text" id="address" value="123 Sutter St" />
			</td>
			<td>City:</td>
			<td>
				<input type="text" id="city" value="San Francisco" />
			</td>
			<td>State:</td>
			<td>
				<input type="text" id="state" value="CA" />
			</td>
		</tr>
		<tr>
			<td>Cross:</td>
			<td>
				<input type="text" id="cross_streets" value="Sutter + Battery" />
			</td>
			<td>Zip:</td>
			<td>
				<input type="text" id="zip" value="94109" />
			</td>
			<td>Country:</td>
			<td>
				<input type="text" id="country" value="USA" />
			</td>
		</tr>
	</table>
</fieldset>

</div>

<div class="grid_12 div_company_3">

<div class="grid_3 alpha">

	<fieldset>
		<legend>$</legend>
	
		<table>
			<tr>
				<td>Fee:</td>
				<td>
					<input type="text" value="0.00" id="fee" size="4" /> %
				</td>
			</tr>
			<tr>
				<td>Default tip:</td>
				<td>
					<input type="text" value="18.00" id="default_tip" size="4" /> % / $
				</td>
			</tr>
		</table>
	</fieldset>

</div>

<div class="grid_5">

	<fieldset>
		<legend>Invoice contact</legend>
	
		<table>
			<tr>
				<td>First/Last name:</td>
				<td>
					<input type="text" value="" id="invoice_first_name" size="10" />
					<input type="text" value="" id="invoice_last_name" size="10" />
				</td>
			</tr>
			<tr>
				<td>E-mail:</td>
				<td>
					<input type="text" id="invoice_email" value="" />
				</td>
			</tr>
		</table>
	</fieldset>

</div>

<div class="grid_4 omega">

	<fieldset>
		<legend>Notes</legend>
		<textarea></textarea>
	</fieldset>

</div>

</div>

<div class="clear"></div>

<div class="div_company_users" id="div_company_users">

	<table>
	<tr><th> Username </th><th> First name </th><th> Last name </th><th> Title </th><th> Email </th><th> Email 2 </th><th> Phone </th><th> Personal # </th><th> Extension </th><th> Fax </th><th> Notes </th>
	<tr><td> <input type="text" /> </td><td> <input type="text" /> </td><td> <input type="text" /> </td><td> <input type="text" /> </td><td> <input type="text" /> </td><td> <input type="text" /> </td><td> <input type="text" /> </td><td> <input type="text" /> </td><td> <input type="text" /> </td><td> <input type="text" /> </td><td> <input type="text" /> </td>
	</table>

</div>

</div>
<?
require 'footer.php';
