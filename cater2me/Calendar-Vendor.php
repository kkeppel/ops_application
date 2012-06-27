<?


	$res = mysql_query('SELECT id_order, id_order_proposal, order_for, notes, last_updated, last_updates, order_status_id
				  FROM order_requests, order_proposals
				  WHERE vendor_id = '.$curUser['vendor_id'].'
				  AND id_order = order_id
				  AND selected
				  AND (
					order_status_id =4
					OR order_status_id =2
					)
				  AND order_for BETWEEN "'.date('Y-m-d').'" AND "'.date('Y-m-d', time()+60*60*24*14).'" ORDER BY order_for'); //next 14 days
		

/**** to fix */
$ordersConfirmed=array();
$res2 = mysql_query('SELECT order_id FROM tmp_vendor_confirmations ORDER BY order_id');
while($log = mysql_fetch_assoc($res2)) {
	$ordersConfirmed[]=$log['order_id'];
$ordersCancelled=array();
$res20 = mysql_query('SELECT order_id FROM tmp_vendor_confirmcancel ORDER BY order_id');
while($log2 = mysql_fetch_assoc($res20)) {
	$ordersCancelled[]=$log2['order_id'];
}
}
/**** to fix */



	if(!mysql_num_rows($res)) notif('No orders planned for the next few days.');
	
if($_SERVER['REQUEST_METHOD']=='POST')
{

if (isset($_POST['Send'])) 
{ 
	$email1= $_POST['email1'];
	$email2= $_POST['email2'];
	$name1= $_POST['name1'];
	$name2= $_POST['name2'];
	$type = $_POST['type'];
	$company = $_POST['company'];
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = date("Y-m-d H:i:s");
$sql = "INSERT INTO referral_email(id_ref, name_ref, email_ref, fr_name_ref, fr_email_ref, company_ref, type_ref, ip_address, page, date) VALUES ('','$name1','$email1','$name2','$email2','$company','$type','$ip', 'Calendar Vendor Referral', '$date')";mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	

	$send = 1;

sendMail($config['staff_notifications']['default'],'Referral E-mail from dashboard Vendor Page','E-mail: '.$_POST['email2']."\nName: ".$_POST['name2']."\nCompany: ".$_POST['company']."\nType Company: ".$_POST['type']."\nFrom: ".$curUser['username'].' ('.$curUser['first_name'].' '.$curUser['last_name'].")\nIP: ".$_SERVER['REMOTE_ADDR']);

	}
		
}


	
$template = array(
	'title' => 'Cater2.me | Calendar',
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>
		<script src="/template/js/custom/jquery.ui.tabs.js"></script>
		<script src="/template/js/custom/jquery.cookie.js"></script>

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
				<script type="text/javascript" src="https://www.google.com/jsapi"></script>

	
		<script>
		$(function() {
			$( ".accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
		
			for(day in daysToHide)
			{
				document.getElementById("t"+daysToHide[day]).style.display="none";
			}
		
		});
		daysToHide=Array();
		
		
	function validateEmail(elementValue)

	{
	var reg = new RegExp("^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$", "i");
	return(reg.test(elementValue));
	}

		
		function validaterefer() {

	if(document.getElementById("email2").value =="")
	{
	alert("Please enter an email address");
	return false;
	}
	if(!validateEmail(document.getElementById("email2").value))
	{
	alert("Please enter a valid email address");
	return false;
	}

	return true;	
	}
		
		</script>
		
		<style type="text/css">
			.confirmed {
				color:green;
			}
			.notConfirmed {
				color:tomato;
			}
			.labelday > div {
			margin:14px 20px;
			}
			.nothingToday {
			padding-left:30px;
			}
			hr {
			color:white;
			width:500px;
			margin:20px 80px;
			}
			form{
			display: inline;
			}		 
		
		table{
		border-width : 0px;
				}
		td {
		border-width : 0px;

		}
					
		</style>
	',
	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Calendar'=>'/home/dashboard/calendar/'),
	
	'grey_bar' => 'Your Vendor Dashboard',
	);


require 'header.php';
?>
<style type="text/css">

.ui-widget-header a { 

/* color: #9C1C22 !important/*{fcHeader}*/;  */
color: #9C1C22 !important/*{fcHeader}*/; 
/* couleur tab  */
/*  background: #9C1C22;  */
		 	}
#ref .td{
		valign : center;
		padding-left:30px;
		padding-top:2px;
}		 	
		 				
#post-content-wrap a {
/* text color */
/*    color: white; */
    color: #000000;
/* 	bords arrondis */

/* 	-moz-border-radius: 0px; */
/* 	-webkit-border-radius: 3px; */
    }

#post-content-wrap a:hover{
    color: #458ab3;
    }
#main-nav a {
   color:#000 !important;
}
div#frame {
margin-top: 15px;
margin-left: 10px;
} 
div#frame2 {
margin-top: 290px;
margin-left: 90px;
position: absolute;
} 
div#frame1 {
margin-top: 150px;
margin-left: 90px;
position: absolute;
line-height:30px;
} 

div#fb{
margin-top: 300px;
margin-left: 600px;
position: absolute;
}
  
.ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl { -moz-border-radius-topleft: 0px; -webkit-border-top-left-radius: 0px; -khtml-border-top-left-radius: 0px; border-top-left-radius: 0px; }
.ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr { -moz-border-radius-topright: 0px; -webkit-border-top-right-radius: 0px; -khtml-border-top-right-radius: 0px; border-top-right-radius: 0px; }
.ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl { -moz-border-radius-bottomleft: 0px; -webkit-border-bottom-left-radius: 0px; -khtml-border-bottom-left-radius: 0px; border-bottom-left-radius: 0px; }
.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br { -moz-border-radius-bottomright: 0px; -webkit-border-bottom-right-radius: 0px; -khtml-border-bottom-right-radius: 0px; border-bottom-right-radius: 0px; }
/* changer couleur texte contenu   .ui-tabs-panel{    } */
    
.ui-widget-header {
/* tab derriere */
		 	border: 0px solid;	
			background: white;
/* 	background: #9C1C22; */
		 		}


 		
.ui-widget-overlay { opacity: .90;filter:Alpha(Opacity=70); }
.ui-widget { font-family: Verdana,Arial,sans-serif; font-size: 1.1em; }
.ui-widget .ui-widget { font-size: 1em; }
.ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button { font-family: Verdana,Arial,sans-serif; font-size: 1em; }
.ui-widget-content { border: 1px solid #ffffff; background: #ffffff url(images/ui-bg_flat_75_ffffff_40x100.png) 50% 50% repeat-x; color: #000000; }
.ui-widget-content a { color: #000000; }
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { border: 1px solid #ffffff; background: #96bade url(images/ui-bg_flat_75_96bade_40x100.png) 50% 50% repeat-x; font-weight: normal; color: black; }
.ui-widget-header { border: 1px solid #ffffff; background: #ffffff url(images/ui-bg_flat_0_ffffff_40x100.png) 50% 50% repeat-x; color: #a12926; font-weight: bold;
border-bottom-color: black; }
.ui-widget-header a { color: #a12926; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { border: 1px solid #ffffff; background: #C0E6EF url(images/ui-bg_flat_75_a1effc_40x100.png) 50% 50% repeat-x; font-weight: normal; color: black; }
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active { border: 0px solid #bfbfbf; background: #bfbfbf url(images/ui-bg_flat_65_bfbfbf_40x100.png) 50% 50% repeat-x; font-weight: normal; color: #bfbfbf; }

/* Custom tabs vendors */
.custom .ui-widget-header { border: 0px solid white; background: white url(images/ui-bg_flat_0_ffffff_40x100.png) 50% 50% repeat-x; color: #a12926; font-weight: bold; }
.custom .ui-widget-header a{ border: 1px solid white; background: white url(images/ui-bg_flat_0_ffffff_40x100.png) 50% 50% repeat-x; color: #a12926;  
/* border-top: 1px solid black; border-bottom: 1px solid black; */
}
/* Color border tab title */
.custom .ui-state-default, .custom .ui-widget-content .ui-state-default, .custom .ui-widget-header .ui-state-default{ border: 1px solid white; }
.custom .ui-state-active, .custom .ui-widget-content .ui-state-active, .custom .ui-widget-header .ui-state-active { border-top: 1px solid #bfbfbf;border-bottom: 1px solid #bfbfbf;}



.candybox {
background: #FEFEFF url(/static/images/shadow_gradient.gif) bottom repeat-x;
border: 2px solid #807e7f;
padding: 10px 20px 20px 20px;
margin: 0 0 2em 0;
margin-left: 14px;
margin-top: 20px;
}

.candybox {
border-radius: 5px;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
box-shadow: 0 1px 1px #dfdfdf;
-webkit-box-shadow: 0 1px 1px #dfdfdf;
-moz-box-shadow: 0 1px 1px #dfdfdf;
}

/* CSS feedback tab */
div#leftFbk {
	float:left;
	width:180px;
	height:400px;
	padding-right: 15px;
	}
	
#feedb1 {
	width: 700px;
}
#feedb1 td.title {
   background:#BFBFBF !important;
   color: white;
  font-size:15px;
  
}

#feedb2 td.title {
   background:#C0E6EF !important;
   color: black;
   font-size:13px;
}
#feedb2 tr.title {
  border-top : 0;
  border-bottom : 0;
  }
#feedb2 tr {
   font-size:13px;
   border-bottom : 2px dashed;
}

div#leftInfo {
	float:left;
	width:270px;
	height:600px;
	padding-right: 40px;
	}
div#middleInfo {
	float:left;
	width:270px;
	height:600px;
	padding-right: 40px;
	}
div#rightInfo {
	float:left;
	width:270px;
	height:900px;
	padding-right: 25px;
	}	
	

.hr-pattern {
height:2px;
padding-bottom: 5px;
margin-bottom: 5px;
}

</style> 

<script>
	/*
$(function() {
		$( "#tabs" ).tabs();
	});
*/
var date = new Date();
 date.setTime(date.getTime() + (10 * 60 * 1000));
   $(document).ready(function() {
 $( "#tabs" ).tabs({
			cookie: {
				// store cookie for a day, without, it would be a session cookie
				expires: date
			}
		});
  
    $("#tabs_vnd").tabs();
     /*
  $("#tabs").tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
       $("#tabs li").removeClass('ui-corner-top').addClass('ui-corner-left');
*/
  });

	
	</script>


<div class="demo">

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Your schedule</a></li>
		<li><a href="#tabs-2">Your feedback</a></li>
		<li><a href="#tabs-3">Refer a friend</a></li>
	</ul>
	<div id="tabs-1">
		<?
		
$areas=array();
$tmp = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "calendar_vendor_%"');
while($log = mysql_fetch_assoc($tmp)) {
	$areas[$log['label']]=$log['value'];
}
function formatdate($datetime)
{
   $day = date("d", strtotime($datetime));
  $month =  date("n", strtotime($datetime));
	return $month.'/'.$day;;
}
	
?>

<h2>Below you'll find your schedule for the NEXT 14 DAYS.</h2>
<br />
<p><?=plain2Html($areas['calendar_vendor_top'])?></p>
<?
	
		$orders=array();
		while($log = mysql_fetch_assoc($res))
		{
			$orders[] = $log;
		}
		
		
		$now=time();
		for($days=0;$days<15;$days++)
		{
			$curDay=$now+$days*86400;
			
			if(date('l', $curDay) == 'Monday') echo '<hr />';
			echo '<div class="labelday" id="t'. $curDay.'"><div>'.date('l M j Y', $curDay).'</div>';
			
			//if(isset($orders[0]))
			//{
			
			echo '<div class="accordion" style="width:700px">';
			
			$nothing=true;
			while(isset($orders[0]) && substr($orders[0]['order_for'],0,10) == date('Y-m-d',$curDay))
			{
			$nothing=false;
			$order = array_shift($orders);
			
			
			// ADDRESS
			
			$res2 = mysql_query('SELECT address, city, state, zip, delivery_address
						 FROM companies, clients, order_requests, client_profiles p
						 WHERE id_company = company_id
						 AND id_client = p.client_id
						 AND client_profile_id = id_profile
					  	 AND id_order = '.$order['id_order']);
					  	 
			$address = mysql_fetch_assoc($res2);
	
			if($address['delivery_address']) $address['address']=$address['delivery_address'];
			
			
			
			
			
			// DELIVERY INSTRUCTIONS	
				
			$res2 = mysql_query('SELECT c.delivery_instructions di, c_p.delivery_instructions p_di, c.delivery_area da, c_p.delivery_area p_da
						 FROM clients c, order_requests o_r, client_profiles c_p
						 WHERE id_client = c_p.client_id
						 AND id_profile = client_profile_id
					  	 AND id_order = '.$order['id_order']);
					  	 
			$instructions = mysql_fetch_assoc($res2);
	
			if($instructions['p_di']) $instructions['di']=$instructions['p_di'];
			if($instructions['p_da']) $instructions['da']=$instructions['p_da'];
			
			if($instructions['di'] || $instructions['da'])
			{
				$deliveryInfo='<div class="accordion" style="width:650px"><h3><a>-- Delivery instructions --</a></h3><ul>';
					$addressMap = $address['address'];
					$Map = explode("Suite", $addressMap);
					$deliveryInfo.='<li><a href="https://maps.google.com/maps?q='.$Map['0'].','.$address['city'].',+United+States" target=_blank>'.$address['address'].'<br>'.$address['city'].', '.$address['state'].' '.$address['zip'].' </a></li>';				if($instructions['di']) $deliveryInfo.='<li>'.$instructions['di'].'</li>';
				if($instructions['da']) $deliveryInfo.='<li>'.$instructions['da'].'</li>';
				$deliveryInfo.='</ul></div><br />';
			}
			else
				$deliveryInfo='';
			
			
			
/**** to fix */
$isConfirmed=(array_search($order['id_order'],$ordersConfirmed)!==false);
$isCanceled=(array_search($order['id_order'],$ordersCancelled)!==false);
/**** to fix */
if ($order['order_status_id'] == 2 )
{	if(!$isCanceled)
	$confirmed=' <span class="notConfirmed">[click below to acknowledge the cancellation]</span>';
	else
	$confirmed=' <span class="notConfirmed">[canceled]</span>';

}	
else if ($isCanceled)
{
	$confirmed=' <span class="notConfirmed">[canceled]</span>';
}
else if($isConfirmed)
	$confirmed=' <span class="confirmed">[confirmed]</span>';
else
	$confirmed=' <span class="notConfirmed">[not confirmed]</span>';
			
		$res200 = mysql_query ( 'SELECT showp
	FROM show_pdf
	 WHERE id_vendor_pdf = "'.$curUser['vendor_id'].'"
	 ');
	$vendor2  = mysql_fetch_assoc($res200);
	$vend_pdf = $vendor2['showp'];
	if ($vend_pdf == 1 ){
	$hash =((((( $order['id_order'] + 5)*152) -2)/2));
	echo '
			<h3><a href="#order'.$order['id_order'].'">'.date('g:i A', strtotime($order['order_for'])).' - '.$address['address'].' [Order #'.$order['id_order_proposal'].']'.$confirmed.'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<form target="_blank"><input type="button" value="Print Order" OnClick="window.open(\'/order-pdf.php?a='.$hash.'\')"></form>
			<form target="_blank"><input type="button" value="Print Labels" OnClick="window.open(\'/label-pdf.php?a='.$hash.'\')"></form>			<form target="_blank"><input type="button" value="Print Menu Day" OnClick="window.open(\'/menu-pdf.php?a='.$hash.'\')"></form>			</h3>
			<div>';
	}
	else {
	echo '
			<h3><a href="#order'.$order['id_order'].'">'.date('g:i A', strtotime($order['order_for'])).' - '.$address['address'].' [Order #'.$order['id_order_proposal'].']'.$confirmed.'</a></h3>
			<div>';
	}
	
			if ($order['order_status_id'] == 2 )
				{
				if(!$isCanceled)
				echo '<div class="divLnkConfirm" id="divLnkConfirm'.$order['id_order'].'"><a href="javascript:void(0)" onclick="vendorConfirmCancel('.$order['id_order'].',\''.round(((($order['id_order'] + 5)*152) -2)/2).'\')">Click here to confirm this cancellation now</a></div>';
				}
				else
			if(!$isConfirmed)  //  md5($config['secret'].$order['id_order'])
				echo '<div class="divLnkConfirm" id="divLnkConfirm'.$order['id_order'].'"><a href="javascript:void(0)" onclick="vendorConfirmEvent('.$order['id_order'].',\''.round(((($order['id_order'] + 5)*152) -2)/2).'\')">Click here to confirm this event now</a></div>';
			
			if ($isCanceled)
	{}
	else if ($order['order_status_id'] == 2 ) {}
	else {
			 
			if($order['notes'])
				echo '<p><b>Notes:</b> '.$order['notes'].'</p>';
			
			if($order['last_updated'] != '0000-00-00 00:00:00')
			{
				echo '<p><b><u>Updated</u>:</b> '.date('l M j Y @ g:i A', strtotime($order['last_updated'])).'</p>
					  <p><b><u>Updates</u>:</b> '.$order['last_updates'].'</p><br />';
			}
			
			echo $deliveryInfo;

$neworder = $order['id_order'];			
$neworder = ((($neworder * 45)+165)/2) ;
$textCode = floor( $neworder);
if(strlen($textCode)>4)
{ 
$textCode = substr($textCode, -4);   }
else  {
	if(strlen($textCode)==3)
	{ 
	$textCode = '1'.$textCode;}  
	}


			echo 'Text <b><span style="font-size:15px" >'.$textCode.'</span></b> to (415)-944-4121 upon arrival<br><br>';
		
			$res3 = mysql_query('SELECT label
			FROM catering_extra, catering_extra_labels
			WHERE catering_extra.extra_label_id = catering_extra_labels.id_extra
			AND order_request_id = '.$order['id_order']);
		
		
			echo '<b>Bring the following:</b><ul class="si">';	
			echo '<li>Cater2.me Labels</li>';
			echo '<li>Serving Utensils</li>';
			if(mysql_num_rows($res3))
			{
			while($sj = mysql_fetch_assoc($res3))
				{
					if ($sj['label'] == 'Utensils' or $sj['label'] == 'Paper Ware' or $sj['label'] == 'Table Clothes' or $sj['label'] == 'Chafing Dishes'){
					echo '<li>'.$sj['label'].'</li>';}
				}
			}

			$res2 = mysql_query('SELECT label
			FROM serving_instructions, order_proposals_si
			WHERE id_serving_instruction = serving_instruction_id
			AND order_proposal_id = '.$order['id_order_proposal']);
		
			if(mysql_num_rows($res2))
			{
				echo '<b>Order instructions:</b><ul class="si">';

				while($si = mysql_fetch_assoc($res2))
				{
					echo '<li>'.$si['label'].'</li>';
				}
				
				echo '</ul><hr />';
			}
			else 
			{
			echo '</ul><hr />';
			}
			
		
			$res2 = mysql_query('SELECT name, quantity, description, label food_category, o_p_i.notes, o_p_i.non_menu_notes
						   FROM order_proposal_items o_p_i, vendor_items, food_categories f_c
						   WHERE id_food_category = food_category_id
						   AND id_vendor_item = vendor_item_id
						   AND order_proposal_id = '.$order['id_order_proposal'].' ORDER BY f_c.list_order, quantity DESC') or die(mysql_error());
		
			echo '<ul>';
			while($items = mysql_fetch_assoc($res2))
			{
				$notes = '';
				if($items['notes']!='') $notes.=$items['notes'].'<br />';
				if($items['non_menu_notes']!='') $notes.=$items['non_menu_notes'].'<br />';
				echo '<li>('.$items['quantity'].') '.$items['name'].'<br /><small><b>'.$notes.'</b><i>'.$items['description'].' ('.$items['food_category'].')</i></small></li>';
			}
			echo '</ul>';
			}
			echo '</div>		&nbsp;&nbsp;&nbsp;';
			}
			
			
			echo '</div>';
			
			
			if($nothing)
			{
				switch(date('l',$curDay))
				{
				case 'Saturday':
				case 'Sunday':
					echo '<script> daysToHide.push('.$curDay.'); </script>';
				break;
				default:
					echo '<div class="nothingToday">-</div>';
				break;
				}
			}
			
			//}
			
			echo '</div>';
		}


		?>
	</div>
	<div id="tabs-2">
	
	<?
	
	$date1 = date( "Y-m-d", time() - 14 * 24 * 60 * 60 );
	$date2 = date("Y-m-d H:i:s");
	$date3 = date( "Y-m-d", time() - 30 * 24 * 60 * 60 );
	$datemonth = date( "Y-m-d", time() - 60 * 24 * 60 * 60 );
	$vnd = $curUser['vendor_id'];
	
	$resrevieuwnb = mysql_query("SELECT COUNT( feedback_id ) AS count
		FROM order_feedback, order_proposals, order_requests, users
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.order_status_id =4
		AND food_rating >0
		AND order_proposals.vendor_id = '$vnd'
		AND user_id = id_user
		AND users.client_id <>  ''
		AND order_for
		BETWEEN  '$date1'
		AND  '$date2'");
		$reviewtmp = mysql_fetch_assoc($resrevieuwnb);
		$review =number_format($reviewtmp['count']);
	
	$resavgfood = mysql_query("SELECT AVG( food_rating ) AS avg_food
	FROM order_feedback, order_proposals, order_requests, users
	WHERE order_feedback.order_id = order_proposals.order_id
	AND order_proposals.selected =1
	AND order_feedback.order_id = order_requests.id_order
	AND order_requests.order_status_id =4
	AND food_rating >0
	AND order_proposals.vendor_id = '$vnd'
	AND user_id = id_user
	AND users.client_id <>  ''
	AND order_for
	BETWEEN  '$date1'
	AND  '$date2'
		");
		$avgfood = mysql_fetch_assoc($resavgfood);
		$foodtot =number_format($avgfood['avg_food'],1);
		
		$resavgserv = mysql_query("SELECT AVG( service_rating ) AS avg_serv
	FROM order_feedback, order_proposals, order_requests, users
	WHERE order_feedback.order_id = order_proposals.order_id
	AND order_proposals.selected =1
	AND order_feedback.order_id = order_requests.id_order
	AND order_requests.order_status_id =4
	AND service_rating >0
	AND order_proposals.vendor_id = '$vnd'
	AND user_id = id_user
	AND users.client_id <>  ''	
	AND order_for
	BETWEEN  '$date1'
	AND  '$date2'
		");
		$avgserv = mysql_fetch_assoc($resavgserv);
		$servicetot = number_format($avgserv['avg_serv'],1);

				
		$resavgport = mysql_query("SELECT AVG( portioning ) AS avg_port
	FROM order_feedback, order_proposals, order_requests, users
	WHERE order_feedback.order_id = order_proposals.order_id
	AND order_proposals.selected =1
	AND order_feedback.order_id = order_requests.id_order
	AND order_requests.order_status_id =4
	AND portioning >0
	AND order_proposals.vendor_id = '$vnd'
	AND user_id = id_user
	AND users.client_id <>  ''	
	AND order_for
	BETWEEN  '$date1'
	AND  '$date2'
		");
		$avgport = mysql_fetch_assoc($resavgport);
		$porttot =number_format($avgport['avg_port'],1);
		
		$resavgfoodtot = mysql_query("SELECT AVG( food_rating ) as avgtot
		FROM  `order_feedback`, users		WHERE food_rating >0 and 	 user_id = id_user
			AND users.client_id <>  ''	");
		$avgfoodtot = mysql_fetch_assoc($resavgfoodtot);
		$avgfood =number_format($avgfoodtot['avgtot'],1);
		$resavgservtot = mysql_query("SELECT AVG( service_rating ) as avgtot
		FROM  `order_feedback`, users		WHERE food_rating >0 and 	 user_id = id_user  and service_rating >0		");
		$avgservtot = mysql_fetch_assoc($resavgservtot);
		$avgserv =number_format($avgservtot['avgtot'],1);
		$resavgporttot = mysql_query("SELECT AVG( portioning ) as avgtot
		FROM  `order_feedback`, users		WHERE food_rating >0 and 	 user_id = id_user and portioning >0");
		$avgporttot = mysql_fetch_assoc($resavgporttot);
		$avgport =number_format($avgporttot['avgtot'],1);
		
		
		?>
		
		<?
	$resavg2 = mysql_query("SELECT order_id_t, datetime_t, order_for
FROM text_vendor, order_requests, order_proposals
WHERE order_id_t = id_order
AND order_requests.id_order = order_proposals.order_id
AND order_requests.order_status_id =4
AND order_proposals.selected =1
AND vendor_id ='$vnd'
order by order_for desc
limit 0,30
		");
		
		$late5 = 0; $late10= 0; $late15=0;
	while($avg = mysql_fetch_assoc($resavg2)) { 
		 $orderid = $avg['order_id_t'];
		 $restext = mysql_query("SELECT datetime_t
			FROM text_vendor
			WHERE order_id_t = '$orderid'
			");
		$texttmp = mysql_fetch_assoc($restext);
		$timeText20 = $texttmp['datetime_t'];
		list($year,$month,$day,$h,$m,$s)=sscanf($timeText20,"%d-%d-%d %d:%d:%d");
		$timeTextstamp = mktime($h,$m,$s,$month,$day,$year);

		$timeorder2 =$avg['order_for'];
		list($year,$month,$day,$h,$m,$s)=sscanf($timeorder2,"%d-%d-%d %d:%d:%d");
		$s-=600;
		$timestamp2=mktime($h,$m,$s,$month,$day,$year);
		$timeearly2=date('Y-m-d H:i:s',$timestamp2);
		list($year,$month,$day,$h,$m,$s)=sscanf($timeorder2,"%d-%d-%d %d:%d:%d");
		$s+=300;
		$timestamp3=mktime($h,$m,$s,$month,$day,$year);
		$timeelate2=date('Y-m-d H:i:s',$timestamp3);
		//$timeText20 = $avg['datetime_t'];	
		if ($timeText20 == '') {$timing = 'unknow';}
		else if ($timeText20  < $timeearly2) 
			{ 
			$early ++;
			}
		else if ($timeText20  < $timeelate2 and  $timeText20 > $timeearly2) 
			{
			$ontime ++;
			}
		else if ($timeText20  > $timeelate2) 
			{ 
			$timediff  =  $timeTextstamp - $timestamp3 ;
			$timediff = round($timediff/60);
			if ($timediff <=5)
			{$late5++ ;
			 }
			else if(5<$timediff and $timediff<=10)
			{$late10++ ; }
			else if(10<$timediff and $timediff<=15)
			{$late15++ ; }
			else 
			{$late++ ; }
			}
		}
		$total = $early + $ontime + $late5 +$late10 + $late15 + $late;
		$Perctime = round(($ontime * 100)/ $total);
		$Percearly = round(($early * 100)/ $total);
		$Perclate5 = round(($late5 * 100)/ $total);
		$Perclate10 = round(($late10 * 100)/ $total);
		$Perclate15 = round(($late15 * 100)/ $total);
		$Perclate = round(($late * 100)/ $total);
		$late2 = $late5 + $late10 + $late15 + $late;
		$Perclate2 = round(($late2 * 100)/ $total);
	?>
	
<table>
	<tr>
	<td width="12%" rowspan="2"><b>Average ratings</b> <br>(<?=$review?> reviews) (Last 2 weeks)</td>
	<td  height="40px"><b>FOOD:</b></td><td><b>SERVICE:</b></td><td><b>PORTIONING:</b></td><td><b>ON-TIME DELIVERY:</b></td></tr>
	<tr>
	<td valign="bottom"><span style="font-size:60px" >
	<? if ($foodtot=='0.0') {echo  '--'; } else { ?>
	<?=$foodtot?></span><span style="vertical-align:text-bottom;font-size:20px " >/5</span><br>
	<? if ($foodtot > $avgfood	)
	{  $diff = $foodtot- $avgfood; ?> 
	<span style="color:blue " >( <?=$diff?> above avg )</span>
	<? }
	else if ($foodtot < $avgfood	)
	{  $diff = $avgfood - $foodtot ; ?> 
	<span style="color:red " >( <?=$diff?> below avg )</span>
	<? }
	else{ ?> (equal to avg ) <? } ?>
	 <? } ?> 
	</td>
	<td valign="bottom"><span style="font-size:60px" >
	<? if ($servicetot=='0.0') {echo  '--'; } else { ?><?=$servicetot?></span><span style="vertical-align:text-bottom;font-size:20px " >/5</span><br>
	<? if ($servicetot > $avgserv	)
	{  $diff = $servicetot- $avgserv; ?> 
	<span style="color:blue " >( <?=$diff?> above avg )</span>
	<? }
	else if ($servicetot < $avgserv	)
	{  $diff = $avgserv - $servicetot ; ?> 
	<span style="color:red " >( <?=$diff?> below avg )</span>
	<? }
	else{ ?> (equal to avg ) <? } ?>
	 <? } ?>
	</td>
	<td valign="bottom"><span style="font-size:60px" >
	<? if ($porttot=='0.0') {echo  '--'; } else { ?><?=$porttot?></span><span style="vertical-align:text-bottom;font-size:20px " >/5</span><br>
	<? if ($porttot > $avgport	)
	{  $diff = $porttot- $avgport; ?> 
	<span style="color:blue " >( <?=$diff?> above avg )</span>
	<? }
	else if ($porttot < $avgport	)
	{  $diff = $avgport - $porttot ; ?> 
	<span style="color:red " >( <?=$diff?> below avg )</span>
	<? }
	else{ ?> (equal to avg ) <? } ?>
	 <? } ?> 
	</td>
	<td valign="bottom"><span style="font-size:60px" >
	<? if ($Perctime=='0.0') {echo  '--'; } else { ?><?=$Perctime?>%</span><span style="vertical-align:text-bottom;font-size:20px " ></span><br>
	(<?=$Percearly?>% early; <?=$Perclate2?>% late)
	 <? } ?>
	</td></tr>
	</table>
	
	<?
	$resfb = mysql_query("SELECT feedback_public, order_proposals.order_id, feedback_id,  order_for
	FROM order_feedback, order_proposals,  order_requests, users
	WHERE order_feedback.order_id = order_proposals.order_id
	AND order_proposals.vendor_id = '$vnd'
	AND feedback_public <>  ''
	AND id_order = order_proposals.order_id
			AND order_proposals.selected =1
		AND order_requests.order_status_id =4
		and user_id = id_user
		and users.client_id <> ''
		and order_for	BETWEEN  '$datemonth'
			AND  '$date2'
	ORDER BY order_for DESC 
	LIMIT 0 , 5");
	$nbfeed = mysql_num_rows($resfb); 
	?>
	
	<table id="feedb2" width = "100%">

	<tr class="title"><td class="title" width="80%">5 most recent comments</td><td class="title">Order Date</td></tr>
	<? while($fdb = mysql_fetch_assoc($resfb)) { 
		$feedback  = $fdb['feedback_public'];
		$orderfor =  $fdb['order_for'];
		$datefeedtmp = $orderfor;
		$datefeed = formatdate($datefeedtmp);
		$dayfeed  = date('D', strtotime($datefeedtmp));
		$date = $dayfeed.', '.$datefeed;


		?>
	<tr><td><?=$feedback?></td><td><?=$date?></td></tr>

	<? } ?>
	
	<? if ($nbfeed < 5 )
	{
			if ($nbfeed == 0 )
			{
				?> <tr><td>No comments since 2 months ago</td><td></td></tr> <?
			}
			else {
		?> 	<tr><td>No more comments since 2 months ago</td><td></td></tr>
		<?
	}}?>

	</table><br><br>
	
	<?	
	$name_chart3 = "text_chart";
	$restext2 = mysql_query("SELECT order_id_t, datetime_t, order_for, text_vendor.text
	FROM text_vendor, order_requests, order_proposals
	WHERE order_id_t = id_order
	AND order_requests.id_order = order_proposals.order_id
	AND order_requests.order_status_id =4
	AND order_proposals.selected =1
	and vendor_id = '$vnd'
	group by order_for
	order by order_for desc
	limit 0,30
			");


		?>

		<script type="text/javascript">
		      google.load("visualization", "1", {packages:["corechart"]});
		      google.setOnLoadCallback(<?php echo $name_chart3; ?>);
		      function <?php echo $name_chart3; ?>() {
		        var data = new google.visualization.DataTable();
		        // Nous n'avons que 2 légendes : le nom d'utilisateur (type string) et son nombre de posts (type number)
		        data.addColumn('string', 'Date');
		        data.addColumn('number', 'Punctuality');
		        data.addRows([
		        <?php

		        // Boucle de la requête SQL
		        while ($donnees3 = mysql_fetch_array($restext2))
		            {
						$orderid = $donnees3['order_id_t'];
						 $restext = mysql_query("SELECT datetime_t
							FROM text_vendor
							WHERE order_id_t = '$orderid'
							");
						$texttmp = mysql_fetch_assoc($restext);
						$timeText20 = $texttmp['datetime_t'];
						list($year,$month,$day,$h,$m,$s)=sscanf($timeText20,"%d-%d-%d %d:%d:%d");
						$timeTextstamp = mktime($h,$m,$s,$month,$day,$year);

						$timeorder2 =$donnees3['order_for'];
						list($year,$month,$day,$h,$m,$s)=sscanf($timeorder2,"%d-%d-%d %d:%d:%d");
						$s-=600;
						$timestamp2=mktime($h,$m,$s,$month,$day,$year);
						$timeearly2=date('Y-m-d H:i:s',$timestamp2);
						list($year,$month,$day,$h,$m,$s)=sscanf($timeorder2,"%d-%d-%d %d:%d:%d");
						$s+=300;
						$timestamp3=mktime($h,$m,$s,$month,$day,$year);
						$timeelate2=date('Y-m-d H:i:s',$timestamp3);
						//$timeText20 = $avg['datetime_t'];	
						if ($timeText20 == '') {$time = 'unknow';}
						else if ($timeText20  < $timeearly2) 
							{ 
							$timediff  =  $timestamp3 - $timeTextstamp ;
							$timediff = round($timediff/60);
							if ($timediff <=5)
								{$time = '-5' ;
								}
								else if(5<$timediff and $timediff<=10)
								{$time = '-10' ; }
								else if(10<$timediff and $timediff<=15)
								{$time = '-15' ; }
								else 
								{$time = '-15'; }
								}


						else if ($timeText20  < $timeelate2 and  $timeText20 > $timeearly2) 
							{
							$time = '0';
							}
						else if ($timeText20  > $timeelate2) 
							{ 
							$timediff  =  $timeTextstamp - $timestamp3 ;
							$timediff = round($timediff/60);
							if ($timediff <=5)
							{$time = '5' ;
							 }
							else if(5<$timediff and $timediff<=10)
							{$time = '10' ; }
							else if(10<$timediff and $timediff<=15)
							{$time = '15' ; }
							else 
							{$time = '15'; }
							}


							$datedel = $donnees3['order_for'];
							$datedeltmp2 = $datedel;
							$datedel2 = formatdate($datedeltmp2);
							$daydel  = date('D', strtotime($datedeltmp2));
							$datedel3 = $daydel.', '.$datedel2;
				            $country2 = addslashes($datedel3);
		            $count2 = $time;
		            $data3 .= "['".$country2."', ".$count2."],"; // J'ai choisi d'afficher la valeur directement dans la légende en écrivant '".$username." : ".$nb_posts."'
		            }
		        echo $data3;



		        ?>
		        ]);

		        // Modifiez les options à votre convenance
		        var options = {
		          width: 1140, height: 300,
		           vAxis: {minValue: '-15',maxValue: '15',title: "Early   ||    Late"},
		           colors: ['#96BADE'],
			hAxis: {direction:-1, slantedText:'1'},
		          title: '',
		           legend: {position: 'none'},
		           chartArea:{top:25, left:45},
					lineWidth :4//,
				// curveType: 'function'
		        };

		        // Affichage du camembert généré dans le div défini au début
		        var chart = new google.visualization.LineChart(document.getElementById('text_chart'));
		        chart.draw(data, options);
		      }
		    </script>
		   <b> Delivery punctuality for the last 30 orders</b><div class="hr-pattern"></div>
		    <center><div id="text_chart"></div></center>
	
	
	<!-- <b> Delivery punctuality % (last 2 weeks)</b><div class="hr-pattern"></div> -->
   
	<script type="text/javascript">
    
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', ''],
          ['Ontime', <?=$Perctime?>],
          ['Early',  <?=$Percearly?>],
     	  ['0 - 5 minutes late', <?=$Perclate5?>],
     	  ['6 - 10 minutes late', <?=$Perclate10?>],
          ['11 - 15 minutes late',  <?=$Perclate15?>],
          ['More than 15 minutes late',  <?=$Perclate?>]
        ]);

        var options = {
           legend: {position: 'none'},
           vAxis: {maxValue: '100'},
           width:1140, height:300,
			 hAxis: {direction:-1},
           chartArea:{top:25, left:45},
			colors: ['#96BADE'],
			lineWidth :4
          };	
        

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);

    }
    
    </script>
      <!-- <div id="chart_div"></div> -->
      

	<? $name_chart2 = "avg1";
		$resType = mysql_query("SELECT AVG( food_rating ) AS avg_food, order_for
		FROM order_feedback, order_proposals, order_requests, users
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_proposals.order_id
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.order_status_id =4
		AND food_rating >0
		AND order_proposals.vendor_id = '$vnd'
		AND user_id = id_user
		AND users.client_id <>  ''	
		GROUP BY order_for
		order by order_for desc
		limit 0,30
		");
		
		
	?>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(<?php echo $name_chart2; ?>);
      function <?php echo $name_chart2; ?>() {
        var data = new google.visualization.DataTable();
        // Nous n'avons que 2 légendes : le nom d'utilisateur (type string) et son nombre de posts (type number)
        data.addColumn('string', 'Cuisine Type');
        data.addColumn('number', 'Avg');
        data.addRows([
        <?php
 
        // Boucle de la requête SQL
        while ($donnees2 = mysql_fetch_array($resType))
            {
            $datedel = $donnees2['order_for'];
			$datedeltmp2 = $datedel;
			$datedel2 = formatdate($datedeltmp2);
			$daydel  = date('D', strtotime($datedeltmp2));
			$datedel3 = $daydel.', '.$datedel2;
            $country2 = addslashes($datedel3); // On oublie pas addslashes pour éviter qu'un guillemet provoque une erreur
            $count2 = number_format($donnees2['avg_food'],1);
            $data2 .= "['".$country2."', ".$count2."],"; // J'ai choisi d'afficher la valeur directement dans la légende en écrivant '".$username." : ".$nb_posts."'
            }
        echo $data2;
        
 
        
        ?>
        ]);
        
        // Modifiez les options à votre convenance
        var options = {
          width: 1140, height: 300,
           vAxis: {minValue: '0',maxValue: '5.1'},
           colors: ['#96BADE'],
          title: '',
		hAxis: {direction:-1, slantedText:'1'},
           legend: {position: 'none'},
           chartArea:{top:25, left:45},
			lineWidth :4
        };
 
        // Affichage du camembert généré dans le div défini au début
        var chart = new google.visualization.LineChart(document.getElementById('avg1'));
        chart.draw(data, options);
      }
    </script>
   <b> Average food rating for the last 30 orders</b><div class="hr-pattern"></div>
    <center><div id="avg1"></div></center>
    
<? $name_chart5 = "avg2";
		$resType5 = mysql_query("SELECT AVG( service_rating ) AS avg_serv, order_for
		FROM order_feedback, order_proposals, order_requests, users
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_proposals.order_id
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.order_status_id =4
		AND service_rating >0
		AND order_proposals.vendor_id = '$vnd'
		AND user_id = id_user
		AND users.client_id <>  ''	
		group by order_for
		order by order_for desc
	Limit 0,30
		");
		
		
	?>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(<?php echo $name_chart5; ?>);
      function <?php echo $name_chart5; ?>() {
        var data = new google.visualization.DataTable();
        // Nous n'avons que 2 légendes : le nom d'utilisateur (type string) et son nombre de posts (type number)
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Avg');
        data.addRows([
        <?php
 
        // Boucle de la requête SQL
        while ($donnees5 = mysql_fetch_array($resType5))
            {
            $datedel5 = $donnees5['order_for'];
			$datedeltmp5 = $datedel5;
			$datedel5 = formatdate($datedeltmp5);
			$daydel5  = date('D', strtotime($datedeltmp5));
			$datedel5 = $daydel5.', '.$datedel5;
            $country5 = addslashes($datedel5); // On oublie pas addslashes pour éviter qu'un guillemet provoque une erreur
            $count5 = number_format($donnees5['avg_serv'],1);
            $data5 .= "['".$country5."', ".$count5."],"; // J'ai choisi d'afficher la valeur directement dans la légende en écrivant '".$username." : ".$nb_posts."'
            }
        echo $data5;
        
 
        
        ?>
        ]);
        
        // Modifiez les options à votre convenance
        var options = {
          width: 1140, height: 300,
           vAxis: {minValue: '0',maxValue: '5'},
			hAxis: {direction:-1, slantedText:'1'},
           colors: ['#96BADE'],
          title: '',
           legend: {position: 'none'},
		lineWidth :4,
           chartArea:{top:25, left:45}
        };
 
        // Affichage du camembert généré dans le div défini au début
        var chart = new google.visualization.LineChart(document.getElementById('avg2'));
        chart.draw(data, options);
      }
    </script>
   <b> Average service rating for the last 30 orders</b><div class="hr-pattern"></div>
    <center><div id="avg2"></div></center>

	
	</div>
		<div id="tabs-3">
		
		<? $textreferral = "Know a friend or colleague that would benefit from our service?<br> Help spread the Cater2.me love. 
		  Invite them and you'll receive $100!*"; ?>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=172716656150201";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

	<div id="frame" style="background-image: url(/template/images/frame4.jpg); height: 240px; width: 900px; border: 0px ;">
		<div id="frame1" style="height: 100px; width: 900px;" >
		  <span style="font-size:16px;"> <?=$textreferral?></span>
		</div></div>
		
 		<div class="grid_7" id="contact-page"> 
		<div class="candybox" style="width: 830px;height:250px">
		<div id="frame3" style=" width: 850px; margin-left:50px" >
	  <form method="post"  onsubmit="return validaterefer();">
	  		<table class="tableref" align="left" width="800px" >
			<tr><td  width="300px"  style="border:0px; vertical-align:middle;"><span style="font-size:18px;"> Referral Type</span></td><td>		<select tabindex="1" name = "type">
		<option>Vendor</option>
		<option>Client</option>
		</select></td></tr>
		<tr>
			
		<td width="310px"  style="border:0px; vertical-align:middle;"><span style="font-size:18px;">   Name</span></label></td>
			<td  width="300px" style="border:0px; vertical-align:middle;"><input type="text" tabindex="2" name="name2"  placeholder="name" /></td>
			<td  width="200px" style="border:0px; vertical-align:middle;"><span style="font-size:18px;">Like us on Facebook !</td>
			</tr>
			</tr><td style="border:0px; vertical-align:middle;"><span style="font-size:18px;">Email</span></label></td>
			<td style="border:0px"><input type="email" tabindex="3" name="email2" id="email2" placeholder="company email" /></td>
			<td rowspan="2" ><div class="fb-like-box" data-href="https://www.facebook.com/C2meSF" data-width="292" data-show-faces="false" data-stream="false" data-header="true"></div></td>
			</tr>
			
			<tr><td  style="border:0px ;vertical-align:middle;"><span style="font-size:18px;"> Company </span></label></td>
			<td style="border:0px"><input type="text" tabindex="4" name="company"  placeholder="company name" /></td>
			</tr>
			<tr><td  style="border:0px ;vertical-align:middle;"><span style="font-size:18px;"> </span></label></td>
			<td style="border:0px"><input type="submit" tabindex="5" name = "Send"  value="Send" style="cursor:pointer;" /></td>
			</tr>
			 <tr><td><input type="hidden" name="name1"  value="<?=$curUser['first_name'];?>" /></td></tr>
	 		<tr><td><input type="hidden" name="email1"  value="<?=$curUser['email'];?>" /></td></tr>
		</table><br>		
			</form>
			</div></div><span style="font-size:9px;">&nbsp;&nbsp;&nbsp;&nbsp;	*Note: A minimum of 1 completed order for a client and 5 completed orders for a vendor is required </span>
			
		</div>
		
	</div>
	
</div>

</div><!-- End demo -->


