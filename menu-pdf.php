<?php
require 'template/fpdf17/fpdf.php';
require 'lib/core.php';
if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}



$message ='';
$user = $curUser['first_name'];
$orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
//$orderid='10170';
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

// En-tête

function Header()
{
    $orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
	  
    $this->SetFont('Times','B',18);
    $this->SetY(20);

   	$res = mysql_query("SELECT companies.name as comp, vendors.public_name as vnd, vendors.website as site, order_for
	FROM order_proposals, order_requests, clients, companies, vendors
	WHERE  order_id = id_order
	and order_proposals.vendor_id = id_vendor
	and order_requests.client_id = clients.id_client
	and clients.company_id = id_company
	AND order_id = '$orderid'");
	$header = mysql_fetch_assoc($res);
	$vendor = $header['vnd'];
	$company = $header['comp'];
	$site = $header['site'];
	$date = $header['order_for'];
	/*
$date1 = formatdate($dateorder);
	$day  = date('l', strtotime($date1));
	$month  = date('m', strtotime($date1));
	$day2  = date('d', strtotime($date1));
	$year  = date('y', strtotime($date1));	
*/
       
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
	

}


// Pied de page
function Footer()
{
$orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
	
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

function TitreChapitre($num, $libelle)
{

	if ($num==1)
	{}
	else
	{
    // Times 12
    $this->SetFont('Times','B',10);
    $this->SetTextColor(255,255,255);
    // Couleur de fond
    $this->SetFillColor(196,65,70);
    // Titre
    $this->Cell(0,6, $libelle,0,1,'C',true);
    // Saut de ligne
   }
}



function CorpsChapitre($num,$text)
{
 $orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
	//$orderid='10170';
$res2 = mysql_query("SELECT companies.name as comp, vendors.name as vnd, vendors.website as site, order_for
	FROM order_proposals, order_requests, clients, companies, vendors
	WHERE  order_id = id_order
	and order_proposals.vendor_id = id_vendor
	and order_requests.client_id = clients.id_client
	and clients.company_id = id_company
	AND order_id = '$orderid'");
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
    $this->Ln(3)	;
    
    $res4 = mysql_query("SELECT vendor_items.menu_name as name, food_categories.label as lab, description, label , vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol, order_proposal_items.notes as menu_notes
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND list_order < 19
and selected=1
AND order_proposals.order_id = '$orderid'
order by id_food_category,  quantity DESC");
		

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
					
					$name = stripAccentsUtf8($menu['name']);
					$name =  iconv("UTF-8", "ISO-8859-1//TRANSLIT", $name);	
					$name= strtoupper ($name);
					$label = $item['lab'];
					$notes=  $menu['menu_notes'];
					$label= $menu['label'];
					$desc= $menu['description'];
					$desc = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $desc);
					$this->SetFont('Times','B',16);
					
					
					if ($oldlabel != $label)   {$Ypagetest = 195; }
					else if (strlen($desc)>1) {$Ypagetest = 199; }
					
					else {$Ypagetest = 210; }  
					if ($Ypage > $Ypagetest )
					{ $this->AddPage(); 
					$pagebreak =1 ;} else {}

					 if ($pagebreak==1) { 
					$this->SetX(10);
					$this->Cell(0,6,utf8_decode($label),0,1,'L');
					$this->Ln(2); }
					else  if ($oldlabel == $label ) {}
					else 
					{
					$Ypage3 = $this->GetY();
					$this->SetX(10);
					$this->Ln(2); 
					$this->Cell(0,6,utf8_decode($label),0,1,'L'); $this->Ln(2);}
					
					$this->SetX(17);
					$Ydebut = $this->GetY();
					$this->MultiCell(150,7,$name.$veg.$vegan,0,'L');
					$Yfin = $this->GetY();
					$this->SetFont('Times','B',13);
					$this->SetY($Ydebut);
					$this->Cell(190,5,$glu.$dai.$nut.$egg.$soy,0,0,'R');
					$this->Ln(7);
					$oldlabel = $label;
					$pagebreak =0;					
					if ($desc == '' and $notes ==''){$this->SetY($Yfin);
						}
					else {
					$this->SetY($Yfin);
					if ($desc==$notes){$notes='';}
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
$pdf->Output('Menu Informations.pdf','I');


?>

