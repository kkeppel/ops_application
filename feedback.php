<?

require 'lib/core.php';


if(!isset($_GET['oid'])) {
	notif('Link invalid: arguments missing. Please check your link.');
}

$_GET['oid']=(int)$_GET['oid'];


if(!isset($_GET['hash'])) {
	if(!$curUser)
		redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
	else
	{
		//about to check that current user and order "owner" match the same company (=> calendar)
		///$order = mysql_fetch_row(mysql_query('SELECT company_id FROM order_requests, clients WHERE client_id = id_client AND id_order = '.$_GET['oid']));
		
		$cals=array();
		$res = mysql_query('SELECT gcal_id FROM order_requests, clients, calendars WHERE client_id = id_client AND clients.company_id = calendars.company_id AND id_order = '.$_GET['oid']);
		while($cal=mysql_fetch_row($res))
			$cals[]=$cal[0];
		
		switch(getUserGroup($curUser))
		{
		case 'client':
			$user = mysql_fetch_row(mysql_query('SELECT gcal_id FROM clients, calendars WHERE clients.company_id = calendars.company_id AND id_client = '.$curUser['client_id']));
			if(array_search($user[0],$cals)===false) notif('Sorry, you are not supposed to be here. Questions? <a href="mailto:'.$config['public_email'].'">Email us</a> and we\'ll be in touch asap.');
		break;
		case 'employee':
			$user = mysql_fetch_row(mysql_query('SELECT gcal_id FROM employees, calendars WHERE employees.company_id = calendars.company_id AND id_employee = '.$curUser['employee_id']));
			if(array_search($user[0],$cals)===false) notif('Sorry, you are not supposed to be here. Questions? <a href="mailto:'.$config['public_email'].'">Email us</a> and we\'ll be in touch asap.');
		break;
		default:
			notif('Sorry, you are not supposed to be here.');
		break;
		}
	}
}
//elseif(md5($config['secret'].$_GET['oid']) == $_GET['hash']) {
elseif(round(((($_GET['oid'] + 5)*152) -2)/2) == $_GET['hash']) { //main contact

	$log = mysql_fetch_row(mysql_query('SELECT u.username, u.password FROM order_requests o_r, users u WHERE u.client_id = o_r.client_id AND id_order = '.$_GET['oid'].' order by id_user desc ' ));

	authenticate($log[0],$log[1],false); // false= don't save cookie
	if(!$curUser) notif('Sorry, an error has occurred. You cannot view this page.'); // account probably deactivated
}
else {
	notif('Link invalid: hash is incorrect. Please check your link.');
}


//check if feedback already sent
//if(mysql_num_rows(mysql_query('SELECT 1 FROM order_feedback WHERE order_id = '.$_GET['oid'].' AND user_id = '.$curUser['id_user']))) notif('Sorry, you can only leave feedback once.');



$res = mysql_query('SELECT public_name, order_for, default_tip, id_order_proposal
			  FROM vendors, order_requests, order_proposals, clients, companies
			  WHERE order_id = id_order
			  AND id_vendor = vendor_id
			  AND selected
			  AND id_client = client_id
			  AND id_company = company_id
			  AND id_order = '.$_GET['oid']);
$order = mysql_fetch_assoc($res);

$timestamp=strtotime($order['order_for']);
if($timestamp > time()) notif('Sorry, you cannot provide feedback until after the delivery has occurred.');
//clients can submit feedback even long after meal
if(getUserGroup($curUser) == 'employee' && (($timestamp+$config['feedback_max_period']) < time())) notif('Sorry, but we close the feedback for each meal after 48 hours to allow us to get our vendors real-time feedback about your experience. Nonetheless, we always like hearing from you, so please <a href="mailto:'.$config['public_email'].'">send us an email</a>!');


	//get name vendor/client
	$log = mysql_fetch_row(mysql_query('SELECT v.name, co.name
						FROM vendors v, order_proposals o_p, order_requests o_r, clients cl, companies co
						WHERE vendor_id = id_vendor
						AND order_id = id_order
						AND selected
						AND client_id = id_client
						AND company_id = id_company
						AND id_order = '.$_GET['oid']));
						
	$names=array('vendor'=>$log[0], 'client'=>$log[1]);
	


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(!isset($_POST['when_next'])) $_POST['when_next']=''; //employees don't get this
	
	switch($_POST['when_next']) {
		case 'never':
			$when_next=-1;
		break;
		case 'next week':
			$when_next=1;
		break;
		case '2 weeks':
			$when_next=2;
		break;
		case '3 weeks':
			$when_next=3;
		break;
		case '4 weeks':
			$when_next=4;
		break;
		default:
			$when_next=0;
		break;
	}	
	
	mysql_query('REPLACE INTO order_feedback
	(feedback_id, order_id, user_id, food_rating, portioning, service_rating, when_next, c2me_rating, tip_feedback, tip_type, feedback_private, feedback_public)
	VALUES
	("",'.$_GET['oid'].', '.$curUser['id_user'].', '.(int)$_POST['food_rating'].', '.(int)$_POST['portioning'].', '.(int)$_POST['service'].', "'.$when_next.'", '.(int)$_POST['c2me_rating'].', "'.mysql_real_escape_string($_POST['tip']).'","'.mysql_real_escape_string($_POST['type']).'", "'.mysql_real_escape_string(stripslashes($_POST['private_feedback'])).'","'.mysql_real_escape_string(stripslashes($_POST['public_feedback'])).'")');
	
	if(isset($_POST['tip'])) mysql_query('UPDATE order_requests SET tip = "'.mysql_real_escape_string($_POST['tip']).'" WHERE id_order = '.$_GET['oid']);
	
	
	$ratings_email = array();
	
	foreach($_POST['item_portioning'] as $idItem=>$rating)
	{
		$idItem=(int)$idItem;
		$rating=(int)$rating;
		
		if($rating>0 || isset($_POST['item_food_rating'][$idItem])) //either food or portioning need to be rated
		{
			//POST[food_rating] may not be defined [radio] but portioning is [dropdown]
			$food_rating = (isset($_POST['item_food_rating'][$idItem]) ? (int)$_POST['item_food_rating'][$idItem] : 0);
			mysql_query('REPLACE INTO order_feedback_items (feedback_items_id, item_id, user_id, food_rating, portioning) VALUES ("",'.$idItem.', '.$curUser['id_user'].', '.$food_rating.', '.$rating.')');
			
			$ratings_email[$idItem]=array($food_rating,$rating);
		}
	}
	


// process email notification 

$next='';
if(isset($_POST['when_next'])) $next='in '.$_POST['when_next'].' weeks';


$body='<h3>Companies</h3><br />
Client: '.$names['client'].' ('.$curUser['username'].': '.$curUser['first_name'].' '.$curUser['last_name'].', '.$curUser['email'].')<br />
Vendor: '.$names['vendor'].'<br />
<br /><br />


<h3>Global order</h3><br />
<table border="1">';
foreach($_POST as $field=>$value) {
	if(!is_array($value)) //we don't want individual item
	{
		$body.='<tr><th align="left">'.$field.'</th><td>'.$value.'<br></td></tr>';
	}
}
$body.='</table><br /><br />';


if(isset($_POST['item_portioning']))
{
	$body.='<h3>Individual items</h3><br />
	<table border="1">
	<tr><th>Item</th><th>&nbsp;&nbsp; Rating &nbsp;&nbsp;</th><th>&nbsp;&nbsp; Portioning &nbsp;&nbsp;</th></tr>';
	
	if(count($ratings_email))
	{
	$res = mysql_query('SELECT name, id_proposal_item FROM vendor_items, order_proposal_items WHERE id_vendor_item = vendor_item_id AND id_proposal_item IN ('.implode(',',array_keys($ratings_email)).')');
	while($log = mysql_fetch_assoc($res))
	{
		$body.='<tr><th align="left">'.$log['name'].'</th><th>'.$ratings_email[$log['id_proposal_item']][0].'</th><th>'.$ratings_email[$log['id_proposal_item']][1].'<br></th></tr>';
	}
	}
	
	$body.='</table><br />
	Food rating: (0) undefined<br />
	Portioning: (0) undefined | (1) not enough | (2) just right | (3) too much';
}

sendMail($config['staff_notifications']['default'], 'Feedback ('.date('m/d/Y', strtotime($order['order_for'])).') '.$_GET['oid'].'-'.$order['id_order_proposal'].' ['.getUserGroup($curUser).']',$body,true);
sendMail('feedback@cater2.me', 'Feedback ('.date('m/d/Y', strtotime($order['order_for'])).') '.$_GET['oid'].'-'.$order['id_order_proposal'].' ['.getUserGroup($curUser).']',$body,true);



	if(getUserGroup($curUser)=='client')
	{
		if($config['referral_forms'] && $_POST['c2me_rating'] > 3)
		{
			//$refMsg='Got friends? Refer them and we\'ll send you <b>$100</b> when they place their first order.';
		
			if($_POST['food_rating'] < 4 || $_POST['service'] < 4)
				$refMsg = 'If you have any friends or colleagues who would benefit from our service, please let us know and we\'ll send you <b>$100</b> when they place their first order!';
			else
			{
			
				$refMsg = 'If you have friends or colleagues you
				think might enjoy the food from this vendor and could benefit from our
				service, let us know and we\'ll send you <b>$100</b> once they place their
				first order!';
			}
		
			session_start();
			$_SESSION['order_referral']=$_GET['oid'];
			$_SESSION['user_referral']=$curUser['id_user'];
		
			include 'referral.php';
			die;
		}
		else
		{
			notif('Thank you for your feedback! Please <a href="mailto:'.$config['public_email'].'">contact us</a> for any questions or order requests.');
		}
	}
	else //employee
	{
		if(($_POST['food_rating'] > 3 || $_POST['service'] > 3) && $config['referral_forms'])
			$refMsg = 'If you have any friends or colleagues who would benefit from our service, please let us know and we\'ll send you <b>$100</b> when they place their first order!';
		else
			notif('Thank you for your feedback! Please <a href="mailto:'.$config['public_email'].'">contact us</a> for any questions or order requests.');
	
		session_start();
		$_SESSION['order_referral']=$_GET['oid'];
		$_SESSION['user_referral']=$curUser['id_user'];
	
		include 'referral.php';
		die;
	}
}




$template = array(
	'title' => 'Cater2.me | Feedback',
	'menu_selected' => 'home',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
	
		<script>
		$(function() {
			$( ".accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
		});
		</script>
		<style>
		.accordion {
		margin:15px 0;
		}
		fieldset {
		margin-top:15px;
		}
		label {
		color:#000;
		font-size:1.2em;
		}
		textarea {
		margin-top:15px;
		}
		</style>
	',
	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Feedback (#'.$_GET['oid'].')'=>$_SERVER['REQUEST_URI']),
	
	'grey_bar' => 'Vendor Feedback',
	);


require 'header.php';

?>
<? if(getUserGroup($curUser)=='client') { ?>
<h3>Please fill in the following form to submit feedback for your recent catering order. Thanks!</h3>
<? } else /*employee*/ { ?>
<h3>Please fill in the following form to tell us what you thought about this meal.
If you have any questions or comments, <a href="mailto:<?=$config['public_email']?>">email us</a> and we'll get back to you right away. Thanks!</h3>
<? } ?>



<table>
<tr><th>Catering Provider</th><th><b><?=$order['public_name']?></b></th></tr>
<tr><td>Order Date</td><td><?=date('l M j Y @ g:i A',strtotime($order['order_for']))?></td></tr>
<tr><td>Order ID</td><td><?=$_GET['oid']?></td></tr>
</table>

<form method="post">
            
            <fieldset>
            
	        <p>
            <label for="food_rating">Rate the food (1=poor; 5=excellent)</label><br />
            <input type="radio" value="1" name="food_rating"> 1
            <input type="radio" value="2" name="food_rating"> 2
            <input type="radio" value="3" name="food_rating"> 3
            <input type="radio" value="4" name="food_rating"> 4
            <input type="radio" value="5" name="food_rating"> 5
            </p>
            
	        <p>
            <label for="portioning">Rate the portioning (1=poor; 5=excellent)</label><br />
            <input type="radio" value="1" name="portioning"> 1
            <input type="radio" value="2" name="portioning"> 2
            <input type="radio" value="3" name="portioning"> 3
            <input type="radio" value="4" name="portioning"> 4
            <input type="radio" value="5" name="portioning"> 5
            </p>
            
            
	<div class="accordion" style="width:800px">
		<h3><a href="#items">Click here to rate individual menu items.</a></h3>
		<div>
			
			<table class="tblItems">
			<tr><th><u>Items</u></th><th>Food rating</th><th>Portioning</th></tr>
			<?
			
			$res = mysql_query('SELECT id_proposal_item, menu_name, quantity, description, label, o_p_i.notes, o_p_i.non_menu_notes
						   FROM order_proposals, order_proposal_items o_p_i, vendor_items, food_categories
						   WHERE id_order_proposal = order_proposal_id
						   AND id_vendor_item = vendor_item_id
						   AND food_category_id = id_food_category
						   AND selected
						   
						   AND quantity > 0
						   AND list_order < 18
						   
						   AND order_id = '.$_GET['oid'].' ORDER BY list_order, quantity DESC');
			
			
			while($log = mysql_fetch_assoc($res))
			{
			?>
			<tr><th style="text-align:left"><?=$log['menu_name']?><small><br /><?=$log['notes']?></small></th>
			<td style="white-space:nowrap;padding:5px 15px;">
			<p>
				<input type="radio" name="item_food_rating[<?=$log['id_proposal_item']?>]" value="1" /> 1 
				<input type="radio" name="item_food_rating[<?=$log['id_proposal_item']?>]" value="2" /> 2 
				<input type="radio" name="item_food_rating[<?=$log['id_proposal_item']?>]" value="3" /> 3 
				<input type="radio" name="item_food_rating[<?=$log['id_proposal_item']?>]" value="4" /> 4 
				<input type="radio" name="item_food_rating[<?=$log['id_proposal_item']?>]" value="5" /> 5
			</p>
			</td><td>
			<p>
				<select name="item_portioning[<?=$log['id_proposal_item']?>]">
					<option value="0">-----</option>
					<option value="1">Not enough</option>
					<option value="2">Just right</option>
					<option value="3">Too much</option>
				</select>
			</p>
			</td>
			</tr>
			<?
			}
			?>
			</table>
		</div>
	</div>
	
	
	        <p>
            <label for="service">Rate the service (1=poor; 5=excellent)</label><br />
            <input type="radio" value="1" name="service"> 1
            <input type="radio" value="2" name="service"> 2
            <input type="radio" value="3" name="service"> 3
            <input type="radio" value="4" name="service"> 4
            <input type="radio" value="5" name="service"> 5
            </p>
            
            <? switch(getUserGroup($curUser)) {
            case 'client': ?>
            <p>
            <label for="when_next">When would you like this vendor next?</label><br />
            <input type="radio" value="never" name="when_next"> Never
            <input type="radio" value="next week" name="when_next"> Next week
            <input type="radio" value="2 weeks" name="when_next"> Two weeks
            <input type="radio" value="3 weeks" name="when_next"> Three weeks
            <input type="radio" value="4 weeks" name="when_next"> Four weeks
            </p>
            <?
            break;
            case 'employee':
            ?>
            <p>
            <label for="vendor_again">Would you like to have this vendor again?</label><br />
            <input type="radio" value="yes" name="vendor_again"> Yes
            <input type="radio" value="no" name="vendor_again"> No
            </p>
            <? break;
            } ?>
            
            <? if(getUserGroup($curUser)=='client') { ?>
            <p>
            <label for="feedback_public">If you would like to leave a tip for this vendor, enter here:</label>
            
            <? if($order['default_tip'] && $order['default_tip'] < 1)
            	{
            	$type = "%";
            	}
            else 
            	{
            	$type = "$";
            	}
            ?>
            <input type="hidden" name="tip_type"  value="<?=$type?>" />
            <input type="text" style="width:60px;" placeholder="0.00" value="<?=$order['default_tip']?>" name="tip" />
             <select name="type">
            <option value="%" 
<?php if($type == "%"){ echo 'selected = "selected"';} ?>>
<?php if($type == "%"){ echo '%';}  else { echo '%';} ?> </option>
 
<option value="$"
<?php if($type == "$"){ echo 'selected = "selected"';} ?>>
<?php if($type =="$"){ echo '$';} else { echo '$';} ?> </option>          
            </select>
        

            </p>
            <? } ?>
            
            <p>
            <label for="feedback_public">Feedback to share publicly (with others or the vendor):</label><br />
            <textarea style="width:350px;" rows="6" cols="60" name="public_feedback"></textarea>
            </p>
            
            <p>
            <label for="private_feedback">Feedback for Cater2.me (portion sizing, presentation, dining experience, etc.):</label><br />
            <textarea style="width:350px;" rows="6" cols="60" name="private_feedback"></textarea>
            </p>

		<? if(getUserGroup($curUser)=='client') { ?>
		<p>
            <label for="c2me_rating">Rate your experience using Cater2.me (1=poor; 5=excellent)</label>
            <input type="radio" value="1" name="c2me_rating"> 1
            <input type="radio" value="2" name="c2me_rating"> 2
            <input type="radio" value="3" name="c2me_rating"> 3
            <input type="radio" value="4" name="c2me_rating"> 4
            <input type="radio" value="5" name="c2me_rating"> 5
            </p>
            <? } ?>
            
            
			<div style="margin:20px 0;" class="grid-hr"></div>
			
			
			<div class="grid_4 omega alpha">
            		<input type="submit" value="Submit" id="submit" class="submit">
			</div>
            
            </fieldset>
        
            </form>

<?
require 'footer.php';
