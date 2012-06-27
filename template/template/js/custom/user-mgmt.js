function resetPassword(idUser) {
	var pwd="";
	pwd = prompt("Enter new password (no notification will be sent out):");
	
	if(pwd!="" && pwd!=false && pwd!=null)
	{
		Ajax(document.URL,"action=resetPwd&id="+idUser+"&pwd="+pwd,"resetPassword2");
	}
}

function resetPassword2(source) {
	if(source=="ok")
	{
		
	}
	else
	{
		alert("Sorry, an error has occurred.");
	}
}



function toggleAccountStatus(idUser) {
	if(getID("usrAccountStatus"+idUser).src.indexOf("deactivated") > 1) // current icon state = deactivated
	{
		tmp="activate";
		getID("usrAccountStatus"+idUser).src = "/template/images/custom/user_activated.png";
		getID("usrAccountStatus"+idUser).title = "deactivate account";
	}
	else
	{
		tmp="deactivate";
		getID("usrAccountStatus"+idUser).src = "/template/images/custom/user_deactivated.png";
		getID("usrAccountStatus"+idUser).title = "activate account";
	}
	
	Ajax(document.URL,"action="+tmp+"&id="+idUser,"toggleAccountStatus2");
}

function toggleAccountStatus2(source) {
	if(source=="ok")
	{
		
	}
	else
	{
		alert("Sorry, an error has occurred.");
	}
}



function userEdit(idUser) {

	if(getID("usrEdit"+idUser).src.indexOf("user_edit") > 1) // current icon state = edit
	{
		getID("usrUsername"+idUser).innerHTML = '<input type="text" id="usrTxtUsername'+idUser+'" value="'+getID("usrUsername"+idUser).innerHTML+'">';
		getID("usrEmail"+idUser).innerHTML = '<input type="email" id="usrTxtEmail'+idUser+'" value="'+getID("usrEmail"+idUser).innerHTML+'">';
		getID("usrPersonalNumber"+idUser).innerHTML = '<input type="text" id="usrTxtPersonalNumber'+idUser+'" value="'+getID("usrPersonalNumber"+idUser).innerHTML+'">';
		getID("usrCarrier"+idUser).innerHTML = '<input type="text" id="usrTxtCarrier'+idUser+'" value="'+getID("usrCarrier"+idUser).innerHTML+'" size="7">';
		
		getID("usrEdit"+idUser).src = "/template/images/custom/user_apply_updates.png";
		getID("usrEdit"+idUser).title = "apply updates";
	}
	else //removes text fields and back to normal layout
	{
		getID("usrUsername"+idUser).innerHTML = getID("usrTxtUsername"+idUser).value;
		getID("usrEmail"+idUser).innerHTML = getID("usrTxtEmail"+idUser).value;
		getID("usrPersonalNumber"+idUser).innerHTML = getID("usrTxtPersonalNumber"+idUser).value;
		getID("usrCarrier"+idUser).innerHTML = getID("usrTxtCarrier"+idUser).value;
		
		getID("usrEdit"+idUser).src = "/template/images/custom/user_edit.png";
		getID("usrEdit"+idUser).title = "edit user";
		
		//send updates
		Ajax(document.URL,"action=usrEdit&id="+idUser+"&username="+escape(getID("usrUsername"+idUser).innerHTML)+"&email="+escape(getID("usrEmail"+idUser).innerHTML)+"&personal_number="+escape(getID("usrPersonalNumber"+idUser).innerHTML)+"&carrier="+escape(getID("usrCarrier"+idUser).innerHTML),"userEdit2");
	}
}

function userEdit2(source) {
	if(source=="ok")
	{
		
	}
	else
	{
		alert("Sorry, an error has occurred.");
	}
}


function loginAsUser(idUser) {
	Ajax(document.URL,"action=loginAs&id="+idUser,"loginAsUser2");
}

function loginAsUser2(source) {
	if(source=="ok")
	{
		alert("To go back to your Admin interface, please sign out and log back into your regular account.");
		document.location.href = "/dashboard/";
	}
	else
	{
		alert("Sorry, an error has occurred.");
	}
}


function toggleAccountType(select) {
	getID("trClients").style.display="none";
	
	switch(select.options[select.selectedIndex].value)
	{
		case "vendor":
		alert("Vendors cannot be added through this interface.");
		select.value="client";
		getID("trClients").style.display="";
		break;
		case "client":
		case "employee":
		getID("trClients").style.display="";
		break;
	}
}

