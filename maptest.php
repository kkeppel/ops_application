<?
require 'lib/core.php';

$template = array(
	'title' => 'Cater2.me | Calendar',
	'menu_selected' => 'dashboard',
	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Calendar'=>'/home/dashboard/calendar/'),
	
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>
		

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
		
		<script src="/template/js/custom/jquery.ui.tabs.js"></script>
		<script src="/template/js/custom/jquery.cookie.js"></script>

		<script src="/template/js/custom/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>

	
		',
	
	'grey_bar' => 'Your Catering Calendar',
	
	'slider_open' => true
	);
	
		function getCoordonnees($add){
	    $apiKey = "ABQIAAAAkMZZeqQ64x8q-Fzvqxz3hhR5UcgDXbjkQl2wNLLk4konkWYROxQQvB_ayskBUDKt0M7sJqTVgNXO0A";
	    $url = "http://maps.google.com/maps/geo?q=".urlencode($add).
	"&output=csv&key=".$apiKey;
	    $csv = file($url);
	    $donnees = explode(",",$csv[0]);
	    return $donnees[2].",".$donnees[3];
	}
	?>


               <script src="jquery.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false">
               <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDYgD10RG6svH1vjIWmH-sApH4OTyZyfQ4&sensor=false"> </script>
               <script>        
               $(document).ready(function(e) {
                       //ou l'inverse pour lattitude et longitude je sais pas le sens
                       var latlng = new google.maps.LatLng("-33.8719830", "151.1990860");
                       var myOptions = {
                               zoom: 12,
                               center: latlng,              
                               mapTypeId: google.maps.MapTypeId.ROADMAP
                       };
                       var map = new google.maps.Map( document.getElementById("mappy"), myOptions );
               });
               </script>
     	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false">
	</script>
	
	<div id="map_canvas" style="width: 250px; height: 250px"></div><br><br>
	 <script type="text/javascript">


	 var locations = [
	      ['<b><?=$vendor1?></b><br><?=$arrayAdress[0]?><br><a href="http://<?=$arrayweb[0]?>" target="_blank"><?=$arrayweb[0]?></a>',<?=$coor1?>],
	      ['<b><?=$vendor2?></b><br><?=$arrayAdress[1]?><br><a href="http://<?=$arrayweb[1]?>" target="_blank"><?=$arrayweb[1]?></a>',<?=$coor2?>],
	      ['<b><?=$vendor3?></b><br><?=$arrayAdress[2]?><br><a href="http://<?=$arrayweb[2]?>" target="_blank"><?=$arrayweb[2]?></a>',<?=$coor3?>],
	      ['<b><?=$vendor4?></b><br><?=$arrayAdress[3]?><br><a href="http://<?=$arrayweb[3]?>" target="_blank"><?=$arrayweb[3]?></a>',<?=$coor4?>],
	      ['<b><?=$vendor5?></b><br><?=$arrayAdress[4]?><br><a href="http://<?=$arrayweb[4]?>" target="_blank"><?=$arrayweb[4]?></a>',<?=$coor5?>],
	    ];


	 var map = new google.maps.Map(document.getElementById('map_canvas'), {
	      zoom: <?=$zoom?>,
	      center: new google.maps.LatLng(<?=$coor?>),
	       mapTypeId: google.maps.MapTypeId.ROADMAP
	    });

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
               <div id="mappy" style="height:100%;"></div>
     
