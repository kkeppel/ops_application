<?php
require 'template/fpdf17/fpdf.php';
require 'lib/core.php';
if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}



$message ='';

$orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
$res5 = mysql_query("SELECT count(id_vendor_item) as nb
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
and selected=1
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

	  
    $this->SetFont('Times','B',12);
     $this->SetY(20);

    

   	$res = mysql_query("SELECT id_order_proposal, order_for
	FROM order_proposals, order_requests
	WHERE  order_id = id_order
	and selected=1
	AND order_id = '$orderid'");
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
	
}


// Pied de page
function Footer()
{
$orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
	
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

function SetDash($black=false,$white=false)
    {
        if($black and $white)
            $s=sprintf('[%.3f %.3f] 0 d',$black*$this->k,$white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }


function CorpsChapitre($num,$text)
{
$orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));  	
  	$res = mysql_query("SELECT public_name 
	FROM order_requests, order_proposals, vendors
	WHERE  order_id ='$orderid'
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
AND order_proposals.order_id = '$orderid'
order by id_food_category,  quantity DESC");

$nbLbl = mysql_num_rows($res4);
$nb=1;
		
			while($menu = mysql_fetch_assoc($res4))
				{
		
		$name = stripAccentsUtf8($menu['name']);	
		$name= strtoupper ($name);
		//$name = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $name);
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
	if ($size > 150 and $size2 >50)
	{$this->Ln(2);}
	else {
	$this->Ln(12);	}
	$Y = $this->GetY();	
	if ($size > 150)
	{						
	$this->SetFont('Times','BI',9);}
	else {$this->SetFont('Times','BI',11);}
	
	if ($desc=='' and $notes =='' ) {}
	else {
	if ($desc==$notes){$notes='';
	}
	
	if ($desc==''){
	$this->MultiCell(90,5,'('.$notes.')',0,'C');
	$this->SetXY(110,$Y);
	$this->MultiCell(90,5,'('.$notes.')',0,'C');
	}
	else if ($notes==''){
	$this->MultiCell(90,5,$desc,0,'C');
	$this->SetXY(110,$Y);
	$this->MultiCell(90,5,$desc,0,'C');}
	else {
	$this->MultiCell(90,5,$desc.'. ('.$notes.')',0,'C');
	$this->SetXY(110,$Y);
	$this->MultiCell(90,5,$desc.'. ('.$notes.')',0,'C');
    }
	
	}	$this->SetX(10);
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
	$this->AddPage();}} else {}
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
	}


function AddLbl($num, $titre, $text)
{
    //$this->AddPage();
    $this->TitreChapitre($num,$titre);
  	$this->CorpsChapitre($num,$text);
}

}

$orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
$res = mysql_query(" 
SELECT order_id, order_for, id_order_proposal, companies.name as company, invoice_first_name, vendors.name as vendor, employees, companies.id_company as id_comp, clients.id_client as client, phone_number
FROM companies, order_requests, order_proposals, vendors, clients, users
WHERE  order_id ='$orderid'
and id_order = order_id
and invoice_email = email
and selected=1
and clients.id_client = users.client_id
and order_requests.client_id = clients.id_client
and companies.id_company = clients.company_id
and order_proposals.vendor_id= id_vendor
");

$info = mysql_fetch_assoc($res);
$order = $info['order_id'];
$date = $info['order_for'];
$propid = $info['id_order_proposal'];
$company = $info['company'];
$vendor = $info['vendor'];
$nameclient = $info['invoice_first_name'];
$nbemp = $info['employees'];
$id_comp = $info['id_comp'];
$idclient = $info['client'];
$phone_number = $info['phone_number'];


$orderinfoarray = array("orderid" => $order, "date" => $date, "propid" => $propid,"company" => $company,"vendor" => $vendor,"nameclient" => $nameclient,"nbemp" => $nbemp, "id comp" => $id_comp, "id client" => $idclient,"phone_number" => $phone_number);





$dimension = array(216,280);
$pdf=new PDF('P','mm', $dimension);
//$pdf = new PDF();
$pdf->AddPage();

$pdf->SetTitle($titre);
//$pdf->Cell(0,10,'Hello '.$user,0,1);
$pdf->AddLbl(1,'',$orderinfoarray );
$nb=$pdf->AliasNbPages();
$pdf->Output('Label Order.pdf', 'I');


?>

