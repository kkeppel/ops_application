
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
	'meta_name' => 'Cater2.me’s BetaKitchen, a rotating food pop-up and test kitchen in SOMA  to bring a creative and innovative lunch option to the downtown crowd.',
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
        nextText: '', // Next dire