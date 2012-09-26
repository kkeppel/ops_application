function Ajax(url, params, funcAX)
{	
	if(window.XMLHttpRequest)
	{
		var req = new XMLHttpRequest();
	}
	else if(window.ActiveXObject) { // IE
		try {
		var req = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
		try {
		var req = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {}
		}
	}
	if(!req) return false;
	
	req.onreadystatechange = function () {
	   if (req.readyState == 4) {
			//if(http_request.status == 200)
		   eval(funcAX+'(req.responseText)');
	   }
	};
	
    req.open('POST', url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.setRequestHeader("Content-length", params.length);
    req.setRequestHeader("Connection", "close");
    req.send(params);
}


function getID(id) {
	return document.getElementById(id);
}

var globalSignup=false;
function toggleGlobalSignup() {
	if(globalSignup) { // will close
		width=getID("parentGlobalSignup").offsetWidth;
		$("#globalSignup").animate({"left": (width-45)+"px"}, 1200,"easeOutBounce");
		globalSignup=false;
	} else { // will open
		$("#globalSignup").animate({"left": "0%"}, 900,"easeOutCubic");
		globalSignup=true;
	}
}
$(document).ready(function() {
	if(getID("parentGlobalSignup"))
	{
		  //init sign up panel
		  width=getID("parentGlobalSignup").offsetWidth;
		  getID("globalSignup").style.left=(width-45)+"px";
		  getID("globalSignup").style.visibility="visible";
		
		
		  $(window).resize(function() {
			if(globalSignup)
			{
			  getID("globalSignup").style.left="0%";
			  globalSignup=true;
			}
			else
			{
			  width=getID("parentGlobalSignup").offsetWidth;
			  getID("globalSignup").style.left=(width-45)+"px";
			  globalSignup=false;
			}
		});
	}
}
);


//if red slider exists
/*
if(getID("parentGlobalSignup"))
{
	$(window).resize(function() {
		if(globalSignup)
		{
		  width=getID("parentGlobalSignup").offsetWidth;
		  getID("globalSignup").style.left=(width-25)+"px";
		  globalSignup=false;
		}
		else
		{
		  getID("globalSignup").style.left="0%";
		  globalSignup=true;
		}
	});
}
*/


function checkEmail(email) {
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(email))
		return false;
	
	return true;
}




function sendSignup() {
	
	email = getID("signup_email").value;
	
	if(checkEmail(email)==true)
	{
		getID("signup_email").disabled=true;
		Ajax("/Signup-Email.php","signupEmail="+email,"sentSignup");
	}
	else
		alert("Please provide a valid e-mail address");
}

function sentSignup(source) {

	if(typeof var_index != "undefined")
		tmp="<div id='globalSignupThanks_big'>Thanks!</div>";
	else
		tmp="<div id='globalSignupThanks'>Thanks!</div>";
	
	getID("globalSignupRight").innerHTML = tmp;
	
	simpleModal("/Signup-Email.php",530,330);
}

function startIndexSliders() {
					jQuery('#slider').css({ display : 'block' });
						
					jQuery("#slider").slides({
						preload: true,
						preloadImage: '/template/images/slider/loading.gif',
						play: 0, //Auto play time. Set to 0 to stop auto rotate. 6000
						width: 960,
						pause: 4500,
						slideSpeed: 1000, //Slide rotation speed.
						generatePagination: true,
						hoverPause: true,
						autoHeight: true,
					});
					
					$(".pagination a").tipTip({delay:10,defaultPosition:"top",content:"<center><b><i>Click for more<i><b></center>"});
					
					setTimeout("toggleGlobalSignup()",1000);

}


function vendorConfirmEvent(id_order,hash) {
	Ajax("/dashboard/confirm/?oid="+id_order+"&hash="+hash+"&ajax=1","","vendorConfirmEvent2");
	
	$("#divLnkConfirm"+id_order).click(function() { 1; });
	getID("divLnkConfirm"+id_order).innerHTML="Thank you for confirming.";
}
function vendorConfirmEvent2(source) {
	if(source=="ok")
	{
	}
	else
	{
		alert("Sorry, an error has occurred.");
	}
}

function simpleModal(url, width, height)
{
	$.modal('<iframe src="'+url+'" height="'+height+'" width="'+width+'" style="border:0">', {
		closeClass: "modalClose",
		/*closeHTML:"",*/
		containerCss:{
			backgroundColor:"#222",
			borderColor:"#444",
			height:height,
			padding:0,
			width:width
		}
	});
}

function checkSignup() {

	if(document.f.username.value=="") {
		alert("Please pick a username");
		return false;
	}
	
	if(document.f.pwd.value=="") {
		alert("Please provide a password");
		return false;
	}
	if(document.f.pwd.value != document.f.pwd2.value) {
		alert("Passwords don't match!");
		return false;
	}
	
	if(document.f.first_name.value=="") {
		alert("Please provide your first name");
		return false;
	}
	if(document.f.last_name.value=="") {
		alert("Please provide your last name");
		return false;
	}
	
	
	return true;
}

function checkPwdRecovery() {

	if(document.f.pwd.value=="") {
		alert("Please provide a password");
		return false;
	}
	if(document.f.pwd.value != document.f.pwd2.value) {
		alert("Passwords don't match!");
		return false;
	}
	
	return true;
}

function nextTestimonial() {
	curTestimonial++;
	if(typeof testimonials[curTestimonial] == "undefined")
		curTestimonial=0;
	
	getID("testimonial_content").innerHTML=testimonials[curTestimonial]["content"];
	getID("testimonial_author").innerHTML=testimonials[curTestimonial]["author"];
	getID("testimonial_picture_img").src="/template/images/custom/testimonials/"+testimonials[curTestimonial]["id_testimonial"]+".png";
}
		
function checkEmailContact(email) {
	if(checkEmail(email)==false)
	{
		alert("Please enter a correct email address.");
		return false;
	}
	else
	{
		return true;
	}
}

function newsletterSignup() {
	simpleModal("/Newsletter-signup.php",530,340);
}


function feedbackPopup() {
	simpleModal("/feedb_popup.php",530,340);
}

function disclaimer() {
	simpleModal("/disclaimer.php",530,340);
}

