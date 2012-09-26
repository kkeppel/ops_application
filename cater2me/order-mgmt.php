<?

require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser) != 'staff') notif('Sorry, you are not supposed to be here.');


if(!isset($_GET['oid'])) {
	notif('Link invalid: arguments missing. Please check your link.');
}
$_GET['oid']=(int)$_GET['oid'];



$template = array(
	'menu_selected' => 'home',
	'header_resources' => '
		<script src="/template/js/custom/mgmt.js"></script>
		
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
	
		<script src="/template/js/custom/jquery.autocomplete.js"></script>
		<script>
		$(function() {
			$( ".accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
			
			//alert("ok");
			c2me_mgmt.loadOrder('.$_GET['oid'].');
		});
		
		tax_rate = '.$config['tax_rate'].';
		
		</script>
		</style>
	',
	);


require 'header.php';

?>
<div class="c2me_mgmt">

<div class="grid_8">

<fieldset>
	<legend>Order #<span id="span_oid"></span></legend>
	
	<table>
		<tr>
			<td>Status:</td>
			<td>
				<select id="order_status">
				<?
				$res = mysql_query('SELECT * FROM order_status ORDER BY label');
				while($log = mysql_fetch_assoc($res))
				{
					echo '<option value="'.$log['id_order_status'].'">'.$log['label'].'</option>';
				}
				?>
				</select>
			</td>
			<td>When:</td>
			<td>
				<input type="text" id="when_date" value="07/21/2011" size="9" />
				@
				<input type="text" id="when_time" value="6:30" size="5" />
			</td>
		</tr>
		<tr>
			<td>From:</td>
			<td>
				Company (First Last)
			</td>
			<td># ppl:</td>
			<td>
				<input type="text" id="employees" value="120" size="3" />
			</td>
		</tr>
		<tr>
			<td>Created:</td>
			<td>
				<span id="order_created"></span>
			</td>
			<td>Max per person:</td>
			<td>
				$ <input type="text" value="11" size="2" />
			</td>
		</tr>
		<tr>
			<td>Meal type:</td>
			<td>
				<select id="meal_type">
				<?
				$res = mysql_query('SELECT * FROM meal_types ORDER BY label');
				while($log = mysql_fetch_assoc($res))
				{
					echo '<option value="'.$log['id_meal_type'].'">'.$log['label'].'</option>';
				}
				?>
				</select>
			</td>
			<td>Max order price:</td>
			<td>
				$ <input type="text" id="max_price" value="1320" size="4" />
			</td>
		</tr>
		<tr>
			<td>Tip:</td>
			<td>
				$ <input type="text" id="tip" value="123" size="3" />
			</td>
			<td>Payment method:</td>
			<td>
				<select id="payment_method">
				<?
				$res = mysql_query('SELECT * FROM payment_methods ORDER BY label');
				while($log = mysql_fetch_assoc($res))
				{
					echo '<option value="'.$log['id_payment_method'].'">'.$log['label'].'</option>';
				}
				?>
				</select>
			</td>
		<tr>
			<td> Notes: </td>
		</tr>
		<tr>
			<td colspan="4"> <textarea id="notes"></textarea> </td>
		</tr>
	</table>
</fieldset>

</div>
<div class="grid_4">

<fieldset class="fdt_profile">
	<legend>Client profile</legend>
	
	<div>
	<select>
		<option>....</option>
		<option>....</option>
	</select>
	</div>
	
	<hr />
	
	<div>Employees: <input type="text" value="128" size="4" /></div>
	
	
	<fieldset>
		<legend>Specificities</legend>
		
		<table>
			<tr><td>Vegetarians: </td><td> <input type="text" value="128" size="3" /> </td></tr>
			<tr><td>Kosher: </td><td> <input type="text" value="18" size="3" /> </td></tr>
		</table>
		
		Notes:<br />
		<textarea></textarea>
		
	</fieldset>
	
</fieldset>

</div>

<div class="grid_10 prefix_1 suffix_1 div_icons">icons</div>

<div class="grid_12" id="div_order_proposals">
<!--
	<div class="accordion" style="width:800px">
		<h3><a href="#items"> <b>Fleur de Sel</b> <span style="color:green">[Confirmed]</span> <span>$123.45</span> </a></h3>
		<div>
			<fieldset>
				<legend>C2me details</legend>
				
				<div style="float:left">
				<table>
					<tr>
						<td> Total: </td>
						<td> <span>$1234.00</span> </td>
						<td> Without tax: </td>
						<td> <span>$1234.00</span> </td>
					</tr>
					<tr>
						<td> Service fee: </td>
						<td> <span>$1234.00</span> </td>
						<td> Total with fee: </td>
						<td> <span>$1234.00</span> </td>
					</tr>
				</table>
				</div>
				<div style="float:left">
				<input type="button" value="select" disabled="true" />
				</div>
			</fieldset>
		
			<fieldset>
				<legend>Serving instructions</legend>
				
				<input type="text" value="Setup in kitchen downstairs from main entrance. Ask for direction." style="width:95%" />
				<input type="text" value="SI2...." style="width:95%" />
				<input type="button" value="+">‌
			</fieldset>
			
			<fieldset>
				<legend>Delivery instructions</legend>
				
				<textarea></textarea>
			</fieldset>
			
			<fieldset>
				<legend>Items</legend>
				
				<table>
					<tr>
						<th>Name</th>
						<th>Qty</th>
						<th>Price</th>
					</tr>
					<tr>
						<td>
							<select>
								<option>Potato Gnocchi</option>
								<option>Organic Chicken Breast</option>
								<option>Goat Cheese Penne</option>
								<option>...</option>
							</select>
						</td>
						<td>
							<input type="number" size="2" value="2" />
						</td>
						<td>
							<input type="text" size="3" value="9.87" />
						</td>
					</tr>
					<tr>
						<td> <input type="button" value="+" /> </td>
					</tr>
				</table>
			</fieldset>
		
		</div>
	
		<h3><a href="#items">Vendor prop 2</a></h3>
		<div>
		Content
		</div>
	
		<h3><a href="#items">Vendor prop 3</a></h3>
		<div>
		Content
		</div>
	</div>

</div>
-->

<div class="clear"></div>

</div>
<?
require 'footer.php';
