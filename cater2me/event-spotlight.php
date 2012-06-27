<?
require 'lib/core.php';

$template = array(
	'title' => 'Cater2.me | Food Event in San Francisco',
	'menu_selected' => 'event-spotlight',
	'breadcrumb' => array('Home'=>'/', 'Event spotlight'=>'/event-spotlight/'),
	'meta_name' => "Looking for great food events in SF? Check out our calendar for cooking classes, pop-ups, farmers' markets and other foodie events!",
	'grey_bar' => 'Event calendar',
	'slider_open' => true
	);

require 'header.php';


$areas=array();
$res = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "event_spotlight_%"');
while($log = mysql_fetch_assoc($res)) {
	$areas[$log['label']]=$log['value'];
}

?>

<div class="grid_8">
	<div class="grid_8 alpha omega">
		<p>
		<?=plain2Html($areas['event_spotlight_top'])?>
		</p>
	</div>
	<div class="grid_8 alpha omega">
		<h2><?=plain2Html($areas['event_spotlight_title'])?></h2>
		<p>
		<?=plain2Html($areas['event_spotlight_highlights'])?>
		</p>
	</div>
	<div class="grid_4 alpha">
		<h2>Links</h2>
		<p>
		<?=plain2Html($areas['event_spotlight_links'])?>
		</p>
	</div>
	<div class="grid_4 omega">
		<h2>Get involved!</h2>
		<p>
		<?=plain2Html($areas['event_spotlight_involved'])?>
		</p>
	</div>
</div>
<div class="grid_4" >
	<div style="padding-left:45px">
		<h2>Follow us @C2meSF!</h2>

		<?
		$areas=array();
		$res = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "twitter_%"');
		while($log = mysql_fetch_assoc($res)) {
			$areas[$log['label']]=$log['value'];
		}
		?>

		<?=$areas['twitter_widget'];?>

	</div>
</div>


<div class="grid_12">
<iframe src="https://www.google.com/calendar/b/0/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=cater2.me_85u3scdjn784k6gmmhjfp5dl9k%40group.calendar.google.com&amp;color=%23125A12&amp;src=cater2.me_k1etnifi1b9mpaq2rnt5uu3g5s%40group.calendar.google.com&amp;color=%235229A3&amp;src=cater2.me_j6k0stodc1pu5sllufgd0js364%40group.calendar.google.com&amp;color=%23705770&amp;src=cater2.me_t20aatuhpcb8ld4jd9l0j6rqe8%40group.calendar.google.com&amp;color=%23AB8B00&amp;src=cater2.me_cvbe9es2mcp7j2lqbs1e157lt0%40group.calendar.google.com&amp;color=%2329527A&amp;src=cater2.me_akkka3knh9mp2ccgtlspneqnjc%40group.calendar.google.com&amp;color=%23A32929&amp;ctz=America%2FLos_Angeles" style=" border-width:0 " width="100%" height="600" frameborder="0" scrolling="no"></iframe>
<!-- old cal <iframe src="https://www.google.com/calendar/b/0/embed?showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;src=cater2.me_b0m934mhp7m3926b29cpl2985g%40group.calendar.google.com&amp;color=%23711616&amp;ctz=America%2FLos_Angeles" style="border-width:0; margin-bottom:30px" width="100%" height="600" frameborder="0" scrolling="no"></iframe>-->
</div>

<div class="grid_12 legend_gcal">
	<div style="background-color:#3c995b">Educational</div>
	<div style="background-color:#8c66d9">Evenings Out</div>
	<div style="background-color:#a992a9">Festivals</div>
	<div style="background-color:#e0c240">Markets</div>
	<div style="background-color:#d96666">Pop-ups</div>
</div>


<div class="grid_12">
<h2>Blog posts</h2>
</div>



		<?
		$res = mysql_query('SELECT * FROM website_blog_posts ORDER BY id_blog_post DESC');
		while($log = mysql_fetch_assoc($res)) {
		?>
		<div id="homeu-blogu" class="grid_12">

			<h3><?=plain2Html($log['title'])?></h3>
		
			<div class="grid_2 alpha image-fade">
				<img src="/template/images/custom/blog_posts/<?=$log['id_blog_post']?>.jpg" alt="" />
			</div>
			
			<div class="home-post-content grid_10 omega">
			<p> <?=plain2Html($log['content'])?></p>
			</div>
		
		</div> <!-- end #home-blog .grid_9 -->
		<?
		}
		?>

<?

require 'footer.php';
