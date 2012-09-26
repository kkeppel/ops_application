</script>
			
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-21295926-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	  
	  
	</script>
<form action="form_action.asp">
First name: <input type="text" name="FirstName" value="Mickey" /><br />
Last name: <input type="text" name="LastName" value="Mouse" /><br />
Hidden: <input type="hidden" name="LastName" value="<? require("class.gaparse.php");

$aux = new GA_Parse($_COOKIE);
 
echo $aux->campaign_name; ?>" /><br />
<input type="submit" value="Submit" />
</form>