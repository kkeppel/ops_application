<?php $message='<a href="http://dev.cater2.me/unsign-newsletter.php?id=$donnees['id']">Se d�sinscrire</a>'; 
echo $message;
?>
 
<div style="background-color:#ddd">
<center>
<table border="0" cellspacing="0" cellpadding="0" width="605"> 
<tr><td width="605"><img src="http://cater2.me/template/images/custom/email/header.jpg" /></td></tr>
	<tr><td bgcolor="#880000" valign="middle" height="38" align="left">&nbsp;&nbsp;&nbsp;<font color="#ffffff"><b>{{newsletter_top_bar}}</b></font></td></tr>
<tr><td bgcolor="#ffffff" align="left">
<!-- mettre background	<table cellpadding="4"  background="http://cater2.me/upload/volare_pic.jpg"> -->
	<table cellpadding="4"  >
	<tr><td valign="top">
	
	<table border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td align="justify" colspan="2" valign="middle"  ><br /><font size="2" color="#000000">{{newsletter_top}}</font></td>
	</tr>
	<tr> 
		<td cellpadding='2px'  width="67%"  align="left"><font size="4" color="#000000">{{newsletter_title1}}</font></td>
		<td  align="left"><font size="4" color="#000000">{{newsletter_side_title}}</font></tr>
		
		
	
	<tr><td align="left" valign="top" ><font size="2" color="#000000">{{newsletter_body1}}<br /><br /></font></td>
	<td rowspan="3" valign="top">
	<font size="2" color="#000000">{{newsletter_side}}</font><br><br><br>
		<font size="4" color="#000000">{{newsletter_side_title2}}</font><br><br>
		<font size="2" color="#000000">{{newsletter_side2}}</font>
		</td>
	</tr>
	<tr><td align="left"><font size="4" align="left" color="#000000">{{newsletter_title2}}</font></td></tr>
	<tr><td align="left"><font size="2" color="#000000">{{newsletter_body2}}</font><br /><br /></td></tr>
	<tr><td align="left"><font size="2" align="left" color="#000000">{{newsletter_keys}}</font></td></tr>
	<tr><td align="left"><font size="4" align="left" color="#000000">{{newsletter_title3}}</font></td></tr>
	<tr><td align="left"><font size="2" color="#000000">{{newsletter_body3}}</font><br /><br /></td></tr>
	<tr><td align="left" valign="middle" style="border-top-style:solid;border-top-color:#eee;padding-bottom:20px"><font color="#000000" size="3">{{newsletter_bottom}}</font></td></tr> 
	
	<tr><td align="left" valign="middle" style="border-top-style:solid;border-top-color:#eee;padding-bottom:20px"><font color="#000000" size="3"><? echo $message ?></font></td></tr>
	


	</table>

	</td></tr>
	</table>
	
<table border="0" cellspacing="0" cellpadding="0" width="605">
<tr bgcolor="#880000" height="36"><font color="#ffffff" size="3">
<td align="center"> <a href="http://cater2.me/event-spotlight/"><font color="#ffffff" size="3">Events Page</font></a> </td> 
<td align="center"><font color="#ffffff" size="3">Follow us <a href="http://www.twitter.com/c2mesf">@C2meSF </font></a> </td> 
<td align="center"> <a href="http://cater2.me/referral_2.php/"><font color="#ffffff" size="3">Referrals </font></a></td> 

</tr>

</table>	
	
<!--
</td></tr>
<tr bgcolor="#880000" height="36"><font color="#ffffff" size="3">
<td colspan="2">
<table width="100%">
<tr><td  align="center"> <a href="http://cater2.me/event-spotlight/">Events Page</a> </td> 
 <td align="center" colspan="2"><font color="#ffffff" size="3"> Follow Us <a href="http://www.twitter.com/c2mesf" >@C2meSF </a>  </font>    </td>                    
 <td align="center" ><font color="#ffffff" size="3">Refferals</font>
</td></tr>
</table>
</tr>
-->



<!-- <tr><td bgcolor="#880000" height="36">&nbsp;&nbsp;<font color="#ffffff" size="2" valign="middle">{{newsletter_footer}}</font></td></tr> -->

</center>
</div>