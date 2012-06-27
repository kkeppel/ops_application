<?php


require 'template/fpdf17/fpdf.php';
require 'lib/core.php';
if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}
if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');
/*

if(getUserGroup($curUser) != 'client')
	notif('Sorry, you are not allowed here.');
*/

$message ='';
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
 	$this->Cell(40,7,'(E) Egg Free',0,0,'Lque ');
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



$res4 = mysql_query ( "SELECT DISTINCT  id_client 
FROM  clients , order_requests
WHERE order_requests.client_id = clients.id_client");

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
AND order_for between  '2012-05-15 00:00:00' and '2012-05-18 00:00:00'
AND order_proposals.selected =1
AND order_proposals.vendor_id = vendors.id_vendor
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
					//$name = utf8_decode($name);
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



?>

