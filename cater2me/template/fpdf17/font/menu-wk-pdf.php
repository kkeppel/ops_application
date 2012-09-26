<?php
require 'template/fpdf17/fpdf.php';
require 'lib/core.php';

$user = $curUser['first_name'];

$companyid = $_POST['company_id'];
$res5 = mysql_query("SELECT count(id_vendor_item) as nb
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
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
	$this->Ln(15);

}


// Pied de page
function Footer()
{
	
	$date1=$_POST['date1'];
	$date2=$_POST['date2'];
	if ($date1 == '') {$date1 = date("Y-m-d"); }
	if ($date2 == '') {$date2 =  date("Y-m-d"); }

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
 	$this->Cell(80,7,$date1.' to '.$date2,0,0,'L');   
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
$label = $item['lab'];
$notes = $item['menu_notes'];

$this->SetFont('Arial','',11);
if ($oldlabel == $label ) {}
else { 
$this->SetFont('Arial','BI',11);
$this->Cell(0,6,utf8_decode($label),0,1,'C'); }
$this->SetFont('Arial','',11);
$this->Cell(0,6,utf8_decode($menu_name).utf8_decode($notes),0,1,'C');
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


?>

