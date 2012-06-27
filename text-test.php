<?
require_once 'lib/core.php';
?>
<?
echo date("Y-m-d H:i:s");


$datetimeday = date("Y-m-d H:i:s");
list($year,$month,$day,$h,$m,$s)=sscanf($datetimeday,"%d-%d-%d %d:%d:%d");
$s+=300;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeearly=date('Y-m-d H:i:s',$timestamp);
$datetimeday = $timeearly;
echo  $datetimeday;
?>

<input type='checkbox' id='cocheTout'/>
<span id='cocheText'>Cocher tout</span>

<ul id='cases'>
    <li><input type='checkbox' id='1'/>Case 1</li>
    <li><input type='checkbox' id='2'/>Case 2</li>
    <li><input type='checkbox' id='3'/>Case 3</li>
</ul>

<script src="http://maps.google.com/maps/api/js?sensor=false"
          type="text/javascript"></script>

<div id="map" style="width: 600px; height: 550px;"></div>
 
  <script type="text/javascript">

    var locations = [
      ['Jérôme et Catherine Blondel', 49.898729,3.13606, 5],
      ['Laurent et Sabine Blondel', 50.684142,3.1360678, 4],
      ['Noël et Anne Marie Blondel', 49.953802, 2.360237, 3],
      ['Jean Luc et Catherine Blondel', 48.606369,2.886894, 2],
      ['Patrice  et Marie Alix Blondel', 46.149513,6.410866, 1]
    ];
 
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 6,
      center: new google.maps.LatLng(47.4,1.6),
          mapTypeId: google.maps.MapTypeId.ROADMAP
         );
 
    var infowindow = new google.maps.InfoWindow();
 
    var marker, i;
 
   for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });
 
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }

  </script>
<?
echo ((((11647+ 5)*152) -2)/2);
echo  date("Y-m-d H:i:s");
echo '<br>';
		
/* $text = preg_replace("/(\r\n|\n|\r)/", " ", $text); */

function formatdate($datetime)
{
  $day = date("d", strtotime($datetime));
  $month =  date("n", strtotime($datetime));

	return $month.'/'.$day;;
}
$mnu = 'Entrée';
$txt= strtolower(trim($mnu));
echo $txt.'-';


/*
function formatdate($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($year, $month, $day) = explode('-', $date);
  $timestamp = mktime( $month, $day, $year );
	$dateUS = date('n/d', $timestamp);
	$month = date('n',$timestamp);
	return $month.'/'.$day;
}
*/
$date = "2012-05-02 00:00:00";
$date = formatdate($date);
//$day  = date('D', strtotime($date));

echo $date;
$datetimeday = date("Y-m-d H:i:s");
list($year,$month,$day,$h,$m,$s)=sscanf($datetimeday,"%d-%d-%d %d:%d:%d");
$s+=120;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeearly=date('Y-m-d H:i:s',$timestamp);
$datetimeday = $timeearly;
echo $datetimeday

?>
<?
/*
$domain = 'noteblaoojf';
$existing = mysql_query('SELECT client_id FROM users WHERE email  LIKE "%'.mysql_real_escape_string($domain).'%" AND client_id AND deactivated = 0');
	
if(!mysql_num_rows($existing)) {
	$existing = mysql_query('SELECT id_client FROM subdomain,clients WHERE domain LIKE "%'.mysql_real_escape_string($domain).'%" AND company_id = id_company_sub');
	}


if(mysql_num_rows($existing)) { //company in database ; send visitor link to sign up
	
		$tpl=file_get_contents('template/emails/signup-registration-link.html');
		$body=str_replace(array('{{link}}'),array('http://cater2.me/signup/?email='.urlencode(stripslashes($_POST['email'])).'&hash='.md5($config['secret'].stripslashes($_POST['email']))),$tpl);
	
		
		echo 'ok1';

		//store email to send reminder later if they end up not signing up
		mysql_query('REPLACE INTO website_signup_attempts (email, `when`) VALUES ("'.mysql_real_escape_string(stripslashes($_POST['email'])).'", "'.date('Y-m-d H:i:s').'")');
		

	} else { //company not registered
		
		$tpl=file_get_contents('template/emails/signup-rejected.html');
		$body=str_replace(array('{{public_email}}'),array($config['public_email']),$tpl);
	echo 'ok2';
	}
*/

		

	
$datetimeday = date("Y-m-d H:i:s");
$datetimeday=time("Y-m-d H:i:s");
$datetimeday=date("Y-m-d H:i:s",$datetimeday);
//echo $datetimeday;

$timeorder = '2012-03-12 13:00:00';

list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$s-=600;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeearly=date('Y-m-d H:i:s',$timestamp);
//echo $timeearly;

/*
SI(NBCAR(ENT((($B4*45)+165)/2))>4;
	si vrai on prends les 4 derniers : DROITE(ENT((($B4*45)+165)/2);4);
	sinon:
		SI(NBCAR(ENT((($B4*45)+165)/2))<4;
			si nb=3 in ajoute 1 SI(NBCAR(ENT((($B4*45)+165)/2))=3;1&ENT((($B4*45)+165)/2);
				sinon si nb=2 ajoute 11 SI(NBCAR(ENT((($B4*45)+165)/2))=2;11&ENT((($B4*45)+165)/2);
					sinon si nb=1 ajoute 111 SI(NBCAR(ENT((($B4*45)+165)/2))=1;111&ENT((($B4*45)+165)/2);ENT((($B4*45)+165)/2))));
					ENT((($B4*45)+165)/2)))

*/
$special_delivery = 30;
$before = $special_delivery * 60;
$s-= $before;
//echo $s;

//$order = 970;
$hashcode = 7847;
$dateday = date("Y-m-d");
$date1 = $dateday.' 00:00:01';
$date2 = $dateday.' 23:59:59';
//echo $date1;



$res = mysql_query(" SELECT id_order 
FROM order_requests, hash
WHERE order_for BETWEEN  '$date1' AND '$date2'
AND code_hash = '$hashcode'
AND order_hash = id_order" );
$tmp = mysql_fetch_assoc($res);
$order_id =  $tmp['id_order'];


$res = mysql_query("SELECT id_order,order_for, companies.name, vendors.name, delivery_difficulty, special_delivery   
   FROM order_requests, clients, companies, vendors, order_proposals
   	where order_requests.client_id = clients.id_client
AND clients.company_id = companies.id_company
AND order_proposals.vendor_id=vendors.id_vendor
AND order_for between  '$date1' and  '$date2'
AND order_requests.id_order='$order_id' and order_proposals.order_id ='$order_id' " );

if(mysql_num_rows($res)==0) { 
echo $order_id.'pas de comamnde';

}
//$reqmod = mysql_query("DELETE FROM tmp_order where" );  					

 $neworder = ((($order * 45)+165)/2) ;
 
 //echo $neworder;
 $neworder = floor( $neworder);
 if(strlen($neworder)>4)
 { 
 $neworder = substr($neworder, -4); 
 //echo $neworder;
 }
 else  {
 	//$neworder = round( $neworder);
 	if(strlen($neworder)==3)
 	{ 
 	//$neworder = round( $neworder);
 	$neworder = '1'.$neworder;}
 }
 //echo '-'.$neworder;
 
 $order2 = 194842;
 $neworder2 = ((($order2 * 2)-165)/45) ;
 //echo round($neworder2);
 
 
 
/*
 for ($i=8000; $i<20000;$i++)
 {
 $neworder = ((($i * 45)+165)/2) ;
 $neworder = floor( $neworder);
 if(strlen($neworder)>4)
 { 
 $neworder = substr($neworder, -4); 
 //echo $neworder;
 }
 else  {
 	//$neworder = round( $neworder);
 	if(strlen($neworder)==3)
 	{ 
 	//$neworder = round( $neworder);
 	$neworder = '1'.$neworder;}
 }
*/
	//echo '<br>'.$i.' : '.$neworder;
	
	//$sql = "Delete From hash where order_hash =	'$i'";
	//mysql_query($sql) or die($sql.':'.mysql_error());
	//$sql = 'INSERT INTO hash (order_hash, code_hash )
	//VALUES
//('.$i.', "'.$neworder.'" );
//	';
//	mysql_query($sql) or die($sql.':'.mysql_error());
 //}
 
?>


<? if($_SERVER['REQUEST_METHOD']=='POST')
{
$choix = $_POST['type'];
echo $choix;
}
?>
 <form method="post">

 <? 
 $typ="$";

 if($typ == "%")
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
            <input type="submit" value="Submit" id="submit" class="submit">
</form>


<?
/*

function formatdate($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($year, $month, $day) = explode('-', $date);
  $timestamp = mktime( $year ,$month, $day);
	$dateUS = date('m/d', $timestamp);
	return $month.'/'.$day;
}
*/
$date = '2012-03-02';
$tmp = formatdate($date);
echo $tmp;
//echo date('D', strtotime("2012-03-02")); 

?>

<input type="radio" name="order<?=$popup['id_popup']?>" value="order0" <? if($order=="0") echo "checked";?>> 0
	<input type="radio" name="order<?=$popup['id_popup']?>" value="order1"<? if($order=="1") echo "checked";?>> 1
	<input type="radio" name="order<?=$popup['id_popup']?>" value="order2"<? if($order=="2") echo "checked";?>> 2
	<input type="radio" name="order<?=$popup['id_popup']?>" value="order4"<? if($order=="3") echo "checked";?>> 3
	<input type="radio" name="order<?=$popup['id_popup']?>" value="order4"<? if($order=="4") echo "checked";?>> 4
	<input type="radio" name="order<?=$popup['id_popup']?>" value="order5"<? if($order=="5") echo "checked";?>> 5
 </td>


<link rel="stylesheet" href="/template/css/custom/jquery-ui-1.8.18.calendar.css" />
<script src="/template/js/custom/jquery.ui.core.js"></script>
<script src="/template/js/custom/jquery.cookie.js"></script>
<script src="/template/js/custom/jquery.ui.widget.js"></script>
<script src="/template/js/custom/jquery.ui.tabs.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>	
	
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
		<script src="/template/js/jquery.fancybox-1.3.4.js"></script>
		<script src="/template/js/mosaic.1.0.1.min.js"></script>
		<script src="/template/js/jquery.tooltip.min.js"></script>
		<script src="/template/js/portfolio.js"></script>
	<script src="/template/js/hoverIntent.js"></script>
	<script src="/template/js/superfish.js"></script>
		<script src="/template/tuw-inc/jquery.tuw.js"></script>
		<script type="text/javascript" src="/template/includes/js/jquery.jigowatt.js"></script>
	<script src="/template/js/scripts.js"></script>
	<script src="/template/js/tabbed.js"></script>
		<script src="/template/js/jquery.quote_rotator.js"></script>
	<script src="/template/js/jquery.nivo.slider.pack.js"></script>
	
<script>
	$(function() {
		$( "#tabs" ).tabs({
			cookie: {
				// store cookie for a day, without, it would be a session cookie
				expires: 1
			}
		});
	});
	</script>



<div class="demo">

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Nunc tincidunt</a></li>
		<li><a href="#tabs-2">Proin dolor</a></li>
		<li><a href="#tabs-3">Aenean lacinia</a></li>
	</ul>
	<div id="tabs-1">
		<p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
	</div>
	<div id="tabs-2">
		<p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
	</div>
	<div id="tabs-3">
		<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
		<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
	</div>
</div>

</div><!-- End demo -->



<div style="display: none;" class="demo-description">
<p>Click tabs to swap between content that is broken into logical sections.</p>
</div><!-- End demo-description -->

<?
$v='1';
$g='0';
$d ='1';
$tmp='allergene: ';

if ( $v=='1')
 $veg = '(V)';	
		if ($g=='1')
 $glu = '(G)';
		if ($d=='1')
$dai = '(D)';
			
echo 	$description.= '* '.$tmp.' '.$veg.$glu.$dai."\n";


$body = '11420' ;
//$body = str_pad($body, 4,0, STR_PAD_LEFT);
$order_id = $body - 5;
$order_id = strrev($order_id);
$order_id = str_pad($order_id, 4,0, STR_PAD_RIGHT);
echo $order_id;

$number = 953;
$number = str_pad($number, 4,0, STR_PAD_LEFT);
//echo $number;

$test='1234';
$result = str_split($test);
$nb1 = $result[0];
$nb2 = $result[1];
$nb3 = $result[2];
$nb4 = $result[3];

//$result = strrev($test);
//$result = $result +5;
//$result = encode($test);
$result = $nb4.$nb1.$nb3.$nb2;

$test2='12345';
$result2 = str_split($test);
$nb12 = $result2[0];
$nb22 = $result2[1];
$nb32 = $result2[2];
$nb42 = $result2[3];

//$result = strrev($test);
//$result = $result +5;
//$result = encode($test);
$result2 = $nb4.$nb1.$nb3.'0';




?>