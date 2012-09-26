<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');
$message ='';

if($_SERVER['REQUEST_METHOD']=='POST')
{
$form=1;
$body =  'Thank you, we will contact you soon';
$headcount = $_POST['headcount'];
$bev  = $_POST['bev'];
if ($bev == 1) {$bevmail = 'yes';}  else {$bevmail = 'no';} 
$plate  = $_POST['plate'];
if ($plate == 1) {$platemail = 'yes';}  else {$platemail = 'no';} 
$nuts  = $_POST['nuts'];
$gluten  = $_POST['gluten'];
$dairy  = $_POST['dairy'];
$egg  = $_POST['egg'];
$soy  = $_POST['soy'];
$allerg_notes  = $_POST['allerg_notes'];
$street  = $_POST['street'];
$city  = $_POST['city'];
$zip  = $_POST['zip'];
$del_note  = $_POST['del_note'];
$phone  = $_POST['phone'];
$date1  = $_POST['date1'];
$payment = $_POST['payment'];
$budget  = $_POST['budget'];
$note  = $_POST['note'];


$hour1 = $_POST['hour1'];
$minute1 = $_POST['minute1'];
$day1 = $_POST['day1'];
$nbemp1 = $_POST['nbemp1'];
$nbveg1 = $_POST['nbveg1'];
$nbvegan1 = $_POST['nbvegan1'];
$cuisine1 = $_POST['cuisine1'];
$notes1 = $_POST['notes1'];

$monday1 = $_POST['monday1'];
if ($monday1  == 1){$mondmail1 = 'monday,';} else {$mondmail1 = '';}
$tuesday1 = $_POST['tuesday1'];
if ($tuesday1  == 1){$tuemail1 = 'tuesday,';}else {$tuemail1 = '';}
$wednesday1 = $_POST['wednesday1'];
if ($wednesday1  == 1){$wedmail1 = 'wednesday,';} else {$wedmail1 = '';}
$thursday1 = $_POST['thursday1'];
if ($thursday1  == 1){$thumail1 = 'thursday,';}else {$thumail1 = '';}
$friday1 = $_POST['friday1'];
if ($friday1  == 1){$fridmail1 = 'friday,';}else {$fridmail1 = '';}
$saturday1 = $_POST['saturday1'];
if ($saturday1  == 1){$satmail1 = 'saturday,';}else {$satmail1 = '';}
$sunday1 = $_POST['sunday1'];
if ($sunday1  == 1){$sunmail1 = 'sunday';}else {$mondmail1 = '';}
$daymail1 =  $mondmail1.$tuemail1.$wedmail1.$thumail1.$fridmail1.$satmail1.$mondmail1;
$beef1 = $_POST['beef1'];
if ($beef1  == 1){$beefmail1 = 'beef,';} else {$beefmail1 = '';}
$pork1 = $_POST['pork1'];
if ($pork1  == 1){$porkmail1 = 'pork,';} else {$porkmail1 = '';}
$chicken1 = $_POST['chicken1'];
if ($chicken1  == 1){$chickenmail1 = 'chicken,';} else {$chickenmail1 = '';}
$turkey1 = $_POST['turkey1'];
if ($turkey1  == 1){$turkeymail1 = 'turkey,';} else {$turkeymail1 = '';}
$fish1 = $_POST['fish1'];
if ($fish1  == 1){$fishmail1 = 'fish,';} else {$fishmail1 = '';}
$lamb1 = $_POST['lamb1'];
if ($lamb1  == 1){$lambmail1 = 'lamb,';} else {$lambmail1 = '';}
$tofu1 = $_POST['tofu1'];
if ($tofu1  == 1){$tofumail1 = 'tofu,';} else {$tofumail1 = '';}
$prefmail1 =  $beefmail1.$porkmail1.$chickenmail1.$turkeymail1.$fishmail1.$lambmail1.$tofumail1;

$hour2 = $_POST['hour2'];
$minute2 = $_POST['minute2'];
$day2 = $_POST['day2'];
$nbemp2 = $_POST['nbemp2'];
$nbveg2 = $_POST['nbveg2'];
$nbvegan2 = $_POST['nbvegan2'];
$cuisine2 = $_POST['cuisine2'];

$monday2 = $_POST['monday2'];
if ($monday2  == 1){$mondmail2 = 'monday,';} else {$mondmail2 = '';}
$tuesday2 = $_POST['tuesday2'];
if ($tuesday2  == 1){$tuemail2 = 'tuesday,';}else {$tuemail2 = '';}
$wednesday2 = $_POST['wednesday2'];
if ($wednesday2  == 1){$wedmail2 = 'wednesday,';} else {$wedmail2 = '';}
$thursday2 = $_POST['thursday2'];
if ($thursday2  == 1){$thumail2 = 'thursday,';}else {$thumail2 = '';}
$friday2 = $_POST['friday2'];
if ($friday2  == 1){$fridmail2 = 'friday,';}else {$fridmail2 = '';}
$saturday2 = $_POST['saturday2'];
if ($saturday2  == 1){$satmail2 = 'saturday,';}else {$satmail2 = '';}
$sunday2 = $_POST['sunday2'];
if ($sunday2  == 1){$sunmail12 = 'sunday';}else {$mondmail2 = '';}
$daymail2 =  $mondmail2.$tuemail2.$wedmail2.$thumail2.$fridmail2.$satmail2.$mondmail2;
$beef2 = $_POST['beef2'];
if ($beef2  == 1){$beefmail2 = 'beef,';} else {$beefmail2 = '';}
$pork2 = $_POST['pork2'];
if ($pork2  == 1){$porkmail2 = 'pork,';} else {$porkmail2 = '';}
$chicken2 = $_POST['chicken2'];
if ($chicken2  == 1){$chickenmail2 = 'chicken,';} else {$chickenmail2 = '';}
$turkey2 = $_POST['turkey2'];
if ($turkey2  == 1){$turkeymail2 = 'turkey,';} else {$turkeymail2 = '';}
$fish2 = $_POST['fish2'];
if ($fish2  == 1){$fishmail2 = 'fish,';} else {$fishmail2 = '';}
$lamb2 = $_POST['lamb2'];
if ($lamb2  == 1){$lambmail2 = 'lamb,';} else {$lambmail2 = '';}
$tofu2 = $_POST['tofu2'];
if ($tofu2  == 1){$tofumail2 = 'tofu,';} else {$tofumail2 = '';}
$prefmail2 =  $beefmail2.$porkmail2.$chickenmail2.$turkeymail2.$fishmail2.$lambmail2.$tofumail2;

 
$date = date("Y-m-d H:i:s");

//  AJOUT ALLERGIS DAN QUELLE TABLE

$sql = "INSERT INTO SignupInfo_tmp(`id_signupInfo`, `headcount_tot`, `street`, `city`, `zip`, `del_notes`, `phone`, `plate`,  `beverage`, `nuts`, `gluten`, `dairy`, `egg`, `soy`, `allerg_notes`, `date_begin`, `budget`, `payment`, `notes`,`signup_company_id`, date_signup) VALUES ('','$headcount','$street','$city','$zip','$del_note','$phone','$plate','$bev','$nuts','$gluten','$dairy','$egg','$soy','$allerg_notes','$date1','$budget','$payment','$note','1111','$date')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	

$res = mysql_query("SELECT Max(`id_signupInfo`)as id_signupInfo FROM SignupInfo_tmp");
$infotmp = mysql_fetch_assoc($res);
$id= $infotmp['id_signupInfo'];


$sql2 = "INSERT INTO `SignupMeal_tmp`(`id_meal`, `nb_meal`, `hour`, `min`, `period`, `nb_emp`, `nb_veg`, `nb_vegan`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `beef`, `pork`, `chicken`, `turkey`, `fish`, `lamb`, `tofu`, `cuisine`, `notes`, `id_signupinfo`)  VALUES ('','1','$hour1','$minute1','$day1','$nbemp1','$nbveg1','$nbvegan1','$monday1','$tuesday1','$wednesday1','$thursday1','$friday1','$saturday1','$sunday1','$beef1','$pork1','$chicken1','$turkey1','$fish1','$lamb1','$tofu1','$cuisine1','$notes1','$id')";
mysql_query($sql2) or die('SQL error !'.$sql2.'<br>'.mysql_error());	

if($nbemp2>0)
{
$sql3 = "INSERT INTO `SignupMeal_tmp`(`id_meal`, `nb_meal`, `hour`, `min`, `period`, `nb_emp`, `nb_veg`, `nb_vegan`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `beef`, `pork`, `chicken`, `turkey`, `fish`, `lamb`, `tofu`, `cuisine`, `notes`, `id_signupinfo`)  VALUES ('','2','$hour2','$minute2','$day1','$nbemp2','$nbveg2','$nbvegan2','$monday2','$tuesday2','$wednesday2','$thursday2','$friday2','$saturday2','$sunday2','$beef2','$pork2','$chicken2','$turkey2','$fish2','$lamb2','$tofu2','$cuisine2','$notes2','$id')";
mysql_query($sql3) or die('SQL error !'.$sql3.'<br>'.mysql_error());	
}


$body2='<h3>Address</h3><br />
Street: '.$street.'<br />
City: '.$city.'<br />
Zip code: '.$zip.'<br />
Delivey notes: '.$del_note.'<br />
Phone Number: '.$phone.'<br />
<br />

<h3>Informations</h3><br />
Number of employee: '.$headcount.'<br />
Nuts Allergy: '.$nuts.'<br />
Dairy Allergy: '.$dairy.'<br />
Egg Allergy: '.$egg.'<br />
Soy Allergy: '.$soy.'<br />
Allergens notes: '.$allerg_notes.'<br />
Date to begin: '.$date1.'<br />
Beverages: '.$bevmail.'<br />
Plates/Utensils: '.$platemail.'<br />
Budget ($/person): '.$budget.'<br />
Payment preferences: '.$payment.'<br />
Notes: '.$note.'<br />
';
$body2.='<h3>Meal Type 1</h3><br />
Time: '.$hour1.':'.$minute1.' '.$day1.'<br />
Day: '.$daymail1.'<br />
Nb employees: '.$nbemp1.'<br />
Nb vegetarians: '.$nbveg1.'<br />
Nb Vegan: '.$nbvegan1.'<br />
Meat preferences: '.prefmail1.'<br />
Cuisine preference: '.$cuisine1.'<br />
Notes: '.$notes1.'<br />
';
if ($nbemp2>0)
{
	$body2.='<h3>Meal Type 2</h3><br />
	Time: '.$hour2.':'.$minute2.' '.$day2.'<br />
	Day: '.$daymail2.'<br />
	Nb employees: '.$nbemp2.'<br />
	Nb vegetarians: '.$nbveg2.'<br />
	Nb Vegan: '.$nbvegan2.'<br />
	Meat preferences: '.prefmail2.'<br />
	Cuisine preference: '.$cuisine2.'<br />
	Notes: '.$notes2.'<br />';
}
	
sendMail('pauline@cater2.me','New client profile information - SF',$body2,true);		

}

?> 
<?
$template = array(
	'title' => 'Cater2.me | Manage betakitchen',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Signup Information '=>'/dashboard/signup_info/'),
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
		
			$(function()
		{
		var date1 = $("#date1").datepicker({ dateFormat: "yy-mm-dd" });
		$("#date1").datepicker();
		});
		
		function afficher(id)
		{
		document.getElementById(id).style.display="block";
		}
		
		</script>
		
		<style>
		
		table {
		border:0px;
		}
		td{
		vertical-align:middle;
		border:0px;}
		</style>
	',
	
	'grey_bar' => 'Getting started'
	);

require 'header.php';
?> 

<script type="text/javascript" charset="utf-8">


	function checkNb(text) {
		if (isNaN(text) ==true )
			return false;
		return true;
	}

	function checkSizeNb(text) {
		if (text.length > 5  )
			return false;
		return true;
	}
	function checkSizeNb2(text) {
		if (text.length > 15 )
			return false;
		return true;
	}

	function validate() {

		if(document.getElementById("street").value=="")
		{
		alert("Please enter your street address");
		return false;
		}
		if(document.getElementById("city").value=="")
		{
		alert("Please enter your city");
		return false;
		}
		if(!checkSizeNb2(document.getElementById("phone").value))
		{
		alert("Please indicate a valid phone number");
		return false;
		}
		if(document.getElementById("phone").value=="")
		{
		alert("Please enter your phone number");
		return false;
		}
		if(!checkSizeNb(document.getElementById("zip").value))
		{
		alert("Please enter a valid zip code");
		return false;
		}
		if(document.getElementById("zip").value=="")
		{
		alert("Please enter your zip code");
		return false;
		}

		return true;
	}
</script>

<?
if ($form==1){
 echo $body; }
 else { ?>
<form method="post" onsubmit="return validate();">
<div class="grid_7" id="contact-page">
<!-- <form method="post"> -->
<span style="font-size:16px " >Please complete this form to help us to plan your next meals!</span> <br><br>

<b>Let us know what are your meal types?</b><br><br>
<table id="tblUsers" class="tablesorter"> 
<tr> 
<td></td>
<td>Time</td>
<td>Day</td>
<td>Nb employees</td>
<td>Nb vegeterian</td>
<td>Nb vegan</td>
<td>Meat preferences</td>
<td>Cuisine preference </td>
<td>Notes</td>
</tr>
<tr>
<td>Meal 1</td>
<td><select name = "hour1">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
<option>11</option>
<option selected >12</option>
</select> 
<select name = "minute1">
<option>00</option>
<option>15</option>
<option>30</option>
<option>45</option>
</select>
<select name = "day1">
<option>AM</option>
<option>PM</option>
</select>
</td>
<td>
<input type="checkbox" name="monday1" value="1" /> monday<br>
<input type="checkbox" name="tuesday1" value="1" /> tuesday<br>
<input type="checkbox" name="wednesday1" value="1" /> wednesday<br>
<input type="checkbox" name="thursday1" value="1" /> thursday<br>
<input type="checkbox" name="friday1" value="1" /> friday<br>
<input type="checkbox" name="saturday1" value="1" /> saturday<br>
<input type="checkbox" name="sunday1" value="1" /> sunday<br>
<td><select name = "nbemp1">
<? for ($i=1; $i<=300; $i++) 
    {
     echo '<option value="'.$i.'">'.$i.'</option>';
    }?>
    </td>
<td> <select name = "nbveg1">
<? for ($i=0; $i<=50; $i++) 
    {
     echo '<option value="'.$i.'">'.$i.'</option>';
    }?>
</select></td>
<td> <select name = "nbvegan1">
<? for ($i=0; $i<=30; $i++) 
    {
     echo '<option value="'.$i.'">'.$i.'</option>';
    }?></select></td>
<td>
<input type="checkbox" name="beef1" value="1" /> beef<br>
<input type="checkbox" name="pork1" value="1" /> pork<br>
<input type="checkbox" name="chicken1" value="1" /> chicken<br>
<input type="checkbox" name="turkey1" value="1" /> turkey<br>
<input type="checkbox" name="fish1" value="1" /> fish<br>
<input type="checkbox" name="lamb1" value="1" /> lamb<br>
<input type="checkbox" name="tofu1" value="1" /> tofu<br>
</td>
<td><input type="text" name="cuisine1"/></td>
<td><textarea name="notes1" style="width:100%; height:40px"></textarea></td>

</tr>
</table>
&nbsp;&nbsp;&nbsp;<a href="#" onclick="afficher('meal2')">add another meal type</a><br><br>
<div id="meal2" style="display:none">
<table id="tblUsers" class="tablesorter"> 
<tr> 
<td></td>
<td>Time</td>
<td>Day</td>
<td>Nb employees</td>
<td>Nb vegeterian</td>
<td>Nb vegan</td>
<td>Meat preferences</td>
<td>Cuisine preference </td>
<td>Notes</td>
</tr>
<tr>
<td>Meal 2</td>
<td><select name = "hour2">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
<option>11</option>
<option selected>12</option>
</select> 
<select name = "minute2">
<option>00</option>
<option>15</option>
<option>30</option>
<option>45</option>
</select>
<select name = "day2">
<option>AM</option>
<option>PM</option>
</select>
</td>
<td>
<input type="checkbox" name="monday2" value="1" /> monday<br>
<input type="checkbox" name="tuesday2" value="1" /> tuesday<br>
<input type="checkbox" name="wednesday2" value="1" /> wednesday<br>
<input type="checkbox" name="thursday2" value="1" /> thursday<br>
<input type="checkbox" name="friday2" value="1" /> friday<br>
<input type="checkbox" name="saturday2" value="1" /> saturday<br>
<input type="checkbox" name="sunday2" value="1" /> sunday<br>
<td><select name = "nbemp2">
<? for ($i=0; $i<=300; $i++) 
    {
     echo '<option value="'.$i.'">'.$i.'</option>';
    }?>
    </td>
<td> <select name = "nbveg2">
<? for ($i=0; $i<=50; $i++) 
    {
     echo '<option value="'.$i.'">'.$i.'</option>';
    }?>
</select></td>
<td> <select name = "nbvegan2">
<? for ($i=0; $i<=30; $i++) 
    {
     echo '<option value="'.$i.'">'.$i.'</option>';
    }?></select></td>
<td>
<input type="checkbox" name="beef2" value="1" /> beef<br>
<input type="checkbox" name="pork2" value="1" /> pork<br>
<input type="checkbox" name="chicken2" value="1" /> chicken<br>
<input type="checkbox" name="turkey2" value="1" /> turkey<br>
<input type="checkbox" name="fish2" value="1" /> fish<br>
<input type="checkbox" name="lamb2" value="1" /> lamb<br>
<input type="checkbox" name="tofu2" value="1" /> tofu<br>
</td>
<td><input type="text" name="cuisine2"/></td>
<td><textarea name="notes2" style="width:100%; height:40px"></textarea></td>

</tr>
</table>
</div>


<table width="100%" id="tblUsers" class="tablesorter"> 

<tr> <td width="60%">
<b>Where are you located?<b></td><td></td></tr>
 <tr><td>Street</td> <td><input type="text" name="street" id="street" placeholder="street address"/></td></tr> 
  <tr><td>City</td> <td><input type="text" name="city" id="city" placeholder="city"/>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Zip Code&nbsp;&nbsp;&nbsp;<input type="text" name="zip" id="zip" placeholder="zip code"/></tr> 
   <tr><td>Delivery notes</td> <td><input type="text" name="del_note"  placeholder="i.e ..."/></td></tr> 
   <tr><td>Phone number</td> <td><input type="text" name="phone" id="phone" placeholder="i.e (555) 555-5555"/></td></tr> 
<tr><td> <br></td> <td><br></td></tr>
<tr><td><b>Informations</b></td></td></td></tr>

<tr><td>
How many employee in total? </td>
<td><select name = "headcount">

<? for ($i=1; $i<=300; $i++) 
    {
     echo '<option value="'.$i.'">'.$i.'</option>';
    }?></select></td></tr>
<tr> 
 <td> How many employees are allergic to :</td>
<td>
 <select name = "nuts">
<option>0</option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
</select> nuts&nbsp;&nbsp;&nbsp;
 <select name = "dairy">
<option>0</option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
</select> dairy &nbsp;&nbsp;&nbsp;
 <select name = "egg">
<option>0</option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
</select> egg&nbsp;&nbsp;&nbsp;
 <select name = "soy">
<option>0</option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
</select> soy&nbsp;&nbsp;&nbsp;
Allergens notes: <input type="text" name="allerg_notes"/>
</tr>
<tr> 
 <td> When do you want to begin? </td> <td><input type="text" id="date1" name="date1" placeholder="yy-mm-dd" value=""  /</td></tr> 
 <tr><td width="40%"> Do you have beverages? </td> 
 <td><input type="radio" name="bev" value="1" checked="checked" > yes
<input type="radio" name="bev" value="0"> no</td></tr> 
<tr> 
 <td> Do you have plates/utensils? </td> 
 <td><input type="radio" name="plate" value="1" checked="checked" > yes
<input type="radio" name="plate" value="0"> no</td></tr><tr> 
 <td> Your budget ($ / person) </td> <td> <select name="budget">
<option>10</option>
<option>11</option>
<option>12</option>
<option>13</option>
<option selected>14</option>
<option>15</option>
<option>16</option>
<option>17</option>
<option>18</option>
<option>19</option>
<option>20</option>
</select> </td></tr> 
<tr> 
 <td> Payment Preference </td> 
 <td><input type="radio" name="payment" value="check" checked="checked"> check
 &nbsp;&nbsp;&nbsp;<input type="radio" name="payment" value="visa"> visa
 &nbsp;&nbsp;&nbsp;<input type="radio" name="payment" value="visa"> mastercard
 &nbsp;&nbsp;&nbsp;<input type="radio" name="payment" value="visa"> american express</td></tr> 
<tr><td>Notes:</td>
<td><textarea name="note" style="width:100%; height:40px"></textarea>
</td></tr>
 <td></td><td><input type="submit" tabindex="4" name = "Send"  value="Send"  /></td></tr>

</table> 

</div>
</form>

<? }
require 'footer.php';

?>