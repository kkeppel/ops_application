<?php


require 'template/fpdf17/fpdf.php';
require 'lib/core.php';
if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}
/*

if(getUserGroup($curUser) != 'client')
	notif('Sorry, you are not allowed here.');
*/
if(getUserGroup($curUser) == 'employee' ) 
	notif('Sorry, you are not allowed here.');
if(getUserGroup($curUser) == 'vendor' ) 
	notif('Sorry, you are not allowed here.');
$message ='';
if (isset($_POST['menu-dy'])) {
function formatdate($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($year, $month, $day) = explode('-', $date);
  $Timestamp = mktime( $year ,$month, $day);
	$dateUS = date('Y/m/d', $Timestamp);
	return $year.'/'.$month.'/'.$day;
}

function datetimeUS2Time($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($hour, $minute, $second) = explode(':', $time);
  list($year, $month, $day) = explode('-', $date);
  $Timestamp = mktime($hour, $minute, $second, $month, $day, $year);
	$dateUS = date('h:i:s a', $Timestamp);
	return $dateUS; 
}
function stripAccentsUtf8($string)
{
$string = mb_strtolower($string, 'UTF-8');
$string = str_replace(
array(
'à', 'â', 'ä', 'á', 'ã', 'å',
'î', 'ï', 'ì', 'í',
'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
'ù', 'û', 'ü', 'ú',
'é', 'è', 'ê', 'ë',
'ç', 'ÿ', 'ñ',
),
array(
'a', 'a', 'a', 'a', 'a', 'a',
'i', 'i', 'i', 'i',
'o', 'o', 'o', 'o', 'o', 'o',
'u', 'u', 'u', 'u',
'e', 'e', 'e', 'e',
'c', 'y', 'n',
),
$string
);
return $string;
}

class PDF extends FPDF
{

function Header()
{

}


// Pied de page
function Footer()
{
	
    $this->SetY(-40);
    $this->SetFont('Times','B',14);
    $this->SetLineWidth(0.6);
    $this->SetDrawColor(196,65,70);
    $this->Line(10,237 ,200,237);
    $this->Cell(20,7,'KEY:',0,0,'L');
    $this->Cell(35,7,'* Vegetarian',0,0,'L');
    $this->Cell(40,7,'(G) Gluten Free',0,0,'L');
 	$this->Cell(35,7,'(N) Nut Free',0,0,'L');
 	$this->Cell(40,7,'(S) Soy Free',0,0,'L');
 	$this->Ln();
 	$this->Cell(20,7,'',0,0,'L');
 	$this->Cell(35,7,'** Vegan',0,0,'L');
    $this->Cell(40,7,'(D) Dairy Free',0,0,'L');
 	$this->Cell(40,7,'(E) Egg Free',0,0,'L');
 	$this->Ln(10);
 	$this->SetLineWidth(0.9);
    $this->Line(10,255 ,200,255);
    $Ylogo = $this->GetY();
    $this->Image('template/images/custom/logo_menu.jpg');
    $this->SetY($Ylogo);
    $this->Cell(190,7,'Cater2.me | Your Catering is Our Business',0,0,'R');
    $this->Ln();
    $this->SetFont('Times','B',13);
    $this->Cell(190,7,'Questions / comments: info@cater2.me',0,0,'R');
} 



function CorpsChapitre($num,$text)
{


$companyid = $_POST['company_id'];

$res4 = mysql_query ( "SELECT DISTINCT  id_client 
FROM  clients , order_requests
WHERE order_requests.client_id = clients.id_client
AND  `company_id` =  '$companyid'");

	while($clients = mysql_fetch_assoc($res4))
{
$idclient[] = $clients['id_client'];
}
$client1 = $idclient[0];
$client2 = $idclient[1];
$client3 = $idclient[2];
$client4 = $idclient[3];
$client5 = $idclient[4];
$client6 = $idclient[5];
$client7 = $idclient[6];
$client8 = $idclient[7];
$client9 = $idclient[8];
$client10= $idclient[9];

$date1 = date("Y-m-d ");
$day = date("N");
switch($day) {
		case '1':
			$date2 = date( "Y-m-d", time() + 7 * 24 * 60 * 60 );
		break;
		case '2':
			$date1 = date( "Y-m-d", time() - 1 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 6 * 24 * 60 * 60 );
		break;
		case '3':
			$date1 = date( "Y-m-d", time() - 2 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 5 * 24 * 60 * 60 );
		break;
		case '4':
			$date1 = date( "Y-m-d", time() - 3 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 4 * 24 * 60 * 60 );
		break;
		case '5':
			$date1 = date( "Y-m-d", time() - 4 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 3 * 24 * 60 * 60 );
		break;
		case '6':
			$date1 = date( "Y-m-d", time() - 5 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 2 * 24 * 60 * 60 );
		break;
		case '7':
			$date1 = date( "Y-m-d", time() - 6 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 1 * 24 * 60 * 60 );
		break;
		
	}
$date1=$date1.' 00:00:00';
$date2=$date2.' 00:00:00';

/*

$datetmp=$_POST['date1'];
$datetmp2=$_POST['date2'];
$date1=$_POST['date1'].' 00:00:00';
$date2=$_POST['date2'].' 23:59:59';
if ($datetmp == '') {$date1 = date("Y-m-d"); }
if ($datetmp2 == '') {$date2 =  date("Y-m-d"); }
if ($datetmp<$datetmp2) {}
*/
$res2 = mysql_query(
"SELECT id_vendor, vendors.name as vname, id_order, order_for, client_profiles.name as cname, meal_types.label as mealtype
FROM order_requests, order_proposals, vendors, client_profiles, meal_types
WHERE order_requests.id_order = order_proposals.order_id
AND client_profile_id = id_profile
AND client_profiles.client_id = order_requests.client_id
AND meal_type_id = id_meal_type
AND order_requests.order_status_id =4
AND order_for between  '$date1' and '$date2'
AND order_proposals.selected =1
AND order_proposals.vendor_id = vendors.id_vendor
AND (
order_requests.client_id =  '$client1'
OR order_requests.client_id =  '$client2' OR order_requests.client_id =  '$client3' OR order_requests.client_id =  '$client4' OR order_requests.client_id =  '$client5' OR order_requests.client_id =  '$client6' OR order_requests.client_id =  '$client7' OR order_requests.client_id =  '$client8' OR order_requests.client_id =  '$client9' OR order_requests.client_id =  '$client10'
)
ORDER BY order_for ");
 while($ordertmp = mysql_fetch_assoc($res2))
{
$orderid[] = $ordertmp ['id_order'];
}
$sizearray = count($orderid);
$i=0;
foreach($orderid as $valeur) 
  {  $oldlabel='';
	$this->SetY(20);
	$this->SetFont('Times','B',18);
	$res = mysql_query("SELECT companies.name as comp, vendors.public_name as vnd, vendors.website as site, order_for
	FROM order_proposals, order_requests, clients, companies, vendors
	WHERE  order_id = id_order
	AND order_proposals.selected =1
	and order_proposals.vendor_id = id_vendor
	and order_requests.client_id = clients.id_client
	and clients.company_id = id_company
	AND order_id = '$valeur'");
	$header = mysql_fetch_assoc($res);
	$vendor = $header['vnd'];
	$company = $header['comp'];
	$site = $header['site'];
	$date = $header['order_for'];
	$this->Cell(100,7,utf8_decode($company),0,0,'L');
  	 $this->SetFont('Times','B',18);
  	$this->Cell(90,7,utf8_decode($vendor),0,0,'R');
  	$this->Ln();
  	$this->SetFont('Times','B',12);
  	$this->Cell(190,7,$site,0,0,'R');
  
    $this->Ln(10);
	$this->SetLineWidth(1);
	$this->SetDrawColor(196,65,70);
    $this->Line(10,36,200,36); 
    
    $res2 = mysql_query("SELECT companies.name as comp, vendors.name as vnd, vendors.website as site, order_for
	FROM order_proposals, order_requests, clients, companies, vendors
	WHERE  order_id = id_order
	and order_proposals.vendor_id = id_vendor
	and order_requests.client_id = clients.id_client
	AND order_proposals.selected =1
	and clients.company_id = id_company
	AND order_id = '$valeur'");
	$info = mysql_fetch_assoc($res2);
	$date = $info['order_for'];
	$dateorder = formatdate($date);
	$day  = date('d', strtotime($dateorder));
	$month  = date('F', strtotime($dateorder));
	$year  = date('Y', strtotime($dateorder));
	$datenew= $month.' '.$day.', '.$year;
	$this->Ln(1);
	$this->SetFont('Times','B',14);
  	$this->Cell(0,7, $datenew,0,1,'C');
  	$this->SetLineWidth(0.6);
  	$this->SetDrawColor(196,65,70);
    $this->Line(10,46,200,46);		
    $this->Line(10,47,200,47);
    $this->Ln(3);
    
     $res4 = mysql_query("SELECT vendor_items.menu_name as name, food_categories.label as lab, description, label , vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol, order_proposal_items.notes as menu_notes
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND list_order < 19
and selected=1
AND order_proposals.order_id = '$valeur'
order by id_food_category,  quantity DESC");

$j = 0;
while($menu = mysql_fetch_assoc($res4))
				{
				
				$veg = '';
				$glu= '';
				$dai= '';
				$vegan= '';
				$nut= '';
				$egg= '';
				$soy= '';
				$hon= '';
				$she= '';
				$alc= '';
		
				if ($menu['vegetarian']=='1')
				{ $veg = '*';}	
				if ($menu['gluten_safe']=='1')
				{ $glu = '(G)';}	
				if ($menu['dairy_safe']=='1')
				{ $dai = '(D)';}	
				if ($menu['vegetarian'] =='1' && $menu['dairy_safe']=='1' && $menu['egg_safe']=='1')
				{ $vegan = '*';}
				if ($menu['nut_safe']=='1')
				{ $nut = '(N)';}	
				if ($menu['egg_safe']=='1')
				{ $egg = '(E)';}	
				if ($menu['soy_safe']=='1')
				{ $soy = '(S)';}	
				if ($menu['contains_honey']=='1')
				{ $hon = '(Contains honey)';}
				if ($menu['contains_shellfish']=='1')
				{ $she = '(Contains shellfish)';}
				if ($menu['contains_alcohol']=='1')
				{ $alc = '(Contains alcohol)';}
					
					$name=  $menu['name'];
					$name = stripAccentsUtf8($name);
					$name =  iconv("UTF-8", "ISO-8859-1//TRANSLIT", $name);
					$name= strtoupper ($name);
					$label = $item['lab'];
					$notes= $menu['menu_notes'];
					$label= $menu['label'];
					$desc= $menu['description'];
					$desc = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $desc);
					$this->SetFont('Times','B',16);
					$Ypage = $this->GetY();
					
					
					
					
					if ($j == 0 ){}
					else { 
					if ($oldlabel != $label)   {$Ypagetest = 195; }
					else if (strlen($desc)>1 and strlen($name)>36) {$Ypagetest = 188; }
					else if (strlen($desc)>1 and strlen($name)>1) {$Ypagetest = 190; }
					else if (strlen($desc)>1) {$Ypagetest = 195; }
					
					else {$Ypagetest = 210; }  
					if ($Ypage > $Ypagetest )
					{ $this->AddPage(); 
					$pagebreak =1 ;} else {}
					}
					if ($pagebreak==1) {
					$this->SetY(20);
					$this->SetFont('Times','B',18);
					$this->Cell(100,7,utf8_decode($company),0,0,'L');
				  	$this->SetFont('Times','B',18);
				  	$this->Cell(90,7,utf8_decode($vendor),0,0,'R');
				  	$this->Ln();
				  	$this->SetFont('Times','B',12);
				  	$this->Cell(190,7,$site,0,0,'R');
				  
				    $this->Ln(10);
					$this->SetLineWidth(1);
					$this->SetDrawColor(196,65,70);
				    $this->Line(10,36,200,36);
 
					$this->SetX(10);
					$this->SetFont('Times','B',16);
					$this->Cell(0,6,utf8_decode($label),0,1,'L');
					$this->Ln(2); }
					else  if ($oldlabel == $label ) {}
					else 
					{
					
					$Ypage3 = $this->GetY();
					$this->SetX(10);
					$this->Ln(2); 
					$this->SetFont('Times','B',16);
					$this->Cell(0,6,utf8_decode($label),0,1,'L'); $this->Ln(2);}
					
					$this->SetX(17);
					$Ydebut = $this->GetY();
					$this->SetFont('Times','B',16);
					$this->MultiCell(150,7,$name.$veg.$vegan,0,'L');
					$Yfin = $this->GetY();
					$this->SetFont('Times','B',13);
					$this->SetY($Ydebut);
					$this->Cell(190,5,$glu.$dai.$nut.$egg.$soy,0,0,'R');
					$this->Ln(7);
					$oldlabel = $label;
					$pagebreak =0;					
					if ($desc == '' and $notes ==''){ $this->SetY($Yfin);
						}
					else {
					$this->SetY($Yfin);
					$this->Cell(10,5,'',0,0,'L');
					$this->SetFont('Times','BI',13);
					$Ypage = $this->GetY();
					if ($desc==''){
					$this->MultiCell(165,7,'('.utf8_decode($notes).')',0,'L');}
					else if ($notes==''){
					$this->MultiCell(165,7,$desc,0,'L');}
					else {
					$this->MultiCell(165,7,$desc.' ('.utf8_decode($notes).')',0,'L');}
					$Ypage2 = $this->GetY();

					
					}
					$j++;				
			 }$i++;
    // TODO gerer le faux header
    if ($i == $sizearray) {}
else {    $this->AddPage();
}
  }

}


function AddLbl($num, $titre, $text)
{
    //$this->AddPage();
    	$this->CorpsChapitre($num,$text);
}

}





$dimension = array(216,280);
$pdf=new PDF('P','mm', $dimension);
//$pdf = new PDF();
$pdf->AddPage();

$pdf->SetTitle($titre);
//$pdf->Cell(0,10,'Hello '.$user,0,1);
$pdf->AddLbl(1,'',$orderinfoarray );
$nb=$pdf->AliasNbPages();
$pdf->Output('Menu Informations.pdf','I');

}
else if (isset($_POST['menu-wk']))
{

$user = $curUser['first_name'];

$companyid = $_POST['company_id'];
$res5 = mysql_query("SELECT count(id_vendor_item) as nb
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposals.selected =1
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND order_proposals.order_id = '$orderid'");
$nbtemp = mysql_fetch_assoc($res5);
$nb = $nbtemp['nb'];

function formatdate($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($year, $month, $day) = explode('-', $date);
  $Arialtamp = mktime( $year ,$month, $day);
	$dateUS = date('Y/m/d', $Arialtamp);
	return $year.'/'.$month.'/'.$day;
}

function datetimeUS2Time($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($hour, $minute, $second) = explode(':', $time);
  list($year, $month, $day) = explode('-', $date);
  $Arialtamp = mktime($hour, $minute, $second, $month, $day, $year);
	$dateUS = date('h:i:s a', $Arialtamp);
	return $dateUS; 
}

class PDF extends FPDF
{

// En-tête

function Header()
{
$companyid = $_POST['company_id'];

    $this->SetFont('Arial','B',16);
     $this->SetY(20);

    

   	$res = mysql_query("SELECT name 
   	FROM companies
	WHERE  id_company = '$companyid'");
	$header = mysql_fetch_assoc($res);
	$company = $header['name'];
	
       
  	$this->Cell(0,7,utf8_decode($company).' Catering Menu',0,0,'C');
  	
  	
	$this->SetLineWidth(1);
	$this->SetDrawColor(196,65,70);
    $this->Line(20,30,190,30);
	$this->Ln(9);

}


// Pied de page
function Footer()
{
	
$date1f = date("Y-m-d ");
$day = date("N");
switch($day) {
		case '1':
			$date2f = date( "Y-m-d", time() + 7 * 24 * 60 * 60 );
		break;
		case '2':
			$date1f = date( "Y-m-d", time() - 1 * 24 * 60 * 60 );
			$date2f = date( "Y-m-d", time() + 6 * 24 * 60 * 60 );
		break;
		case '3':
			$date1f = date( "Y-m-d", time() - 2 * 24 * 60 * 60 );
			$date2f = date( "Y-m-d", time() + 5 * 24 * 60 * 60 );
		break;
		case '4':
			$date1f = date( "Y-m-d", time() - 3 * 24 * 60 * 60 );
			$date2f = date( "Y-m-d", time() + 4 * 24 * 60 * 60 );
		break;
		case '5':
			$date1f = date( "Y-m-d", time() - 4 * 24 * 60 * 60 );
			$date2f = date( "Y-m-d", time() + 3 * 24 * 60 * 60 );
		break;
		case '6':
			$date1f = date( "Y-m-d", time() - 5 * 24 * 60 * 60 );
			$date2f = date( "Y-m-d", time() + 2 * 24 * 60 * 60 );
		break;
		case '7':
			$date1f = date( "Y-m-d", time() - 6 * 24 * 60 * 60 );
			$date2f = date( "Y-m-d", time() + 1 * 24 * 60 * 60 );
		break;

	}

    $this->SetY(-20);
    $this->SetFont('Arial','B',11);
    $this->SetLineWidth(1);
    $this->SetDrawColor(0,0,0);
    $this->Line(20,260 ,190,260);
	$nopage = $this->PageNo();
	$this->SetX(20);
	$this->Cell(80,7,'Page '.$nopage.' of {nb}',0,0, 'L');
	$this->Cell(90,6,'Cater2.me | Your Catering is Our Business',0,0,'R');
 	$this->Ln();
 	$this->SetX(20);
 	$this->Cell(80,7,$date1f.' to '.$date2f,0,0,'L');   
 	$this->Cell(90,6,'Questions / comments: info@cater2.me',0,0,'R');

    //$this->Image('template/images/custom/logosmall.jpg');
   
      
}

function TitreChapitre($num, $libelle)
{

}



function CorpsChapitre($num,$text)
{

$companyid = $_POST['company_id'];

$res4 = mysql_query ( "SELECT DISTINCT  id_client 
FROM  clients , order_requests
WHERE order_requests.client_id = clients.id_client
AND  `company_id` =  '$companyid'");

	while($clients = mysql_fetch_assoc($res4))
{
$idclient[] = $clients['id_client'];

}

$client1 = $idclient[0];
$client2 = $idclient[1];
$client3 = $idclient[2];
$client4 = $idclient[3];
$client5 = $idclient[4];
$client6 = $idclient[5];
$client7 = $idclient[6];
$client8 = $idclient[7];
$client9 = $idclient[8];
$client10= $idclient[9];

$date1 = date("Y-m-d ");
$date1=$date1.' 00:00:00';

$day = date("N");
switch($day) {
		case '1':
			$date2 = date( "Y-m-d", time() + 7 * 24 * 60 * 60 );
		break;
		case '2':
			$date1 = date( "Y-m-d", time() - 1 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 6 * 24 * 60 * 60 );
		break;
		case '3':
			$date1 = date( "Y-m-d", time() - 2 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 5 * 24 * 60 * 60 );
		break;
		case '4':
			$date1 = date( "Y-m-d", time() - 3 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 4 * 24 * 60 * 60 );
		break;
		case '5':
			$date1 = date( "Y-m-d", time() - 4 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 3 * 24 * 60 * 60 );
		break;
		case '6':
			$date1 = date( "Y-m-d", time() - 5 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 2 * 24 * 60 * 60 );
		break;
		case '7':
			$date1 = date( "Y-m-d", time() - 6 * 24 * 60 * 60 );
			$date2 = date( "Y-m-d", time() + 1 * 24 * 60 * 60 );
		break;

		
	}

$date2=$date2.' 00:00:00';

/*
$datetmp=$_POST['date1'];
$datetmp2=$_POST['date2'];
$date1=$_POST['date1'].' 00:00:00';
$date2=$_POST['date2'].' 23:59:59';

if ($datetmp == '') {$date1 = date("Y-m-d"); }
if ($datetmp2 == '') {$date2 =  date("Y-m-d"); }
*/

$res2 = mysql_query(
"SELECT id_vendor, vendors.name as vname, id_order, order_for, client_profiles.name as cname, meal_types.label as mealtype
FROM order_requests, order_proposals, vendors, client_profiles, meal_types
WHERE order_requests.id_order = order_proposals.order_id
AND client_profile_id = id_profile
AND client_profiles.client_id = order_requests.client_id
AND meal_type_id = id_meal_type
AND order_requests.order_status_id =4
AND order_for between  '$date1' and '$date2'
AND order_proposals.selected =1
AND order_proposals.vendor_id = vendors.id_vendor
AND (
order_requests.client_id =  '$client1'
OR order_requests.client_id =  '$client2' OR order_requests.client_id =  '$client3' OR order_requests.client_id =  '$client4' OR order_requests.client_id =  '$client5' OR order_requests.client_id =  '$client6' OR order_requests.client_id =  '$client7' OR order_requests.client_id =  '$client8' OR order_requests.client_id =  '$client9' OR order_requests.client_id =  '$client10'
)
ORDER BY order_for ");
$i = 0;
 while($vendornext = mysql_fetch_assoc($res2))
{
$name_vnd= $vendornext['vname'];
$profile_cl= $vendornext['cname'];
$name_vndtb[]=$vendornext['vname'];
$mealtype = $vendornext['mealtype'];
$vnd[] = $vendornext['id_vendor'];
$order_id[] = $vendornext ['id_order'];
$date = $vendornext ['order_for'];

$date = formatdate($date);
$day  = date('d', strtotime($date));
$day2  = date('l', strtotime($date));
$month  = date('F', strtotime($date));
$year  = date('Y', strtotime($date));
$datenew= $day2.', '.$month.' '.$day.', '.$year;
$order = $order_id[$i];

$Ymenu = $this -> GetY();
$res10 =  mysql_query("
SELECT COUNT( menu_name ) as countmenu
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND order_proposals.selected =1
AND list_order <19
AND order_proposals.order_id =  $order
ORDER BY food_categories.list_order, quantity DESC");
$count = mysql_fetch_assoc($res10);
$countmenu = $count['countmenu'];  
$sizemenu =  $countmenu * 7;
$sizemenu = $sizemenu + 35;  
if ($Ymenu + $sizemenu > 265 )
{$this->AddPage();}
else {} 
	$this->SetFont('Arial','B',11);
	$this->Ln();
	$this->Cell(0,6,$datenew.' '.$mealtype.': '.utf8_decode($name_vnd),0,1,'C');
 


$res3 = mysql_query("
SELECT menu_name, description,  food_categories.label as lab, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol,  order_proposal_items.notes as menu_notes
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND list_order < 19
and selected=1
AND order_proposals.order_id ='$order'
order by food_categories.list_order,  quantity DESC");
while($item = mysql_fetch_assoc($res3))
{
$menu_name = $item['menu_name'];
$menu_name = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $menu_name);
$label = $item['lab'];
$label = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $label);
$notes = $item['menu_notes'];
$notes = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $notes);


$this->SetFont('Arial','',11);
if ($oldlabel == $label ) {}
else { 
$this->SetFont('Arial','BI',11);
$this->Cell(0,6,$label,0,1,'C'); }
$this->SetFont('Arial','',11);
if ($notes==''){
	$this->MultiCell(0,6,$menu_name,0,'C');}
else {
	$this->MultiCell(0,6,$menu_name.'. ('.$notes.')',0,'C');
    }

$oldlabel = $label;
 $this->SetFont('Arial','B',11);

}
$i++;
$imageX= $this->SetX(40);
$imageY=$this->GetY();
$this->Image('template/images/custom/line_pdf.jpg',$imageX,$imageY,140);
 }	
 			

	}


function AddLbl($num, $titre, $text)
{
    //$this->AddPage();
    $this->TitreChapitre($num,$titre);
  	$this->CorpsChapitre($num,$text);
}

}





$dimension = array(216,280);
$pdf=new PDF('P','mm', $dimension);

//$pdf = new PDF();
$pdf->AddPage();
$nb=$pdf->AliasNbPages();
$datetmp=$_POST['date1'];
//$pdf->Cell(0,6,utf8_decode($datetmp),0,1,'C');
$pdf->SetTitle($titre);
//$pdf->Cell(0,10,'Hello '.$user,0,1);
$pdf->AddLbl(1,'',$orderinfoarray );
$nb=$pdf->AliasNbPages();
$pdf->Output('Schedule_Menu.pdf','I');

}
// POUR LABEL WEEK
else {

require 'template/fpdf17/fpdf.php';
require 'lib/core.php';


$res5 = mysql_query("SELECT count(id_vendor_item) as nb
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND order_proposals.selected =1
AND order_proposals.order_id = '$orderid'");
$nbtemp = mysql_fetch_assoc($res5);
$nb = $nbtemp['nb'];

function formatdate($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($year, $month, $day) = explode('-', $date);
  $Timestamp = mktime( $year ,$month, $day);
	$dateUS = date('Y/m/d', $Timestamp);
	return $year.'/'.$month.'/'.$day;
}

function datetimeUS2Time($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($hour, $minute, $second) = explode(':', $time);
  list($year, $month, $day) = explode('-', $date);
  $Timestamp = mktime($hour, $minute, $second, $month, $day, $year);
	$dateUS = date('g:i:s a', $Timestamp);
	return $dateUS; 
}
function SetDash($black=false,$white=false)
    {
        if($black and $white)
            $s=sprintf('[%.3f %.3f] 0 d',$black*$this->k,$white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }

class PDF extends FPDF
{

// En-tête

function Header()
{
 	
}


// Pied de page
function Footer()
{	
    // Positionnement à 1,5 cm du bas
    $this->SetY(-30);
    // Police Times italique 8
    $this->SetFont('Times','B',11);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(1);
    $this->Line(10,250,200,250);
    // Numéro de page
    $this->Cell(0,7,'Allergen Key',0,0,'C');
$this->Ln();
	$this->SetX(20);
    $this->Cell(25,7,'* Vegetarian',0,0,'L');
    $this->Cell(18,7,'** Vegan',0,0,'L');
    $this->Cell(30,7,'(G) Gluten Safe',0,0,'L');
    $this->Cell(27,7,'(D) Dairy Safe',0,0,'L');
 	$this->Cell(24,7,'(N) Nut Safe',0,0,'L');
 	$this->Cell(24,7,'(E) Egg Safe',0,0,'L');
 	$this->Cell(24,7,'(S) Soy Safe',0,0,'L');
 	 	   	
}
function TitreChapitre($num,$text)
{}
function CorpsChapitre($num,$text)
{



$companyid = $_POST['company_id'];

$res4 = mysql_query ( "SELECT DISTINCT  id_client 
FROM  clients , order_requests
WHERE order_requests.client_id = clients.id_client
AND  `company_id` =  '$companyid'");

	while($clients = mysql_fetch_assoc($res4))
{
$idclient[] = $clients['id_client'];
}
$client1 = $idclient[0];
$client2 = $idclient[1];
$client3 = $idclient[2];
$client4 = $idclient[3];
$client5 = $idclient[4];
$client6 = $idclient[5];
$client7 = $idclient[6];
$client8 = $idclient[7];
$client9 = $idclient[8];
$client10= $idclient[9];

$datetmp=$_POST['date1'];
$datetmp2=$_POST['date2'];
$date1=$_POST['date1'].' 00:00:00';
$date2=$_POST['date2'].' 23:59:59';
if ($datetmp == '') {$date1 = date("Y-m-d"); }
if ($datetmp2 == '') {$date2 =  date("Y-m-d"); }

$res2 = mysql_query(
"SELECT id_vendor, vendors.name as vname, id_order, order_for, client_profiles.name as cname, meal_types.label as mealtype
FROM order_requests, order_proposals, vendors, client_profiles, meal_types
WHERE order_requests.id_order = order_proposals.order_id
AND client_profile_id = id_profile
AND client_profiles.client_id = order_requests.client_id
AND meal_type_id = id_meal_type
AND order_requests.order_status_id =4
AND order_for between  '$date1' and '$date2'
AND order_proposals.selected =1
AND order_proposals.vendor_id = vendors.id_vendor
AND (
order_requests.client_id =  '$client1'
OR order_requests.client_id =  '$client2' OR order_requests.client_id =  '$client3' OR order_requests.client_id =  '$client4' OR order_requests.client_id =  '$client5' OR order_requests.client_id =  '$client6' OR order_requests.client_id =  '$client7' OR order_requests.client_id =  '$client8' OR order_requests.client_id =  '$client9' OR order_requests.client_id =  '$client10'
)
ORDER BY order_for ");
 while($ordertmp = mysql_fetch_assoc($res2))
{
$orderid[] = $ordertmp ['id_order'];
}
$sizearray = count($orderid);
$a=0;
foreach($orderid as $valeur) 
  {  
  
  
$this->SetFont('Times','B',12);
     $this->SetY(20);
   	$res = mysql_query("SELECT id_order_proposal, order_for
	FROM order_proposals, order_requests
	WHERE  order_id = id_order
	AND order_id = '$valeur'");
	$header = mysql_fetch_assoc($res);
	$idprop = $header['id_order_proposal'];
	$dateorder = $header['order_for'];
	$date1 = formatdate($dateorder);
	$day  = date('l', strtotime($date1));
	$month  = date('m', strtotime($date1));
	$day2  = date('d', strtotime($date1));
	$year  = date('y', strtotime($date1));	
     //$this->Ln(4);
   
  	$this->Cell(50,7,'Order ID: '.$idprop,0,0,'L');
  	$this->Cell(70,7,'Date: '.$day.', '.$month.'/'.$day2.'/'.$year,0,0,'L');
  	$this->Ln();
  	$this->Cell(0,7,'CUT ALONG DOTTED LINES. PLACE LABELS IN FRONT OF PLATTERS / TRAYS
',0,0,'C');
    // Saut de ligne
    $this->Ln(10);
  
  	$res = mysql_query("SELECT public_name 
	FROM order_requests, order_proposals, vendors
	WHERE  order_id ='$valeur'
	and id_order = order_id
	and order_proposals.vendor_id= id_vendor
	AND selected =1 
		");
		
		$info = mysql_fetch_assoc($res);
		
		$vendor = $info['public_name'];
		$vendor = utf8_decode($vendor);
	
  	$res4 = mysql_query("SELECT  vendor_items.menu_name as name, description, label, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol, order_proposal_items.notes as item_note
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND list_order < 19
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
and selected=1
AND order_proposals.order_id = '$valeur'
order by id_food_category,  quantity DESC");

$nbLbl = mysql_num_rows($res4);
$nb=1;
		
			while($menu = mysql_fetch_assoc($res4))
				{
		$name = stripAccentsUtf8($name);	
		$name= strtoupper ($menu['name']);
		$name = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $name);
		//$name = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $name);
		$name= strtoupper ($name);
		$desc= $menu['description'];
		$desc = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $desc);
		$notes= $menu['item_note'];
		$size = strlen ($desc);
		$sizename = strlen ($name);
		$veg = '';
		$glu= '';
		$dai= '';
		$vegan= '';
		$nut= '';
		$egg= '';
		$soy= '';
		$hon= '';
		$she= '';
		$alc= '';

		if ($menu['vegetarian']=='1')
		{ $veg = '*';}	
		if ($menu['gluten_safe']=='1')
		{ $glu = '(G)';}	
		if ($menu['dairy_safe']=='1')
		{ $dai = '(D)';}	
		if ($menu['vegetarian'] =='1' && $menu['dairy_safe']=='1' && $menu['egg_safe']=='1')
		{ $vegan = '*';}
		if ($menu['nut_safe']=='1')
		{ $nut = '(N)';}	
		if ($menu['egg_safe']=='1')
		{ $egg = '(E)';}	
		if ($menu['soy_safe']=='1')
		{ $soy = '(S)';}	
		if ($menu['contains_honey']=='1')
		{ $hon = '(Contains honey)';}
		if ($menu['contains_shellfish']=='1')
		{ $she = '(Contains shellfish)';}
		if ($menu['contains_alcohol']=='1')
		{ $alc = '(Contains alcohol)';}

  	$Ydebut = $this->GetY();
  	//$this -> Cell(30,7,$Ydebut,0,0,'R');
  	$this->SetXY(10,$Ydebut);
    $this->SetFont('Times','B',12);
    $this->SetFillColor(255,255,255);
    $this->SetLineWidth(0.1);
    $x1 = 10;
    $y1 = $Ydebut-3;
    $x2 =200;
    $y2 = 100;
    $nbPointilles=60;
    
       
        $longueur=abs($x1-$x2);
       // $hauteur=abs($y1-$y2);
       
            $Pointilles=($longueur/$nbPointilles)/2; // taille des pointilles
        
        for($i=$x1;$i<=$x2;$i+=$Pointilles+$Pointilles) {
            for($j=$i;$j<=($i+$Pointilles);$j++) {
                if($j<=($x2-1)) {
                    $this->Line($j,$y1,$j+1,$y1); // on trace le pointillé du haut, point par point
                    //$this->Line($j,$y2,$j+1,$y2); // on trace le pointillé du bas, point par point
                }
            }
        }
    
    for($l=$Ydebut-2;$l<=$Ydebut+6;$l+=$Pointilles+$Pointilles) { 
    $this->Line(105,$l,105,$l+2);
    }
    for($l2=$Ydebut+25;$l2<=$Ydebut+35;$l2+=$Pointilles+$Pointilles) { 
    $this->Line(105,$l2,105,$l2+2);
    }
    for($l3=$Ydebut+53;$l3<=$Ydebut+65;$l3+=$Pointilles+$Pointilles) { 
    $this->Line(105,$l3,105,$l3+2);
    }
    $this->Cell(90,7,$vendor,'B',0,'L');
	$this->SetX(110);
	$this->Cell(90,7,$vendor,'B',0,'L');
	$this->SetX(10);
    $this->Ln();
     $this->SetFont('Times','B',16);
    /*
if ($sizename > 40)
	{						
	}
	else  if ($sizename > 20)
	{						
	}
	else {
   }
*/	$Yname = $this->GetY();
	$this->MultiCell(90,7,$name.$veg.$vegan,0,'C');
	$this->SetXY(110,$Yname);
	$this->MultiCell(90,7,$name.$veg.$vegan,0,'C');
	$this->SetX(10);
	$this->Ln(12);	
	$Y = $this->GetY();	
	if ($size > 150)
	{						
	$this->SetFont('Times','BI',9);}
	else {$this->SetFont('Times','BI',11);}
	$this->MultiCell(90,5,$desc,0,'C');
	$this->SetXY(110,$Y);
	//$this->SetY($Y);
	
	$this->MultiCell(90,5,$desc,0,'C');
	$this->MultiCell(90,5,$notes,0,'C');
	$this->SetX(10);
	$this->Ln();
	$Yfin = $Ydebut + 50;
	$this->SetXY(10,$Yfin );
	$this->SetFont('Times','BI',9);
	$Y3 = $this->GetY();
	$this->MultiCell(65,7,$glu.$dai.$nut.$egg.$soy);
	$this->SetXY(110,$Y3);
	$this->MultiCell(100,7,$glu.$dai.$nut.$egg.$soy);	
	//$Y3 = $this->GetY();	
	$this->SetFont('Times','BI',11);	
	$this->SetXY(80,$Y3);
	$this->Image('template/images/custom/logosmall.jpg');
	$this->SetXY(180,$Y3);
	$this->Image('template/images/custom/logosmall.jpg');
	$this->Ln(12);
	//$this->SetY(10);		
	//$this->SetAutoPageBreak(true,40) ;
	if ($nb == 3  or $nb == 6 or $nb == 9 or $nb == 12){ 
		$Yfindott = $this->GetY();	
	for($i=$x1;$i<=$x2;$i+=$Pointilles+$Pointilles) {
            for($j=$i;$j<=($i+$Pointilles);$j++) {
                if($j<=($x2-1)) {
                    $this->Line($j,$Yfindott-3,$j+1,$Yfindott-3); // on trace le pointillé du haut, point par point
                    //$this->Line($j,$y2,$j+1,$y2); // on trace le pointillé du bas, point par point
                }
            }
        }
        if ($nb < $nbLbl) {
	$this->AddPage();
	$this->SetFont('Times','B',12);
	 $this->SetY(20);
	$this->Cell(50,7,'Order ID: '.$idprop,0,0,'L');
  	$this->Cell(70,7,'Date: '.$day.', '.$month.'/'.$day2.'/'.$year,0,0,'L');
  	$this->Ln();
  	$this->Cell(0,7,'CUT ALONG DOTTED LINES. PLACE LABELS IN FRONT OF PLATTERS / TRAYS
',0,0,'C');
    // Saut de ligne
    $this->Ln(10);
	}} else {}
	$nb++;
					}
					
	$Yfindott = $this->GetY();	
	for($i=$x1;$i<=$x2;$i+=$Pointilles+$Pointilles) {
            for($j=$i;$j<=($i+$Pointilles);$j++) {
                if($j<=($x2-1)) {
                    $this->Line($j,$Yfindott-3,$j+1,$Yfindott-3); // on trace le pointillé du haut, point par point
                    //$this->Line($j,$y2,$j+1,$y2); // on trace le pointillé du bas, point par point
                }
            }
        }
   $a++;
   // TODO gerer le faux header
    if ($a == $sizearray) {}
else {    $this->AddPage();
}  

  }


    
}


function AddLbl($num, $titre, $text)
{
    //$this->AddPage();
    $this->TitreChapitre($num,$titre);
  	$this->CorpsChapitre($num,$text);
}

}



$dimension = array(216,280);
$pdf=new PDF('P','mm', $dimension);
//$pdf = new PDF();
$pdf->AddPage();

$pdf->SetTitle($titre);
//$pdf->Cell(0,10,'Hello '.$user,0,1);
$pdf->AddLbl(1,'',$orderinfoarray );
$nb=$pdf->AliasNbPages();
$pdf->Output('Label Order.pdf', 'I');



}
?>

