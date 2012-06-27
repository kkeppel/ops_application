<?php
require 'fpdf17/fpdf.php'

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello Cater2me !');
$pdf->Output();
?>
