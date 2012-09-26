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
//$orderid = '10417';
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
	$dateUS = date('m/d', $Timestamp);
	return $month.'/'.$day;
}

function datetimeUS2Time($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($hour, $minute, $second) = explode(':', $time);
  list($year, $month, $day) = explode('-', $date);
  $Timestamp = mktime($hour, $minute, $second, $month, $day, $year);
	$dateUS = date('g:i:s A', $Timestamp);
	return $dateUS; 
}

class PDF extends FPDF
{

// En-tte

function Header()
{


$orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
    $this->SetFont('Times','B',15);
	
	$res50 = mysql_query("SELECT  last_updated 
FROM  order_requests
WHERE  id_order ='$orderid'");
	$upd = mysql_fetch_assoc($res50);
	$updated = $upd['last_updated'];
	if ($updated == '0000-00-00 00:00:00') {}
	else {
	$x1 = 81;
    $y1 = 12;
    $x2 =128;
    $y2 = 20;
    $nbPointilles=11;
        $longueur=abs($x1-$x2);
       // $hauteur=abs($y1-$y2);
            $Pointilles=($longueur/$nbPointilles)/2; // taille des pointilles
   
    $this->SetDrawColor(0,0,0);
	$this->SetLineWidth(0.3); 
    for($l=81;$l<=127;$l+=$Pointilles+$Pointilles) { 
    $this->Line($l,12,$l+3,12);
    }         
    for($l=12;$l<=26;$l+=$Pointilles+$Pointilles) { 
    $this->Line(80,$l,80,$l+3);
    }
   for($l=81;$l<=127;$l+=$Pointilles+$Pointilles) { 
    $this->Line($l,28,$l+3,28);
    }         
	 for($l=12;$l<=25;$l+=$Pointilles+$Pointilles) { 
    $this->Line(128,$l,128,$l+3);
    }
    
	$updated2 = formatdate($updated);
	$day2  = date('d', strtotime($updated2));
	$month2  = date('m', strtotime($updated2));
	$year2  = date('y', strtotime($updated2));
	$updateddate= $month2.'/'.$day2.'/'.$year2;
	
	$timeorder10 = datetimeUS2Time($updated);
	$timeorder20= explode(':',$timeorder10);
	$timeorder30 = $timeorder20[0].':'.$timeorder20[1];
	$time10 = $timeorder20[2];
	$time20 =  explode(' ',$time10);
	$time30 = $time20[1];
	$updatetime = $timeorder30.' '.$time30;
	
	$this->SetXY(85,13);  
	$this->Cell(40,7,'UPDATED AT:',0,0, 'C');
	$this->Ln();
	$this->SetX(85);
	$this->Cell(40,7,$updateddate.' '.$updatetime,0,0, 'C');
	}
	$this->SetXY(140,15);  
	$nopage = $this->PageNo();
	$this->Cell(65,7,'Page '.$nopage.' of {nb}',0,0, 'R');
	//$orderid=$_GET["a"];
	    
    $this->SetFont('Times','B',10);
    $this->Image('template/images/custom/C2M_Logo.jpg',10,13,67,17);
    

    // Calcul de la largeur du titre et positionnement
    //$w = $this->GetStringWidth($titre)+6;
    //$this->SetX((210-$w)/2);
    // Couleurs du cadre, du fond et du texte
    //$this->SetDrawColor(0,80,180);
  	//$this->SetFillColor(204,0,0);
    //$this->SetTextColor(255,255,255); 
    // Epaisseur du cadre (1 mm)
    //$this->SetLineWidth(1);
    // Titre
   // $this->SetX(130);
   // $this->write(10,'Page '.$this->PageNo().' of {nb}');

     //$this->Ln(4);
    $res59 = mysql_query("SELECT id_order_proposal, order_for
	FROM order_proposals, order_requests
	WHERE  order_id = id_order
		and selected=1
	AND order_id = '$orderid'");
	$idproptmp = mysql_fetch_assoc($res59);
	$idprop = $idproptmp['id_order_proposal'];
    $this->SetTextColor(255,255,255);
    $this->SetFillColor(196,65,70);
    $this->SetXY(130,24);
  	$this->Cell(70,7,'Order Confirmation: '.$idprop,0,0,'C', true);

    // Saut de ligne
    $this->Ln(10);
	$this->SetLineWidth(1);
    $this->SetDrawColor(196,65,70);
    $this->Line(10,31,200,31);
}


// Pied de page
function Footer()
{
$orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
	//$orderid = '10417';
	$res10 = mysql_query("SELECT id_order_proposal, order_for
	FROM order_proposals, order_requests
	WHERE  order_id = id_order
	and selected=1
	AND order_id = '$orderid'");
	$footer = mysql_fetch_assoc($res10);
	$idprop = $footer['id_order_proposal'];
	$dateorder = $footer['order_for'];
	$dateorder = formatdate($dateorder);
	$day  = date('d', strtotime($dateorder));
	$month  = date('m', strtotime($dateorder));
	$year  = date('Y', strtotime($dateorder));
	$datenew= $month.'/'.$day.'/'.$year;
    // Positionnement ˆ 1,5 cm du bas
    $this->SetXY(10,-15);
    // Police Times italique 8
    $this->SetFont('Times','B',10);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(1);
    // NumŽro de page
       $this->Cell(90,7,'Questions? Reach us at help@cater2.me or (415) 343-5160 ','T',0,0,'L');
    $this->Cell(90,7,'Order ID & Date: '.$orderid.' - '.$idprop.'; '.$datenew,'T',0,0,'R');
}

function TitreChapitre($num, $libelle, $orderid2)
{
	$orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
   	$res6 = mysql_query("SELECT value
		FROM order_requests, catering_extra
		WHERE extra_label_id =4
		AND order_request_id = id_order
		AND id_order ='$orderid'");
  	$allergies = mysql_fetch_assoc($res6);
	$allerg = $allergies['value'];
	$res7 = mysql_query("SELECT notes FROM order_requests WHERE id_order='$orderid'");
  	$notesres = mysql_fetch_assoc($res7);
  	$notes = $notesres['notes'];
	$res8 = mysql_query("SELECT serving_instruction_id FROM order_requests_si WHERE order_id='$orderid'");
  	$sitmp = mysql_fetch_assoc($res8);
	$si = $sitmp['serving_instruction_id'];
		
	if ($num==1)
	{}
	else if ($num==4 and $allerg=='' and $notes=='' and  $si=='')
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

function CorpsChapitre($num,$text, $orderid2)
{
$this->SetTextColor(0,0,0);
if ($num==1)
   {
   	$orderid = $text['orderid'];
	$date = $text['date']; 
	$date1 = formatdate($date);
	$day  = date('l', strtotime($date1));
	$month  = date('F', strtotime($date1));
	$day2  = date('d', strtotime($date1));
	$year  = date('Y', strtotime($date1));
	
	$timeorder = datetimeUS2Time($date);
	$timeorder2 = explode(':',$timeorder);
	$timeorder3 = $timeorder2[0].':'.$timeorder2[1];
	$time1 = $timeorder2[2];
	$time2 =  explode(' ',$time1);
	$time3 = $time2[1];
	$newtimeorder = $timeorder3.' '.$time3;
	 
	$propid = $text['propid'];
	$company = $text['company'];
	$vendor = $text['vendor'];
	$nameclient = $text['nameclient'];
	$nbemp = $text['nbemp'];
	
	
	$neworder = $orderid;
	$neworder = ((($neworder * 45)+165)/2) ;
	$textCode = floor( $neworder);
	 if(strlen($textCode)>4)
	 { 
	 $textCode = substr($textCode, -4);   }
	 else  {
		 	if(strlen($textCode)==3)
		 	{ 
		 	$textCode = '1'.$textCode;}  
	 		}

    $this->SetFont('Times','B',10);   
	$this->Cell(45,6,'Delivery Date:',0,0,'L');
    $this->Cell(64,6,$day.', '.$month.' '.$day2.', '.$year ,0,0,'R');
    $this->SetXY(120,35);  
    $this->SetLineWidth(1); 
    $this->SetFont('Times','B',10);
    $this->Line(120,35,200,35);
    $this->Line(120,35,120,49);
    $this->Line(200,35,200,49);
    $this->Line(120,49,200,49);
    //$this->MultiCell(65,7,'Upon arrival at client site, text the following code to 415-944-4121: ','LTB');
    $this->MultiCell(65,6,'Upon arrival at client site, text the following code to 415-944-4121: ');
    $this->SetXY(185,37);
    $this->SetFillColor(255,255,0);
    $this->SetFont('Times','B',14);   
    $this->Cell(13,9, $textCode,0,0,'L',true);
    
	$this->SetXY(10,40); 
	$this->SetFillColor(255,255,255); 
	$this->SetFont('Times','B',10);
    $this->Cell(45,6,'Time (setup exactly at):',0,0,'L');
    $this->Cell(64,6,$newtimeorder,0,0,'R');
    $this->Ln();
    $this->SetFont('Times','',10);
   	$this->Cell(45,6,'Contact Name:',0,0,'L');
    $this->Cell(64,6,$nameclient,0,0,'R');	
    $this->SetXY(120,51);
    $this->SetFont('Times','B',10);
    $this->MultiCell(80,6,"If you're late, lost, or encounter any issues, call Cater2.me for assistance: 415-343-5160",1);
	$this->SetXY(10,52);  
	$this->SetFont('Times','',10);
   	$this->Cell(45,6,'Company Name / Vendor:',0,0,'L');
    $this->Cell(64,6,utf8_decode($company).' / '.utf8_decode($vendor),0,0,'R');
    $this->Ln();
   	$this->Cell(45,6,'Headcount:',0,0,'L');
    $this->Cell(64,7,$nbemp,0,0,'R');	
     $this->Cell(45,6,'',0,0,'L');
    $this->Ln();
	    
   
    }

else if ($num==2)
   {
    
   	$address = $text['address'];
	$city = $text['city']; 
	$zip = $text['zip'];
	$state = $text['state'];
	$delivery_instructions = $text['delivery_instructions'];
	$delivery_area = $text['delivery_area'];
	$add = $address.', '.$city.', '.$state.' '.$zip;
    $this->SetFont('Times','B',10);
    $this->Cell(45,5,'Address:',0,0,'L');    
    $this->MultiCell(0,5,$add);
    $this->Ln(1);
    
    $this->Cell(45,5,'Delivery Instructions:',0,0,'L');    
    $this->MultiCell(0,5,$delivery_instructions,0,'L');
    $this->Ln(1);
    $this->Cell(45,5,'Food setup instructions:',0,0,'L');    
    $this->MultiCell(0,5,$delivery_area,0,'L');
    //$this->Ln(3);
     $this->SetFont('Times','',10);   
       // $this->MultiCell(0,5,"address:".$address."------city:".$city."------zip:".$zip."------state:".$state."\n------delivery_instructions:".$delivery_instructions."\n------delivery_area:".$delivery_area);     
    }   
    else if ($num==3)
   {
   	//$orderid = '10417';
   	$orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
  	$res3 = mysql_query("SELECT label
			FROM catering_extra, catering_extra_labels
			WHERE catering_extra.extra_label_id = catering_extra_labels.id_extra
			AND order_request_id = '$orderid'");
	 $this->SetFont('Times','B',10);	
	$this->write(7,'  *CATER2.ME LABELS*  ');
	$this->write(7,'  *SERVING UTENSILS*  ');
		if(mysql_num_rows($res3))
			{
			while($sj = mysql_fetch_assoc($res3))
				{
					if ($sj['label'] == 'Utensils' or $sj['label'] == 'Paper Ware' or $sj['label'] == 'Table Clothes' or $sj['label'] == 'Chafing Dishes'){
					$cat= $sj['label'];
					$this->write(7,'  *'.$cat.'*  '); }
				}
			}
	$this->Ln();
 $this->SetFont('Times','',10);
    }  
   
else if ($num==4)
   {
   $orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
   //$orderid = '10417';
  	
  	$res6 = mysql_query("SELECT value
		FROM order_requests, catering_extra
		WHERE extra_label_id =4
		AND order_request_id = id_order
		AND id_order ='$orderid'");
  	$allergies = mysql_fetch_assoc($res6);
	$allerg = $allergies['value'];
	$res7 = mysql_query("SELECT notes FROM order_requests WHERE id_order='$orderid'");
  	$notesres = mysql_fetch_assoc($res7);
	$notes = $notesres['notes'];
	$res8 = mysql_query("SELECT label FROM order_requests_si,serving_instructions WHERE id_serving_instruction = serving_instruction_id and order_id='$orderid' ");
	
	while($si = mysql_fetch_assoc($res8))
				{	$inst[]= $si['label'];
				}

		If ($allerg=='' and $notes=='' and $inst[0]==''){	 }
	
	else {
	$this->Ln(1);
	If ($allerg==''){}
	else {
	$this->SetFont('Times','B',10);
	$this->SetFillColor(255,255,0);
    $this->Cell(45,5,'**ALLERGIES**',0,0,'L', true);    
    $this->Cell(0,5,$allerg, 0,0,'L',true);
	$this->Ln();
	}	

	If ($notes==''){}
	else {
	$this->SetFont('Times','B',10);
	$this->SetFillColor(255,255,0);
    $this->Cell(45,5,'**NOTES**',0,0,'L',true);    
    $this->MultiCell(0,5,$notes,0,'L',true);
	}
	
	
	If ($inst[0]==''){}
	else {	
	$this->SetFont('Times','B',10);
	$Ynote1=$this->getY();
	$this->MultiCell(90,5,$inst[0],0,'L');
	$Ynote1bis=$this->getY();
	$this->setXY(100,$Ynote1);
	$this->MultiCell(90,5,$inst[1],0,'L');
	$Ynote1bis2=$this->getY();
	if ($inst[2]=='') {} else {
	if ($Ynote1bis2>$Ynote1bis)
	{$this->setY($Ynote1bis2);} else {$this->setY($Ynote1bis);}
	$Ynote2=$this->getY();
	$this->MultiCell(90,5,$inst[2],0,'L');
	$Ynote2bis=$this->getY();
	$this->setXY(100,$Ynote2);
	$this->MultiCell(90,5,$inst[3],0,'L');}
	$Ynote2bis2=$this->getY();
	if ($inst[4]=='') {} else {
	if ($Ynote2bis2>$Ynote2bis)
	{$this->setY($Ynote2bis2);} else {$this->setY($Ynote2bis);}
	$Ynote3=$this->getY();
	$this->MultiCell(90,5,$inst[4],0,'L');
	$this->setXY(100,$Ynote3);
	$this->MultiCell(90,5,$inst[5],0,'L');
	}
	
	}
	

	}
	$this->Ln(1);
	 $this->SetFont('Times','',10);
    }  
    
    else if ($num==5)
    {
    
  	$orderidtmp=$_GET["a"];
$orderid =((((( $orderidtmp *2)+2) /152)-5));
  	//$orderid = '10417';
$res5 = mysql_query("SELECT count(id_vendor_item) as nb
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
and selected=1
AND order_proposals.order_id = '$orderid'");
$nbtemp = mysql_fetch_assoc($res5);
$nb = $nbtemp['nb'];
    $this->SetFont('Times','',10);
    $this->SetFillColor(255,255,255);
    $this->SetDrawColor(196,65,70);
    $this->SetLineWidth(1);
    $this->Cell(20,7,'Quantity','B',0,0,'L');
    $this->Cell(170,7,'Item Count ('.$nb.' items)','B',0,0,'R');
    $this->Ln();
	$nbitem = 1;
	
  	$res4 = mysql_query("SELECT vendor_items.menu_name as name, description, label, quantity, number_of_servings, order_proposal_items.notes as notes, non_menu_notes
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
and selected=1
AND order_proposals.order_id = '$orderid'
order by number_of_servings desc,id_food_category, quantity DESC");
		
			while($menu = mysql_fetch_assoc($res4))
				{	$Ypage = $this->GetY();
				//$this->Cell(6,7,$Ypage2,0,0,'C');
					$qte= $menu['quantity'];
					$name= $menu['name'];
					$name = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $name);
					$label= $menu['label'];
					$desc= $menu['description'];
					$desc = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $desc);
					$serv= $menu['number_of_servings'];
					$notes = $menu['notes'];
					$menu_notes = $menu['non_menu_notes'];
					if ($notes=='' and $menu_notes==''){$Ypagetest = 235 ;} 
					else if (strlen($desc)>1) {$Ypagetest = 225; }
					else if (strlen($menu_notes)>1) {$Ypagetest = 225; }
					else {$Ypagetest = 230; }   
					if ($Ypage > $Ypagetest ){ $this->Ln();
					
					$this->SetFont('Times','B',11);
					$this->Cell(0,6,'MENU CONTINUED ON NEXT PAGE',0,0,'C');
					$this->SetFont('Times','',10);
					$this->AddPage();
					$this->SetFont('Times','B',10);
					$this->SetTextColor(255,255,255);
					$this->SetFillColor(196,65,70);
					$this->Cell(0,6, 'Menu ('.$nb.' different items):',0,1,'C',true);
					 $this->SetFont('Times','',10);
					 $this->SetTextColor(0,0,0);
					$this->SetFillColor(255,255,255);
    				$this->SetDrawColor(196,65,70);
					$this->SetLineWidth(1);
    				$this->Cell(20,7,'Quantity','B',0,0,'L');
				    $this->Cell(170,7,'Item Count ('.$nb.' items)','B',0,0,'R');
				    $this->Ln();
					$this->SetTextColor(0,0,0);
					$this->SetFillColor(255,255,255);
					$this->SetFont('Times','',10);}
					
					$this -> setX(18);
					$this->Cell(6,7,$qte,0,0,'C');
					if ($nb >9){
					if ($nbitem >9){
					$this->Cell(125,7,$name.' (servings = '.$serv.')',0,0,'L');
					$this->Cell(30,7,utf8_decode($label).', ',0,0,'R');
					$this->Cell(20,7,'Item '.$nbitem.' of '.$nb,0,0,'R');}
					else 
					{
					$this->Cell(125,7,$name.' (servings = '.$serv.')',0,0,'L');
					$this->Cell(32,7,utf8_decode($label).', ',0,0,'R');
					$this->Cell(18,7,'Item '.$nbitem.' of '.$nb,0,0,'R');} }
					else {
					$this->Cell(125,7,$name.' (servings = '.$serv.')',0,0,'L');
					$this->Cell(34,7,utf8_decode($label).', ',0,0,'R');
					$this->Cell(16,7,'Item '.$nbitem.' of '.$nb,0,0,'R');}
					
					$this->Ln();
					
					if ($notes == '') {}
					else { 
					$Ypage2 = $this->GetY();
					$this->Cell(20,5,'',0,0,'L');
					$this->SetFont('Times','B',8);
					$this->Cell(0,5,$notes,0,0,'L');
					$this->SetFont('Times','',10);
					$this->Ln(); }
					if ($menu_notes == '') {}
					else {  
					$Ypage2 = $this->GetY();
					$this->Cell(20,5,'',0,0,'L');
					$this->SetFont('Times','B',8);
					$this->Cell(0,5,$menu_notes,0,0,'L');
					$this->SetFont('Times','',10);
					$this->Ln();}
					if ($desc == ''){
						}
					else {
					$Ypage2 = $this->GetY();
					$this->Cell(20,5,'',0,0,'L');
					$this->SetFont('Times','',8);
					$this->MultiCell(150,5,$desc);
					$this->SetFont('Times','',10);
					}
					 
					$nbitem ++;
				
				}
				$Yfin = $this->getY();
				
				if ($Yfin < 255 )
				{$this->SetLineWidth(0,7);
				$this->Cell(190,7,'','T',0,0,'L');	} else {}
				 
				}

}


function AjouterChapitre($num, $titre, $text, $orderid2)
{
    //$this->AddPage();
    $this->TitreChapitre($num,$titre, $orderid2);
  	$this->CorpsChapitre($num,$text, $orderid2);
}

}


$dimension = array(210,280);

$pdf=new PDF('P','mm', $dimension);
$orderidtmp=$_GET["a"];
$orderid2 =((((( $orderidtmp *2)+2) /152)-5));
$pdf->AddPage();
$pdf->AddFont('coolvetica_rg','','coolvetica_rg.php');


$res = mysql_query(" 
SELECT order_id, order_for, id_order_proposal, companies.name AS company, invoice_first_name, employees, companies.id_company AS id_comp
FROM companies, order_requests, order_proposals, clients
WHERE order_id ='$orderid2'
AND id_order = order_id
and selected = 1
AND companies.id_company = clients.company_id
AND id_client = order_requests.client_id
");
$info = mysql_fetch_assoc($res);
$res15=mysql_query(" 
SELECT vendors.name as vendor
from  vendors, order_proposals
where order_id = '$orderid2'
and selected=1
and order_proposals.vendor_id = vendors.id_vendor
");
$info2 = mysql_fetch_assoc($res15);

$res20=mysql_query(" 
SELECT id_client
FROM clients, order_requests
WHERE id_order ='$orderid2'
AND id_client = client_id
");
$info3 = mysql_fetch_assoc($res20);

$res30=mysql_query(" 
SELECT first_name
FROM users, order_requests, client_profiles
WHERE id_order =  '$orderid2'
AND client_profiles.id_profile = order_requests.client_profile_id
AND users.client_id = client_profiles.client_id 
order by id_user desc
");
$info4 = mysql_fetch_assoc($res30);

$order = $info['order_id'];
$date = $info['order_for'];
$propid = $info['id_order_proposal'];
$company = $info['company'];
$vendor = $info2['vendor'];
$nameclient = $info4['first_name'];
$nbemp = $info['employees'];
$id_comp = $info['id_comp'];
$idclient = $info3['id_client'];



$orderinfoarray = array("orderid" => $order, "date" => $date, "propid" => $propid,"company" => $company,"vendor" => $vendor,"nameclient" => $nameclient,"nbemp" => $nbemp, "id comp" => $id_comp, "id client" => $idclient);

$res2 = mysql_query(" 
SELECT address, city, state, zip, delivery_address, clients.delivery_instructions, clients.delivery_area, p.delivery_instructions AS instruction2, p.delivery_area AS area2
						 FROM companies, clients, order_requests, client_profiles p
						 WHERE id_company = company_id
						 AND id_client = p.client_id
						 AND client_profile_id = id_profile
					  	 AND id_order = '$order'
");

$infologistic = mysql_fetch_assoc($res2);
$address=$infologistic['address'];
$address2 = $infologistic['delivery_address'];
if ($address2 == '' ) {
$address=$infologistic['address'];
$delivery_instructions = $infologistic['delivery_instructions'];
$delivery_area = $infologistic['delivery_area'];
}
else {$address=$address2;
$delivery_instructions = $infologistic['instruction2'];
$delivery_area = $infologistic['area2'];

}
$city = $infologistic['city'];
$zip = $infologistic['zip'];
$state = $infologistic['state'];


$logisticinfoarray = array("address" => $address, "city" => $city, "zip" => $zip,"state" => $state,"delivery_instructions" => $delivery_instructions,"delivery_area" => $delivery_area);
//$pdf->Cell(0,10,'Hello '.$user,0,1);
$pdf->AjouterChapitre(1,'',$orderinfoarray, $orderid2 );
$pdf->AjouterChapitre(2,'Delivery Logistics:',$logisticinfoarray, $orderid2);
$pdf->AjouterChapitre(3,'Bring the following:','',$orderid2);
$pdf->AjouterChapitre(4,'Order Instructions:','',$orderid2);
$pdf->AjouterChapitre(5,'Menu ('.$nb.' different items):','',$orderid2);

$nb=$pdf->AliasNbPages();
$pdf->Output('Order Informations.pdf','I');


?>

