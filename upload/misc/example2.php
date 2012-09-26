<form action="form_action.asp">
First name: <input type="text" name="FirstName" value="Mickey" /><br />
Last name: <input type="text" name="LastName" value="Mouse" /><br />
<? 
$mytest = 'Itworks'
?>
Hidden: <input type="hidden" name="LastName" value="<? echo $mytest ?>" /><br />
<input type="submit" value="Submit" />
</form>