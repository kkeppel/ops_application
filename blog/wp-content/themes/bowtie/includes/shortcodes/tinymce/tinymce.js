function init() {
	
	tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function jgshortcodesubmit() {
	
	var tagtext;
	
	var jg_shortcode = document.getElementById('jgshortcode_panel');
	
	
	// who is active ?
	if (jg_shortcode.className.indexOf('current') != -1) {
		var jg_shortcodeid = document.getElementById('jgshortcode_tag').value;
		switch(jg_shortcodeid)
{
case 0:
 	tinyMCEPopup.close();
  break;
  
case "highlight-yellow":
	tagtext = "["+ jg_shortcodeid + "]Content to highlight[/" + jg_shortcodeid + "]";
break;

case "highlight-red":
	tagtext = "["+ jg_shortcodeid + "]Content to highlight[/" + jg_shortcodeid + "]";
break;

case "highlight-green":
	tagtext = "["+ jg_shortcodeid + "]Content to highlight[/" + jg_shortcodeid + "]";
break;

case "highlight-blue":
	tagtext = "["+ jg_shortcodeid + "]Content to highlight[/" + jg_shortcodeid + "]";
break;

case "highlight-gray":
	tagtext = "["+ jg_shortcodeid + "]Content to highlight[/" + jg_shortcodeid + "]";
break;

case "highlight-black":
	tagtext = "["+ jg_shortcodeid + "]Content to highlight[/" + jg_shortcodeid + "]";
break;
  
case "horizontal-line":
	tagtext = "["+ jg_shortcodeid +"]";
break;

case "image-hover-with-tooltip":
	tagtext = "["+ jg_shortcodeid + " src=\"First image link goes here.\" data_hover=\"Second image link goes here.\" title=\"Image title goes here.\" link=\"URL you want it linked to.\"] The tooltip content goes here. [/" + jg_shortcodeid + "]";
break;

case "image-hover":
	tagtext = "["+ jg_shortcodeid + " src=\"First image link goes here.\" data_hover=\"Second image link goes here.\" title=\"Title goes here\" link=\"URL you want it linked to.\"]";
break;
  
case "infobox":
	tagtext = "["+ jg_shortcodeid + " title=\"Title goes here\"] The content goes here. [/" + jg_shortcodeid + "]";
break;

case "toggle":
	tagtext = "["+ jg_shortcodeid + " title=\"Title goes here\"] The content goes here. [/" + jg_shortcodeid + "]";
break;

case "tabs":
	tagtext="["+jg_shortcodeid + " tab1=\"Tab 1 Title\" tab2=\"Tab 2 Title\" tab3=\"Tab 3 Title\"] [tab]Insert tab 1 content here[/tab] [tab]Insert tab 2 content here[/tab] [tab]Insert tab 3 content here[/tab] [/" + jg_shortcodeid + "]";
break;

case "button-silver":
	tagtext = "["+ jg_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + jg_shortcodeid + "]";
break;

case "button-green":
	tagtext = "["+ jg_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + jg_shortcodeid + "]";
break;

case "button-red":
	tagtext = "["+ jg_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + jg_shortcodeid + "]";
break;

case "button-blue":
	tagtext = "["+ jg_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + jg_shortcodeid + "]";
break;

case "button-white":
	tagtext = "["+ jg_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + jg_shortcodeid + "]";
break;

case "button-dark":
	tagtext = "["+ jg_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + jg_shortcodeid + "]";
break;

case "alert-blue":
	tagtext = "["+ jg_shortcodeid + "] Alert text [/" + jg_shortcodeid + "]";
break;

case "alert-red":
	tagtext = "["+ jg_shortcodeid + "] Alert text [/" + jg_shortcodeid + "]";
break;

case "alert-orange":
	tagtext = "["+ jg_shortcodeid + "] Alert text [/" + jg_shortcodeid + "]";
break;

case "alert-green":
	tagtext = "["+ jg_shortcodeid + "] Alert text [/" + jg_shortcodeid + "]";
break;

case "alert-white":
	tagtext = "["+ jg_shortcodeid + "] Alert text [/" + jg_shortcodeid + "]";
break;

case "alert-dark":
	tagtext = "["+ jg_shortcodeid + "] Alert text [/" + jg_shortcodeid + "]";
break;

case "pricing-plan-six":
	tagtext='[raw]<div class="pricing container_12"><div class="grid_2 alpha"><div class="plan"><div class="name">Mega</div><div class="segment">the whole she-bang</div><div class="cost"><span class="number">$99</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2"><div class="plan"><div class="name">Pro</div><div class="segment">almost the top</div><div class="cost"><span class="number">$79</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2"><div class="plan"><div class="name">Super</div><div class="segment">large teams</div><div class="cost"><span class="number">$69</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2"><div class="plan"><div class="name">Bronze</div><div class="segment">most popular</div><div class="cost"><span class="number">$49</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2"><div class="plan"><div class="name">Personal</div><div class="segment">individuals</div><div class="cost"><span class="number">$19</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature yes">yes</div><div class="feature yes">yes</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2 omega"><div class="plan"><div class="name">free!</div><div class="segment">Get Started</div><div class="cost"><span class="number">$0</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature no">no</div><div class="feature no">no</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --></div><!--end .pricing -->[/raw]';
break;

case "pricing-plan-five":
	tagtext='[raw]<div class="pricing grid_10 alpha"><div class="grid_2 alpha"><div class="plan"><div class="name">Pro</div><div class="segment">almost the top</div><div class="cost"><span class="number">$79</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2"><div class="plan"><div class="name">Super</div><div class="segment">large teams</div><div class="cost"><span class="number">$69</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2"><div class="plan"><div class="name">Bronze</div><div class="segment">most popular</div><div class="cost"><span class="number">$49</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2"><div class="plan"><div class="name">Personal</div><div class="segment">individuals</div><div class="cost"><span class="number">$19</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature yes">yes</div><div class="feature yes">yes</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2 omega"><div class="plan"><div class="name">free!</div><div class="segment">Get Started</div><div class="cost"><span class="number">$0</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature no">no</div><div class="feature no">no</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --></div><!--end .pricing -->[/raw]';
break;

case "pricing-plan-four":
	tagtext='[raw]<div class="pricing grid_8 alpha"><div class="grid_2 alpha"><div class="plan"><div class="name">Super</div><div class="segment">large teams</div><div class="cost"><span class="number">$69</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2"><div class="plan"><div class="name">Bronze</div><div class="segment">most popular</div><div class="cost"><span class="number">$49</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2"><div class="plan"><div class="name">Personal</div><div class="segment">individuals</div><div class="cost"><span class="number">$19</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature yes">yes</div><div class="feature yes">yes</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2 omega"><div class="plan"><div class="name">free!</div><div class="segment">Get Started</div><div class="cost"><span class="number">$0</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature no">no</div><div class="feature no">no</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --></div><!--end .pricing -->[/raw]';
break;

case "pricing-plan-three":
	tagtext='[raw]<div class="pricing grid_6 alpha"><div class="grid_2 alpha"><div class="plan"><div class="name">Bronze</div><div class="segment">most popular</div><div class="cost"><span class="number">$49</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2"><div class="plan"><div class="name">Personal</div><div class="segment">individuals</div><div class="cost"><span class="number">$19</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature yes">yes</div><div class="feature yes">yes</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2 omega"><div class="plan"><div class="name">free!</div><div class="segment">Get Started</div><div class="cost"><span class="number">$0</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature no">no</div><div class="feature no">no</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --></div><!--end .pricing -->[/raw]';
break;

case "pricing-plan-two":
	tagtext='[raw]<div class="pricing grid_4 alpha"><div class="grid_2 alpha"><div class="plan"><div class="name">Personal</div><div class="segment">individuals</div><div class="cost"><span class="number">$19</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature yes">yes</div><div class="feature yes">yes</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature">Unlimited Email</div><div class="feature">Online Payments</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --><div class="grid_2 omega"><div class="plan"><div class="name">free!</div><div class="segment">Get Started</div><div class="cost"><span class="number">$0</span><br /><p class="per">per month</p></div><!--end .cost --><div class="feature">10 Staff</div><div class="feature">25 Clients</div><div class="feature">Data Imports</div><div class="feature">Unlimited Space</div><div class="feature no">no</div><div class="feature no">no</div><a class="button" href="#">Choose Plan</a></div><!--end .plan --></div><!--end .grid_2 --></div><!--end .pricing -->[/raw]';
break;

default:
tagtext="["+jg_shortcodeid + "] The content goes here. [/" + jg_shortcodeid + "]";
}
}

if(window.tinyMCE) {
		//TODO: For QTranslate we should use here 'qtrans_textarea_content' instead 'content'
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		//Peforms a clean up of the current editor HTML. 
		//tinyMCEPopup.editor.execCommand('mceCleanup');
		//Repaints the editor. Sometimes the browser has graphic glitches. 
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
		
	}
	return;
}