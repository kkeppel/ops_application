<?php require_once('conf/config.php') ;
require_once('lib/core.php');
echo getUserGroup($curUser) ;
$name_user= $curUser['first_name'];
?>

<?
$tmp=$_GET["a"];
//$body_arg=$_GET["a"]; 
$body_arg_tmp = explode("/", $tmp);
$body_arg= $body_arg_tmp['0'];


?>



<?php function curl_get($url) { $curl = curl_init($url); curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); curl_setopt($curl, CURLOPT_TIMEOUT, 30); $return = curl_exec($curl); curl_close($curl); return $return; } if (isset($accounts['twitter']['username']) && $accounts['twitter']['username'] != '') { $twitter_on = true; $twitter_xml_feed = 'http://api.twitter.com/1/statuses/user_timeline.xml?screen_name='.$accounts['twitter']['username']; $twitter_simple_xml = simplexml_load_file($twitter_xml_feed); $twitter_status_feed = $twitter_simple_xml->status; } ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<head>
	<title><?php echo $name; ?></title>

	<meta http-equiv="Content-category" content="text/html; charset=ISO-8859-1" />
	<link href="/css/splash.css" rel="stylesheet" category="text/css" />
	<link href="/template/css/typography.css" rel="stylesheet" category="text/css" />	
	<script type="text/javascript" src="/js/scripts.js"></script>	

    <link rel="icon" type="/image/vnd.microsoft.icon" href="/favicon.ico" />
	<link rel="SHORTCUT ICON" href="/favicon.ico" />
	<script src="/js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<?php if (isset($accounts['flickr']['username']) && isset($accounts['flickr']['apikey']) && $accounts['flickr']['apikey'] != '' && $accounts['flickr']['username'] != '') { ?>

	<script type="text/javascript" src="js/galleria.js"></script>
	<script type="text/javascript" src="js/plugins/galleria.flickr.js"></script>
	<script>
	    // Load theme
	    Galleria.loadTheme('js/themes/lightbox/galleria.lightbox.js');
	</script>
	<?php } ?>

	<?php if (isset($accounts['vimeo']['username']) || isset($accounts['youtube']['username'])) { ?>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			$("a[rel^='prettyPhoto']").prettyPhoto();
		});
	</script>
	<script src="/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
	<?php } ?>

	<script type="text/javascript" src="/js/switches.js"></script>
	<script type="text/javascript">
		//document.getElementById('nav').style = 'display: none;';
	</script>
	<style>
		body
		{

			<?php if(isset($visual_style['background_image']) && $visual_style['background_image'] != '') {echo 'background-image: url('.$visual_style['background_image'].');';} ?>

		}
		div#nav, div#nav a
		{

			<?php if(isset($visual_style['navigation_color']) && $visual_style['navigation_color'] != '') { echo('color: '.$visual_style['navigation_color'].';'); } ?>

			<?php if(isset($visual_style['navigation_shadows']) && $visual_style['navigation_shadows'] != '') { echo 'text-shadow:0px 0px 6px #666'; } ?>

		}
	</style>
</head>
<body class="<? echo $body_arg ?>">


	<div id="nav_<? echo $position ?>"><font color= <? echo $color ?>>
		<h1><?php echo $name; ?></h1>
</font>
		<div id="elements">
			<ol><font color= <? echo $color ?>>
				<li><a href="javascript:switchto('about');" id="nav_about"><font color= <? echo $color ?>>about</a></li></font>
				<li><a href="javascript:switchto('menu');" id="nav_about"><font color= <? echo $color ?>>menu</a></li></font>
				<li><a href="javascript:switchto('comments');" id="nav_about"><font color= <? echo $color ?>>comments</a></li></font>
				<li><a href="javascript:switchto('events');" id="nav_about"><font color= <? echo $color ?>>events</a></li></font>
				<?php if ($flickr_on == true) { ?><li><a href="javascript:switchto('photos');" id="nav_photos">photos</a></li><?php } ?>
				<?php if ($video_bubble == true) { ?><li><a href="javascript:switchto('videos');" id="nav_videos">videos</a></li><?php } ?>
				<?php if ($twit != '') { ?><li><a href="javascript:switchto('twitter');" id="nav_twitter"><font color= <? echo $color ?>>twitter</a></li></font><?php } ?>
				<?php if ($fb != '') { ?> <li><a href="javascript:switchto('facebook');" id="nav_about"><font color= <? echo $color ?>>facebook</a></li></font> <?php } ?>
			</ol></font>
		</div>
	</div>

	<!--
<div id="triangle_">
		<img src="/vendor_page/images/bubble_triangle_100.png" width="30" height="15" />
	</div>
-->

	<div id="about" class="content_bubble_<? echo $position ?>">
		<h3>Bio</h3><br>
				<?php $desc = nl2br($desc); ?>
			<div id="bio"><?php echo $desc; ?></div><br><br>
			<div id="img_logo">
			<center><img width="300" src="/upload/<? echo $vendor_name?>_logo.jpg">	</center></div>

	</div>
	<div id="menu" class="content_bubble_<? echo $position ?>">
		<h3>Menu</h3><br>
	<div id="scrollingMenu">
			Appetizer : <p id="menu_design">Soup of the day <br> 
			 <?php echo $app ?>
			 </p>
			Entree : <p id="menu_design"> <?php echo $entree ?> </p>
			Dessert : <p id="menu_design"> <?php echo $dessert ?></p>
	</div>
	</div>

	<div id="facebook" class="content_bubble_<? echo $position ?>">
		<h3>Facebook</h3><br>
		<p>
		<?php function fetch_fb_feed($url, $maxnumber) { ini_set('user_agent', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3'); $updates = simplexml_load_file($url); $fb_array = array(); foreach ($updates->channel->item as $fb_update) { if ($maxnumber == 0) { break; } else { $descfb = $fb_update->description; $descfb = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $descfb); $pubdate = strtotime($fb_update->pubDate); $propertime = gmdate('d F Y, H:i:s', $pubdate); $linkback = $fb_update->link; $tmp1 = $test[1]; $plop=explode(";&lt;img", $tmp1) ; $ref=$plop['0']; $tmp2 = $plop[1]; $tmpimg=explode("&lt;", $tmp2) ; $img2=$tmpimg['0']; $img = '<img '.$img2; $fb_item = array( 'title' => $titlefb, 'desc' => $descfb, 'date' => $propertime, 'link' => $linkback ); array_push($fb_array, $fb_item); $maxnumber--; } } return $fb_array; } ?>

        <?php
$myfb_statuses = fetch_fb_feed('http://www.facebook.com/feeds/page.php?id=10150136746870526&format=rss20', 3); 
foreach ($myfb_statuses as $k => $v) {
 ?> </p><p id="place_comments"> <?php echo  $v['date'] ; $de = $v['desc']; $test = explode("<a href", $de) ; $titlefb= $test[0];?></p> <?php echo $titlefb; ?> <table class="table_fb"><td width="15%"> <?php $tmp1 = $test[1]; $plop=explode("<img", $tmp1) ; $ref=$plop['0']; $tmp2 = $plop[1]; $img = '<img '.$tmp2; $texttmp= $test[2]; $text= '<a href'.$texttmp; echo $img; ?> </td> <?php ?> <td> <p id="place_comments"><?php echo $text; ?> </p></td></table> <?php ?> <p id="place_comments"> <?php echo ' <a href="' . $v['link'] . '" target=\"_blank\">Link to Facebook status</a>'; ?> </p> <?php 
 }
  ?></p>
	</div></div>

	<div id="twitter" class="content_bubble_<? echo $position ?>">
		<h3>Twitter Feeds</h3><br>

		<p>
			<div id ="twitter_feed">
				<?php if ($twitter_on == true) { ?>
				<?php $i=0; 
				foreach ($twitter_simple_xml->status as $tweet) 
				{ if ($i<5) { 
					echo '<p class="tweet"><img src="'.$tweet->user->profile_image_url.'" style="float: left; margin: 0 8px 8px 0;" />'.$tweet->text.'<br /><span style="font-size: 10px; font-style: italic;">'.$tweet->created_at.'</span></p><hr />'; $i++; } } ?>
				<p id="more">
					<a href="http://twitter.com/<?php echo $accounts['twitter']['username'] ?>">More...</a>
				</p>
				<?php } ?>
			</div>
		</p>
	</div>

	<div id="comments" class="content_bubble_<? echo $position ?>">
		<h3>Comments</h3><br>
		<p>
		 
		  <?php if (!empty($_POST['add_comment'])) { ?>
		 <!--  add new comments -->
		
		 <form method="post" action="/vendor_page.php?a=body_comment/<? echo $vendor_name; ?>" name="add_com">
	 <div class="target2">Tell us what you think about this vendor </div>
	 <div class="plop2" style="display:none;"> 
	 <textarea rows="2" cols="60" name="text" class="textareacom" ></textarea>
		
		  <input type="submit" value="Post" name="add_comment" /></p>
		  </div>
		 
		 </form>

		 <div id="scrollingComments">
		<?php $i=0; $name = $_POST['name'];  $text_c = $_POST['text']; $date = date("Y-m-d"); $id_v=$id; if (text_c != '' ) { $sql = "INSERT INTO Comments(id_c, text_c, date_c, name_c, is_flag_c, like_c, is_show_c, id_vendor_c) VALUES('','$text_c','$date','$name_user','0','0','1','$id_v')"; mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error()); } 
		
		$query5="SELECT text_c, name_c, date_c,id_c, like_c FROM Comments where id_vendor_c='$id' and is_show_c='1' order by like_c DESC, date_c DESC"; 
		 $result = mysql_query($query5);
		  while($row = mysql_fetch_row($result)){ 
		  	if ($i<6) { 
		  	$id2=$row[3]; 
		  	$like=$row[4];
		  	$comments=$row[0]; 
		  	$comments = nl2br($comments); 
		  	$name=$row[1]; $datetmp=$row[2]; 
		  	$date =date("d F Y", strtotime($datetmp)); ?>
		<p><form method="post" action="">
		" <?php echo $comments ; ?> "
		<br><span> by <?php echo $name ; echo ', ' .$date; ?> </span>
		<p id="place_comments">
<? if ($like=='0') { echo '0 person like this comment';}
			else { echo $like.' people like this comment -';} 
		  

		//$queryfb = mysql_query("UPDATE Comments set like_c=$nb where id_c=$id2 "); ?>
		<input type="submit" name="Like" value="Like">
		<input type="submit" name="Flag" value="Flag" onclick="window.alert('This comment has been flagged and the administrators will review shortly');"> <br>


<div class="target">
<p id="place_comments">Click to add a comment</p>
</div>
<div class="plop" style="display:none;"> 
<p id="place_comments"><textarea rows="2" cols="25" name="text_s" class="textarea_small"/></textarea>
<input type="submit" value="Post" name="add_sub" />
<input name="id_subcomment" type="hidden" value="<?php
 echo $id2?>" /></p>
</div>

		 </p>
		 </form>

		<?php $query6="SELECT text_subc, name_subc, date_subc FROM Subcomments where id_subc_c='$id2' order by date_subc DESC"; $result2 = mysql_query($query6); while($row2 = mysql_fetch_row($result2)){ $subcomments=$row2[0]; $subcomments = nl2br($subcomments); $name_sub=$row2[1]; $datetmp2=$row2[2]; $date_sub =date("d F Y", strtotime($datetmp2)); ?><p id="place_comments"> <?php echo $subcomments ; echo '<br>by '.$name_sub ; echo ', ' .$date_sub; ?></p> <?php } $i++; }} ?>

<script type="text/javascript">
$(document).ready(function() {
//on masque les textarea (c mieux de mettre display:none; dans la classe css .plop)
$('.plop').hide();
//la liste des div#target
var buttons = $('.target');
//Tous les div#target comme un bouton par css
buttons.css('cursor', 'pointer');
buttons.toggle(function(){
$(this).next('.plop').eq(0).slideDown(); 
}, function() {
$(this).next('.plop').eq(0).slideUp(); 
});
});
</script>
<? } 
		
		
		else if (!empty($_POST['add_sub'])) { ?>
		 <!--  add new comments -->
		 	
		 <form method="post" action="/vendor_page.php?a=body_comment/<? echo $vendor_name; ?>" name="add_com">
	 <div class="target2">Tell us what you think about this vendor </div>
	 <div class="plop2" style="display:none;"> 
	 <textarea rows="2" cols="60" name="text" class="textareacom" ></textarea>
		
		  <input type="submit" value="Post" name="add_comment" /></p>
		  </div>
		 
		 </form>
<div id="scrollingComments">
		<?php 
		$i=0; 
		$name_s = $_POST['name_s']; 
				$text_s = $_POST['text_s']; 
		$date_s = date("Y-m-d"); 
		$id_s=$_POST['id_subcomment']; 
			if ($text_s != '') { 
			$sql = "INSERT INTO Subcomments(id_subc, text_subc, date_subc, name_subc, is_flag_s, id_subc_c) VALUES('','$text_s','$date_s','$name_user','0','$id_s')"; 
			mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error()); }
		 $query5="SELECT text_c, name_c, date_c,id_c, like_c FROM Comments where id_vendor_c='$id' and is_show_c='1' order by like_c DESC, date_c DESC"; 
		 $result = mysql_query($query5);
		  while($row = mysql_fetch_row($result)){ 
		  	if ($i<6) { 
		  	$id2=$row[3]; 
		  	$like=$row[4];
		  	$comments=$row[0]; 
		  	$comments = nl2br($comments); 
		  	$name=$row[1]; $datetmp=$row[2]; 
		  	$date =date("d F Y", strtotime($datetmp)); ?>
		<p><form method="post" action="">
		" <?php echo $comments ; ?> "
		<br><span> by <?php echo $name ; echo ', ' .$date; ?> </span>
		<p id="place_comments">
<? if ($like=='0') { echo '0 person like this comment';}
			else { echo $like.' people like this comment -';} 
		  

		//$queryfb = mysql_query("UPDATE Comments set like_c=$nb where id_c=$id2 "); ?>
		<input type="submit" name="Like" value="Like">
		<input type="submit" name="Flag" value="Flag" onclick="window.alert('This comment has been flagged and the administrators will review shortly');"> <br>


<div class="target">
<p id="place_comments">Click to add a comment</p>
</div>
<div class="plop" style="display:none;"> 
<p id="place_comments"><textarea rows="2" cols="25" name="text_s" class="textarea_small"/></textarea>
<input type="submit" value="Post" name="add_sub" />
<input name="id_subcomment" type="hidden" value="<?php
 echo $id2?>" /></p>
</div>
		 </p>
		 </form>

		<?php $query6="SELECT text_subc, name_subc, date_subc FROM Subcomments where id_subc_c='$id2' order by date_subc DESC"; $result2 = mysql_query($query6); while($row2 = mysql_fetch_row($result2)){ $subcomments=$row2[0]; $subcomments = nl2br($subcomments); $name_sub=$row2[1]; $datetmp2=$row2[2]; $date_sub =date("d F Y", strtotime($datetmp2)); ?><p id="place_comments"> <?php echo $subcomments ; echo '<br>by '.$name_sub ; echo ', ' .$date_sub; ?></p> <?php } $i++; }} ?>
<script type="text/javascript">
$(document).ready(function() {
//on masque les textarea (c mieux de mettre display:none; dans la classe css .plop)
$('.plop').hide();
//la liste des div#target
var buttons = $('.target');
//Tous les div#target comme un bouton par css
buttons.css('cursor', 'pointer');
buttons.toggle(function(){
$(this).next('.plop').eq(0).slideDown(); 
}, function() {
$(this).next('.plop').eq(0).slideUp(); 
});
});

$(document).ready(function() {
//on masque les textarea (c mieux de mettre display:none; dans la classe css .plop)
$('.plop2').hide();
//la liste des div#target
var buttons = $('.target2');
//Tous les div#target comme un bouton par css
buttons.css('cursor', 'pointer');
buttons.toggle(function(){
$(this).next('.plop2').eq(0).slideDown(); 
}, function() {
$(this).next('.plop2').eq(0).slideUp(); 
});
});

</script>
<?
		  } 
			  
			  
		
else if (!empty($_POST['Like'])) { 
$idlike= $_POST['id_subcomment'];
$querynb="SELECT like_c FROM Comments where id_c='$idlike' "; 
$result = mysql_query($querynb); 
while ($row = mysql_fetch_assoc($result)) {
$resultnb= $row["like_c"]; }
$nb=$resultnb+1;

$sql = "UPDATE Comments set like_c =$nb where id_c=$idlike ";
mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());
?>

	
		 <form method="post" action="/vendor_page.php?a=body_comment/<? echo $vendor_name; ?>" name="add_com">
	 <div class="target2">Tell us what you think about this vendor </div>
	 <div class="plop2" style="display:none;"> 
	 <textarea rows="2" cols="60" name="text" class="textareacom" ></textarea>
		
		  <input type="submit" value="Post" name="add_comment" /></p>
		  </div>
		 
		 </form>

<div id="scrollingComments">
<?php $i=0; 
$query5="SELECT text_c, name_c, date_c,id_c, like_c FROM Comments where id_vendor_c='$id' and is_show_c='1' order by like_c DESC, date_c DESC"; 
$result = mysql_query($query5);
while($row = mysql_fetch_row($result)){ 
if ($i<6) { 
$id2=$row[3]; 
$like=$row[4];
$comments=$row[0]; 
$comments = nl2br($comments); 
$name=$row[1]; $datetmp=$row[2]; 
$date =date("d F Y", strtotime($datetmp)); ?>
<p><form method="post" action="/vendor_page.php?a=body_comment/<? echo $vendor_name; ?>">
<?php echo $comments ; ?> "
<br><span> by <?php echo $name ; echo ', ' .$date; ?> </span>
<p id="place_comments">
<? if ($like=='0') { echo '0 person like this comment';}
else { echo $like.' people like this comment -';} 


//$queryfb = mysql_query("UPDATE Comments set like_c=$nb where id_c=$id2 "); ?>
<input type="submit" name="Like" value="Like">
<input type="submit" name="Flag" value="Flag"onclick="window.alert('This comment has been flagged and the administrators will review shortly');"> <br>


<div class="target">
<p id="place_comments">Click to add a comment</p>
</div>
<div class="plop" style="display:none;"> 
<p id="place_comments"><textarea rows="2" cols="25" name="text_s" class="textarea_small"/></textarea>
<input type="submit" value="Post" name="add_sub" />
<input name="id_subcomment" type="hidden" value="<?php
 echo $id2?>" /></p>
</div>

</p>
</form>

<?php $query6="SELECT text_subc, name_subc, date_subc FROM Subcomments where id_subc_c='$id2' order by date_subc DESC"; $result2 = mysql_query($query6); while($row2 = mysql_fetch_row($result2)){ $subcomments=$row2[0]; $subcomments = nl2br($subcomments); $name_sub=$row2[1]; $datetmp2=$row2[2]; $date_sub =date("d F Y", strtotime($datetmp2)); ?><p id="place_comments"> <?php echo $subcomments ; echo '<br>by '.$name_sub ; echo ', ' .$date_sub; ?></p> <?php } $i++; }} ?>
<script type="text/javascript">
$(document).ready(function() {
//on masque les textarea (c mieux de mettre display:none; dans la classe css .plop)
$('.plop').hide();
//la liste des div#target
var buttons = $('.target');
//Tous les div#target comme un bouton par css
buttons.css('cursor', 'pointer');
buttons.toggle(function(){
$(this).next('.plop').eq(0).slideDown(); 
}, function() {
$(this).next('.plop').eq(0).slideUp(); 
});
});

$(document).ready(function() {
//on masque les textarea (c mieux de mettre display:none; dans la classe css .plop)
$('.plop2').hide();
//la liste des div#target
var buttons = $('.target2');
//Tous les div#target comme un bouton par css
buttons.css('cursor', 'pointer');
buttons.toggle(function(){
$(this).next('.plop2').eq(0).slideDown(); 
}, function() {
$(this).next('.plop2').eq(0).slideUp(); 
});
});

</script>
<?
} 

		 
else if (!empty($_POST['Flag'])) { 
			 $idlike= $_POST['id_subcomment'];
			 $sql = "UPDATE Comments set is_flag_c ='1' where id_c=$idlike "; 
			 mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error()); 			 
		 ?>
			 	
			
		 <form method="post" action="/vendor_page.php?a=body_comment/<? echo $vendor_name; ?>" name="add_com">
	 <div class="target2">Tell us what you think about this vendor </div>
	 <div class="plop2" style="display:none;"> 
	 <textarea rows="2" cols="60" name="text" class="textareacom" ></textarea>
		
		  <input type="submit" value="Post" name="add_comment" /></p>
		  </div>
		 
		 </form>
	
		 <form method="post" action="/vendor_page.php?a=body_comment/<? echo $vendor_name; ?>" name="add_com">
	 <div class="target2">Tell us what you think about this vendor </div>
	 <div class="plop2" style="display:none;"> 
	 <textarea rows="2" cols="60" name="text" class="textareacom" ></textarea>
		
		  <input type="submit" value="Post" name="add_comment" /></p>
		  </div>
		 
		 </form>

		 <div id="scrollingComments">
		 <?php $i=0; 
		 $query5="SELECT text_c, name_c, date_c,id_c, like_c FROM Comments where id_vendor_c='$id' and is_show_c='1' order by like_c DESC, date_c DESC"; 
		 $result = mysql_query($query5);
		  while($row = mysql_fetch_row($result)){ 
		  	if ($i<6) { 
		  	$id2=$row[3]; 
		  	$like=$row[4];
		  	$comments=$row[0]; 
		  	$comments = nl2br($comments); 
		  	$name=$row[1]; $datetmp=$row[2]; 
		  	$date =date("d F Y", strtotime($datetmp)); ?>
		<p><form method="post" action="/vendor_page.php?a=body_comment/<? echo $vendor_name; ?>">
		 <?php echo $comments ; ?> "
		<br><span> by <?php echo $name ; echo ', ' .$date; ?> </span>
		<p id="place_comments">
	<? if ($like=='0') { echo '0 person like this comment';}
			else { echo $like.' people like this comment -';} 
		  

		//$queryfb = mysql_query("UPDATE Comments set like_c=$nb where id_c=$id2 "); ?>
		<input type="submit" name="Like" value="Like">
		<input type="submit" name="Flag" value="Flag" onclick="window.alert('This comment has been flagged and the administrators will review shortly');">
	
<div class="target">
<p id="place_comments">Click to add a comment</p>
</div>
<div class="plop" style="display:none;"> 
<p id="place_comments"><textarea rows="2" cols="25" name="text_s" class="textarea_small"/></textarea>
<input type="submit" value="Post" name="add_sub" />
<input name="id_subcomment" type="hidden" value="<?php
 echo $id2?>" /></p>
</div>

		 </p>
		 </form>

		<?php $query6="SELECT text_subc, name_subc, date_subc FROM Subcomments where id_subc_c='$id2' order by date_subc DESC"; $result2 = mysql_query($query6); while($row2 = mysql_fetch_row($result2)){ $subcomments=$row2[0]; $subcomments = nl2br($subcomments); $name_sub=$row2[1]; $datetmp2=$row2[2]; $date_sub =date("d F Y", strtotime($datetmp2)); ?><p id="place_comments"> <?php echo $subcomments ; echo '<br>by '.$name_sub ; echo ', ' .$date_sub; ?></p> <?php } $i++; }} ?>
		
<script type="text/javascript">
$(document).ready(function() {
//on masque les textarea (c mieux de mettre display:none; dans la classe css .plop)
$('.plop').hide();
//la liste des div#target
var buttons = $('.target');
//Tous les div#target comme un bouton par css
buttons.css('cursor', 'pointer');
buttons.toggle(function(){
$(this).next('.plop').eq(0).slideDown(); 
}, function() {
$(this).next('.plop').eq(0).slideUp(); 
});
});

$(document).ready(function() {
//on masque les textarea (c mieux de mettre display:none; dans la classe css .plop)
$('.plop2').hide();
//la liste des div#target
var buttons = $('.target2');
//Tous les div#target comme un bouton par css
buttons.css('cursor', 'pointer');
buttons.toggle(function(){
$(this).next('.plop2').eq(0).slideDown(); 
}, function() {
$(this).next('.plop2').eq(0).slideUp(); 
});
});

</script>
<?		
		}		
		else  { ?>
 			
 			<!--  add new comments -->

 			
		 <form method="post" action="/vendor_page.php?a=body_comment/<? echo $vendor_name; ?>" name="add_com">
	 <div class="target2">Tell us what you think about this vendor </div>
	 <div class="plop2" style="display:none;"> 
	 <textarea rows="2" cols="60" name="text" class="textareacom" ></textarea>
		
		  <input type="submit" value="Post" name="add_comment" /></p>
		  </div>
		 
		 </form>
		 <div id="scrollingComments">
		 <?php $i=0; 
		 $query5="SELECT text_c, name_c, date_c,id_c, like_c FROM Comments where id_vendor_c='$id' and is_show_c='1' order by like_c DESC, date_c DESC"; 
		 $result = mysql_query($query5);
		  while($row = mysql_fetch_row($result)){ 
		  	if ($i<6) { 
		  	$id2=$row[3]; 
		  	$like=$row[4];
		  	$comments=$row[0]; 
		  	$comments = nl2br($comments); 
		  	$name=$row[1]; $datetmp=$row[2]; 
		  	$date =date("d F Y", strtotime($datetmp)); 
			$nb=$like+1; 
		  	?><p><form method="post" action="/vendor_page.php?a=body_comment/<? echo $vendor_name; ?>">
		 <?php echo $comments ; ?> "
		<br><span> by <?php echo $name ; echo ', ' .$date; ?> </span>
		<p id="place_comments">
		
	<? if ($like=='0') { echo '0 person like this comment';}
			else { echo $like.' people like this comment -';} ?>


		<?  //$queryfb = mysql_query("UPDATE Comments set like_c=$nb where id_c=$id2 "); ?>
<input type="submit" name="Like" value="Like" >

		 <input type="submit" name="Flag" value="Flag" onclick="window.alert('This comment has been flagged and the administrators will review shortly');">  

		
<div class="target">
<p id="place_comments">Click to add a comment</p>
</div>
<div class="plop" style="display:none;"> 
<p id="place_comments"><textarea rows="2" cols="25" name="text_s" class="textarea_small"/></textarea>
<input type="submit" value="Post" name="add_sub" />
<input name="id_subcomment" type="hidden" value="<?php
 echo $id2?>" /></p>
</div>
		 </p>
		 </form>
		<?php $query6="SELECT text_subc, name_subc, date_subc FROM Subcomments where id_subc_c='$id2' order by date_subc DESC"; $result2 = mysql_query($query6); while($row2 = mysql_fetch_row($result2)){ $subcomments=$row2[0]; $subcomments = nl2br($subcomments); $name_sub=$row2[1]; $datetmp2=$row2[2]; $date_sub =date("d F Y", strtotime($datetmp2)); ?><p id="place_comments"> <?php echo $subcomments ; echo '<br>by '.$name_sub ; echo ', ' .$date_sub; ?></p> <?php } $i++; }} ?>

<?
$term=$vendor_name;
$city='San%20Francisco';
$key='ECTSqNkhpqXXb1J4-wT_fA';
$urlyelp = "http://api.yelp.com/business_review_search?term=$term&location=$city%2A%20CA&ywsid=$key";

$yelpstring = file_get_contents("http://api.yelp.com/business_review_search?term=$term&location=$city%2A%20CA&ywsid=$key", true);
$response = json_decode($yelpstring);

$count = $response->businesses[0]->review_count;
$avg = $response->businesses[0]->avg_rating;
$star= $response->businesses[0]->rating_img_url;
$linkyelp= $response->businesses[0]->url;

?>
<img src="http://media1.ak.yelpcdn.com/static/201012162808060929/img/developers/reviewsFromYelpBLK.gif"><br>
<? echo $count?> reviews<br>
<img src=<? echo $star ?>>  <br>
<a href =<? echo $linkyelp ?> target=_blank >See reviews on Yelp !</a>


<script type="text/javascript">
$(document).ready(function() {
//on masque les textarea (c mieux de mettre display:none; dans la classe css .plop)
$('.plop').hide();
//la liste des div#target
var buttons = $('.target');
//Tous les div#target comme un bouton par css
buttons.css('cursor', 'pointer');
buttons.toggle(function(){
$(this).next('.plop').eq(0).slideDown(); 
}, function() {
$(this).next('.plop').eq(0).slideUp(); 
});
});

$(document).ready(function() {
//on masque les textarea (c mieux de mettre display:none; dans la classe css .plop)
$('.plop2').hide();
//la liste des div#target
var buttons = $('.target2');
//Tous les div#target comme un bouton par css
buttons.css('cursor', 'pointer');
buttons.toggle(function(){
$(this).next('.plop2').eq(0).slideDown(); 
}, function() {
$(this).next('.plop2').eq(0).slideUp(); 
});
});


</script>

	<?php } ?></div>
		</p>
	</div>

<div id="events" class="content_bubble_<? echo $position ?>">
		<h3>Events</h3><br>
<?
$queryevent="SELECT text_e, datecreation_e FROM events where id_vendor_e='$id' order by datecreation_e DESC"; 
		 $result = mysql_query($queryevent);
		  while($row = mysql_fetch_row($result)){ 
		  	echo $row[0]; 	?>		<br> <? } ?>
</div>

	<div id="spacer" style="padding-bottom: 12px; float: right; clear: both;">&nbsp;</div>

<? include  __DIR__.'/footer.php'; ?>
</body></html>
