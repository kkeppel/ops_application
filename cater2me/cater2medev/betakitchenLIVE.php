
<?
require 'lib/core.php';
function formatdate($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($year, $month, $day) = explode('-', $date);
  $timestamp = mktime( $year ,$month, $day);
	$dateUS = date('m/d', $timestamp);
	return $month.'/'.$day;
}



$address= '138 Minna St';
$city = 'san francisco';
$address2= $address. ',' . $city;

function getCoordonnees($add){
    $apiKey = "ABQIAAAAkMZZeqQ64x8q-Fzvqxz3hhR5UcgDXbjkQl2wNLLk4konkWYROxQQvB_ayskBUDKt0M7sJqTVgNXO0A";
    $url = "http://maps.google.com/maps/geo?q=".urlencode($add).
"&output=csv&key=".$apiKey;
    $csv = file($url);
    $donnees = explode(",",$csv[0]);
    return $donnees[2].",".$donnees[3];
}

$coor=  getCoordonnees($address2);

$areas=array();
$res = mysql_query('SELECT label, value FROM website_editable_areas WHERE label = "twitter_widget"');
while($log = mysql_fetch_assoc($res)) {
	$areas[$log['label']]=$log['value'];
}

?>

<?
$template = array(
	'title' => 'Cater2.me | BetaKitchen',
	'breadcrumb' => array('PopUp '=>'BetaKitchen'),
	
	'menu_selected' => 'BetaKitchen',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
		<script src="/template/js/custom/jquery.ui.tabs.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>


	<script src="/template/js/slides.min.jquery.js"></script>
	<script src="/template/js/jquery.nivo.slider.pack.js"></script>
	<script src="/template/tuw-inc/jquery.tuw.js"></script>
	<script src="/template/js/custom/jquery.tipTip.minified.js"></script>

		
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

		.titlebeta{
		color: #9C1C22;
		font-size:18px;
		font-weight:bold;
		}
		
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
		
		table{
		border-width : 0px;
		width: 100%;
		margin: 2px ;
		}
		td {
		border-width : 0px;
		}
		.td .vendor{
		border-width : 1px;
		}
		
		</style>
	',

	'grey_bar' => '<img src="/template/images/custom/betakitchen1.png">'
	);

require 'header.php';

	
?>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<script type="text/javascript">
$(window).load(function() {
    $('#slider').nivoSlider({
        effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
        slices: 4, // For slice animations
        boxCols: 8, // For box animations
        boxRows: 4, // For box animations
        animSpeed: 1000, // Slide transition speed
	    pauseTime:7000,
        startSlide: 0, // Set starting Slide (0 index)
        directionNav: false, // Next & Prev navigation
        directionNavHide: false, // Only show on hover
        controlNav: true, // 1,2,3... navigation
        controlNavThumbs: false, // Use thumbnails for Control Nav
        controlNavThumbsFromRel: false, // Use image rel for thumbs
        controlNavThumbsSearch: '.jpg', // Replace this with...
        controlNavThumbsReplace: '_thumb.jpg', // ...this in thumb Image src
        keyboardNav: false, // Use left & right arrows
        pauseOnHover: true, // Stop animation while hovering
        manualAdvance: false, // Force manual transitions
        captionOpacity: 0.8, // Universal caption opacity
        prevText: '', // Prev directionNav text
        nextText: '', // Next directionNav text
        randomStart: false, // Start on a random slide
        beforeChange: function(){}, // Triggers before a slide transition
        afterChange: function(){}, // Triggers after a slide transition
        slideshowEnd: function(){}, // Triggers after all slides have been shown
        lastSlide: function(){}, // Triggers when last slide is shown
        afterLoad: function(){} // Triggers when slider has loaded
    });
});

</script>



<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<style type="text/css">
.ui-widget-overlay { opacity: .90;filter:Alpha(Opacity=70); }

input:-moz-placeholder, textarea:-moz-placeholder {
    color: black;
}
input:-ms-placeholder, textarea:-moz-placeholder {
    color: black;
}


input::-webkit-input-placeholder {
    color:black;
}
.nivoSlider img {
    position:absolute;
    top:0px;
    left:0px;
/*     display:none; */
}
.nivoSlider a {
    border:0;
    display:block;
}

.nivo-slice {
   display:block;
   position:absolute;
   z-index:5;
   height:100%;
}

.nivo-box {
   display:block;
   position:absolute;
   z-index:5;
}
.ui-widget-header {
		 		border: 0px ;
}
.ui-widget-header a {
		 		border: 0px ;
		 		
}
.ui-widget-content{
		 		border: 0px solid;	
}.acc .post-content-wrap a {
    background-color: white;
	border: none;    
}
#testimonial_content{
  opacity:0.5;
  background-color: grey;
}

#slider-wrapper {
background:white;
width:950px; /* LARGEUR DU FOND */
height:350px; /* HAUTEUR DU FOND */
margin:0 auto; /* MARGE */
margin-top:0px;
padding-top:0px; /* MARGE INTÉRIEUR EN HAUT */
padding-left: 0px; /* MARGE INTÉRIEUR GAUCHE */
margin-top: 0px; /* MARGE EXTÉRIEUR EN HAUT POUR QUE LE SLIDE NE COLLE PAS A D'AUTRES ELEMENTS */
}
.nivo-caption {
position:absolute;
top: 330px;
background:#000;
color:#fff;
opacity:0.8; /* Overridden by captionOpacity setting */
width:300px;
z-index:8;
}
.nivo-caption p {
padding:5px;
margin:0;
}
.nivo-caption a {
display:inline !important;
color:#efe9d1;
text-decoration:underline;
}
.nivo-html-caption {
display:none;
}
.nivo-caption {
text-shadow:none;
font-family: Helvetica, Arial, sans-serif;
 margin-left: 20px;
 padding-left: 5px;
 padding-right: 5px;
}
.caption-img {
	color: white ;
    font-size: 13px;
    font-weight: 400;
    line-height: 20px;
   
}
div#acc {	
width: 500px;
float: left;
display:inline;
}
div#acc2 {	
float: left;
}
.hr-pattern {
height:2px;
padding-bottom: 5px;
margin-bottom: 5px;
}

#post-content-wrap a {
    background-color: White;
	border: none;    
/* 	font-size:15px; */
}
#slider {
margin: 13px 0px 25px 0px;}

</style> 
<?
function parse($text)
{
 $text = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0" target="_blank">$0</a>', $text);
 $text = preg_replace('#@([a-z0-9_]+)#i', '@<a href="http://twitter.com/$1" target="_blank">$1</a>', $text);
 $text = preg_replace('# \#([a-z0-9_-]+)#i', ' #<a href="http://search.twitter.com/search?q=%23$1" target="_blank">$1</a>', $text);
 return $text;
}

$user = "c2mesf"; /* Nom d'utilisateur sur Twitter */
$count = 1; /* Nombre de message à afficher */
$date_format = 'd M Y, H:i:s'; /* Format de la date à afficher */
$url = 'http://twitter.com/statuses/user_timeline/'.$user.'.xml?count='.$count;
$oXML = simplexml_load_file( $url );
?> <div class="hr-pattern"></div><center> <a href="http://twitter.com/#!/C2meSF" target="_blank"><img src="/template/images/twitterbird.png" width="25px" height="20px"></a> <span style="font-size: 12px;"> <a href="http://twitter.com/#!/C2meSF" target="_blank">Twitter feed:</a> <?
foreach( $oXML->status as $oStatus )
{
 $datetime = date_create($oStatus->created_at);
 $date = date_format($datetime, $date_format)."\n";
 echo parse(utf8_decode($oStatus->text));?> <?
 //echo ' (<a href="http://twitter.com/'.$user.'/status/'.$oStatus->id.'">'.$date.'</a>)</li>';
 echo ' <span style="font-size: 12px;"><a href="http://twitter.com/'.$user.'/status/'.$oStatus->id.'" target="_blank"></a></span>';
}
?></span></center>


<div class="hr-pattern"></div>

 <div id="slider-wrapper">
 
 
 
<div id="slider" class="nivoSlider" >
	
 
   		<img src="/template/images/popup/webbanner7.jpg" alt=""  />    
   		<img src="/template/images/popup/webbanner8.jpg" alt=""  />
   		<img src="/template/images/popup/webbanner9.jpg" alt=""  />
   		<img src="/template/images/popup/webbanner10.jpg" alt=""  />
   		<img src="/template/images/popup/webbanner11.jpg" alt="" />
   		<img src="/template/images/popup/webbanner12.jpg" alt="" />
   		<img src="/template/images/popup/webbanner13.jpg" alt="" />
   </div>

<div class="nivo-caption">
 <center>
              <b><span style="font-size: 12px;">Sign up for our newsletter and get $1 off your meal at BetaKitchen!</span></b>
              <br><br>
              <form action="../signup_popup.php" method="post">
	 &nbsp;&nbsp;&nbsp;<input type="email" id="email" name="email" placeholder="Your email" /> 
	 <input type="submit" name="Send" value="Send"  />
	 		</form>
	 <div class="fb-like-box" data-href="http://www.facebook.com/C2meSF" data-width="300" data-colorscheme="dark" data-show-faces="false" data-stream="false" data-header="false">
	 </div><br>
	 &nbsp;&nbsp;&nbsp; <a href="https://twitter.com/c2mesf" class="twitter-follow-button" data-size="large" data-show-count="false"></a>
</center>
				
 </div>
</div>
<br>

<!-- <img src="/template/images/custom/popup_imgtest.jpg" alt="" /> -->
<center>
<!-- <img width="950px" height="300px" src="/template/images/custom/popup_imgtest.jpg" -->
</center>
<table>
<tr><td width="27%"  >
<span style="font-size: 18px;">ABOUT US</span><div class="hr-pattern"></div><br>
<span style="font-size: 12px;">
Cater2.me’s BetaKitchen, a rotating food pop-up and test kitchen, is
launching Friday, April 13th in SOMA to bring a creative and
innovative lunch option to the downtown crowd. BetaKitchen will bring
some of San Francisco’s best, from the likes of underground pop-up
favorites Soul Groove and Radio Africa, to the Ferry Building’s El
Porteno and Inner Richmond’s Little Vietnam.
<br><br>
We’re really excited about BetaKitchen as it provides another access
point for connecting communities around innovative food.  Downtowners
will have the opportunity to interact with local chefs as they try out
new food concepts in this test kitchen platform.
<br><br>
We hope to see you there! <br><br>
Click <a href="/betakitchen/Cater2mes_BetaKitchen_Press.pdf" target="_blank">here</a> to download more information about BetaKitchen or <a href="/betakitchen/BetaKitchen_PressKit.zip">here</a> for a zip file containing BetaKitchen logos
</span>
</td>

<td  width="46%"  >

<span style="font-size: 18px;">CHECK OUT WHO'S COMING</span>
<div class="hr-pattern"></div><br>
<div class="titlebeta">
UP NEXT... </div>
<br>
<? 
$res = mysql_query("SELECT * FROM betakitchen where order_beta = '1'");
$popup1 = mysql_fetch_assoc($res);
$name_popup1= $popup1['name_beta'];
$id_popup1= $popup1['id_beta'];
$bio_popup1= $popup1['bio_beta'];
$desc_popup1= $popup1['desc_beta'];?>
<div class="accordion">
	<h3 style="border:0px;"><span style="font-size: 15px;"><a href="#"> <?=nl2br($name_popup1)?> </a></span></h3>
	<div><span style="font-size: 12px;"><?=nl2br($bio_popup1); ?>
	</div> 
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a  href="#" onclick="$('<div></div>').dialog({ width: 600 , position: 'top' ,modal: true,autoLoad : true}).load('/menu_popup.php?pop=<?=$id_popup1?>;');"> 
<span style="font-size: 12px;"> Menu  </span></a> 
  <br>  <br>
  
 <!-- Horizontal Line -->
<div class="titlebeta">
<span style="font-size: 18px;">COMING TO BETAKITCHEN: </span>
</div><br> 
<? 
$res2 = mysql_query("SELECT * FROM betakitchen where order_beta = '2'");
$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name_beta'];
$id_popup2= $popup2['id_beta'];
$bio_popup2= $popup2['bio_beta'];
$desc_popup2= $popup2['desc_beta'];?>
<div class="accordion">
	<h3 style="border:0px;"><span style="font-size: 15px;"><a href="#"> <?=nl2br($name_popup2)?> </a></span></h3>
	<div><span style="font-size: 12px;"><?=nl2br($bio_popup2); ?></span>
	</div> 
</div>

<?
$res3 = mysql_query("SELECT * FROM betakitchen where order_beta = '3'");
$popup3 = mysql_fetch_assoc($res3);
$name_popup3= $popup3['name_beta'];
$id_popup3= $popup3['id_beta'];
$bio_popup3= $popup3['bio_beta'];
$desc_popup3= $popup3['desc_beta'];?>
<div class="accordion">
	<h3 style="border:0px;"><span style="font-size: 15px;"><a href="#"> <?=nl2br($name_popup3)?> </a></span></h3>
	<div><span style="font-size: 12px;"><?=nl2br($bio_popup3); ?></span>
	</div> 
</div>
 <?
$res4 = mysql_query("SELECT * FROM betakitchen where order_beta = '4'");
$popup4 = mysql_fetch_assoc($res4);
$name_popup4= $popup4['name_beta'];
$id_popup4= $popup4['id_beta'];
$bio_popup4= $popup4['bio_beta'];
$desc_popup4= $popup4['desc_beta'];?>
<div class="accordion">
	<h3 style="border:0px;"><span style="font-size: 15px;"><a href="#"> <?=nl2br($name_popup4)?> </a></span></h3>
	<div><span style="font-size: 12px;"><?=nl2br($bio_popup4); ?></span>
	</div> 
</div>
 <?
$res5 = mysql_query("SELECT * FROM betakitchen where order_beta = '5'");
$popup5 = mysql_fetch_assoc($res5);
$name_popup5= $popup5['name_beta'];
$id_popup5= $popup5['id_beta'];
$bio_popup5= $popup5['bio_beta'];
$desc_popup5= $popup5['desc_beta'];?>
<div class="accordion">
	<h3 style="border:0px;"><span style="font-size: 15px;"><a href="#"> <?=nl2br($name_popup5)?> </a></span></h3>
	<div><span style="font-size: 12px;"><?=nl2br($bio_popup5); ?></span>
	</div> 
</div>
<br> 
 <?
?>
 
<span style="font-size: 12px;">
Like/Follow us to get the latest BetaKitchen news:
<br>
<div class="fb-like-box" data-href="http://www.facebook.com/C2meSF" data-width="292"  data-show-faces="false" data-stream="false" data-header="false">
	 </div><br>
	 &nbsp;&nbsp;&nbsp; <a href="https://twitter.com/c2mesf" class="twitter-follow-button" data-show-count="false" data-size="large"></a>
	 </span>
</td>

<td  width="27%">
<span style="font-size: 18px;">HOURS AND LOCATION</span>
<div class="hr-pattern"></div><br>
<table>
<tr><td align="left">
<span style="font-size: 12px;">
WHEN:</span>
</td>
<td><span style="font-size: 12px;">Launching Friday, April 13th</span></td>
</tr>
<tr><td align="left">
<span style="font-size: 12px;">WHERE:</span>
</td>
<td>
<img src="/template/images/custom/JC-LogopOG_black.png" width="140px" height="30px" /><br>
<span style="font-size: 12px;">John Colins<br>138 Minna Street <br>(between New Montgomery and 3rd Street)</span></td>
</tr>

</table>

<br>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false">
</script>
<div id="map_canvas" style="width: 250px; height: 250px"></div>
 <script type="text/javascript">
var myLatlng = new google.maps.LatLng(<?=$coor?>);
var myOptions = {
  zoom: 16,
  center: myLatlng,
  mapTypeId: google.maps.MapTypeId.ROADMAP
};
 
var map = new google.maps.Map(document.getElementById("map_canvas"),
    myOptions);
    var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title:"Here!"
  });
    </script>
</td></table>
<br><br>


<? 
require 'footer.php';

?>