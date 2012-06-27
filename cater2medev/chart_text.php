<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');
	
	if($_SERVER['REQUEST_METHOD']=='POST')
{
 $vendor = $_POST['vendor'];
 $company = $_POST['company'];
 $date1 =  $_POST['date1'];
 $date1=$date1.' 00:00:00';
 $date2 =  $_POST['date2'];
 $date2=$date2.' 23:59:59';
 if ($date1==' 00:00:00'){$date1='2012-01-01 00:00:00';}
 if ($date2==' 23:59:59'){$date2='2012-12-01 00:00:00';}
 $date3 =  $_POST['date3'];
 $date3=$date3.' 00:00:00';
 $date4 =  $_POST['date4'];
 $date4=$date4.' 23:59:59';
 if ($date3==' 00:00:00'){$date3='2012-01-01 00:00:00';}
 if ($date4==' 23:59:59'){$date4='2012-12-01 00:00:00';}
}



$template = array(
	'title' => 'Cater2.me | Chart Text',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/'),
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>

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
		
		function deleteResource(res_type, id) {
			document.f.delete_resource.value=res_type;
			document.f.id_resource.value=id;
			document.f.submit();
		}
		
		function validate() {

	if(document.getElementById("date1").value > document.getElementById("date2").value)
	{
	alert("Please pick a start date prior to the end date");
	return false;
	}
	return true;
	}
	
	function validate2() {

	if(document.getElementById("date3").value > document.getElementById("date4").value)
	{
	alert("Please pick a start date prior to the end date");
	return false;
	}
	return true;
	}


	$(function()
	{
	var date1 = $("#date1").datepicker({ dateFormat: "yy-mm-dd" });
	$("#date1").datepicker();
	
	var date2 = $("#date2").datepicker({ dateFormat: "yy-mm-dd" });
	$("#date2").datepicker();

	var date3 = $("#date1").datepicker({ dateFormat: "yy-mm-dd" });
	$("#date3").datepicker();
	
	var date4 = $("#date2").datepicker({ dateFormat: "yy-mm-dd" });
	$("#date4").datepicker();
	})
		</script>
		
		<style>
		
		#tblHTML td {
		  height: 35px;
		  vertical-align: middle;
		}
		#tblHomeSlider {
		border:0;
		width:100%;
		}
		#tblHomeSlider td {
		border:0;
		}
		
		fieldset {
		border:1px #777 solid;
		padding:10px;
		}
		fieldset legend {
		margin-left:2px;
		}
		.del {
		color:red !important;
		}
		</style>
	',
	
	'grey_bar' => 'Chart Text'
	);

require 'header.php';
?>

<form method="post" action =""onsubmit="return validate2();">
Choose a vendor
<? $select_vendors = '<select name = "vendor"><option value="">-- vendor --</option>';
$res = mysql_query('SELECT id_vendor, name FROM vendors order by name');
while($log = mysql_fetch_assoc($res)) {
	$select_vendors.='<option value="'.$log['id_vendor'].'">'.$log['id_vendor'].' - '.$log['name'].'</option>';
}
$select_vendors.= '<select>'
		?>
		<?= $select_vendors ?><br><br>
		Start date <input type="text" id="date3" name="date3" placeholder="yy-mm-dd" value=""  /><br><br>
&nbsp;&nbsp;End date <input type="text" id="date4" name="date4" placeholder="yy-mm-dd" value=""  /><br><br>
		<input type="submit" value="Submit"/>
</form>
<br><br>
<?
$res1 = mysql_query("SELECT order_id_t, datetime_t, order_for, name 
FROM text_vendor, order_proposals, order_requests, vendors
WHERE order_id = order_id_t
AND order_id_t = id_order
AND selected =1
and text=1
and vendor_id= id_vendor
AND vendor_id ='$vendor'");

$early = 0;
$ontime = 0;
$late = 0;
while($text = mysql_fetch_assoc($res1))
{
$name = $text['name'];
$timeorder = $text['order_for'];
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$s-=600;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeearly=date('Y-m-d H:i:s',$timestamp);
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$s+=300;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeelate=date('Y-m-d H:i:s',$timestamp);

$timeText2 = $text['datetime_t'];

//echo $timeText2.' ---- '.$timeearly.'<br>';
if ($timeText2  < $timeearly) 
	{ 
	$early++;
	}
else if ($timeText2  < $timeelate and  $timeText2 > $timeearly) 
	{
	$ontime++;
	}
else if ($timeText2  > $timeelate) 
	{ 
	$late++;}

}

//echo $early.'<br>'.$ontime.'<br>'.$late;

if ($early=='' and $ontime=='' and $late=='' )
{}
else {
?>
<script type="text/javascript">
    
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'Number'],
          ['Early: <?=$early?> ',  <?=$early?>],
          ['On time: <?=$ontime?>', <?=$ontime?>],
          ['Late:<?=$late?> ',  <?=$late?>]
        ]);

        var options = {
          title: 'Status text message for <?=$name?>'
        };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);

    }
    
    </script>
      <div id="chart_div" style="width:400; height:300"></div>

<?
}
?>
<form method="post" action =""  onsubmit="return validate();">
Choose a company
<? $select_companies = '<select name = "company"><option value="">-- company --</option>';
$res = mysql_query('SELECT id_company, name FROM companies order by name');
while($log = mysql_fetch_assoc($res)) {
	$select_companies.='<option value="'.$log['id_company'].'">'.$log['id_company'].' - '.$log['name'].'</option>';
}
$select_companies.= '<select>'
		?>
		<?= $select_companies ?><br><br>
	Start date <input type="text" id="date1" name="date1" placeholder="yy-mm-dd" value=""  /><br><br>
&nbsp;&nbsp;End date <input type="text" id="date2" name="date2" placeholder="yy-mm-dd" value=""  /><br><br>
		<input type="submit" value="Submit"/>
</form>
<?
$res10 = mysql_query("SELECT order_id_t, datetime_t, order_for, name 
FROM text_vendor, order_requests, companies, clients
WHERE  order_id_t = id_order
and client_id = id_client 
and company_id =  id_company
and text=1
and order_for between '$date1' and '$date2'
AND company_id ='$company'");


$early2 = 0;
$ontime2 = 0;
$late2 = 0;
while($text2 = mysql_fetch_assoc($res10))
{
$name2 = $text2['name'];
$timeorder2 = $text2['order_for'];
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder2,"%d-%d-%d %d:%d:%d");
$s-=600;
$timestamp2=mktime($h,$m,$s,$month,$day,$year);
$timeearly2=date('Y-m-d H:i:s',$timestamp2);
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder2,"%d-%d-%d %d:%d:%d");
$s+=300;
$timestamp2=mktime($h,$m,$s,$month,$day,$year);
$timeelate2=date('Y-m-d H:i:s',$timestamp2);

$timeText20 = $text2['datetime_t'];

//echo $timeText20.' ---- '.$timeearly2.'<br>';
if ($timeText20  < $timeearly2) 
	{ 
	$early2++;
	}
else if ($timeText20  < $timeelate2 and  $timeText20 > $timeearly2) 
	{
	$ontime2++;
	}
else if ($timeText20  > $timeelate2) 
	{ 
	$late2++;}

}

//echo $early.'<br>'.$ontime.'<br>'.$late;

if ($early2=='' and $ontime2=='' and $late2=='' )
{}
else {
?>
<script type="text/javascript">
    
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'Number'],
          ['Early: <?=$early2?> ',  <?=$early2?>],
          ['On time: <?=$ontime2?>', <?=$ontime2?>],
          ['Late:<?=$late2?> ',  <?=$late2?>]
        ]);

        var options = {
          title: 'Status text message for <?=$name2?>'
        };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);

    }
    
    </script>
      <div id="chart_div" style="width:600; height:500"></div>

<?
}


require 'footer.php';

?>