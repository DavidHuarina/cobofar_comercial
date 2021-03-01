<?php
require('fpdf.php');
require('conexionmysqli.inc');
require('funciones.php');
require('NumeroALetras.php');

$pdf=new FPDF('P','mm',array(76,300));
//$pdf->SetAutoPageBreak(false,0);
$pdf->SetMargins(0,0,0,0);
//$pdf->AddPage(); 
$pdf->SetFont('Arial','B',10);

//desde aca
$sqlConf="select id, txt1, txt2, txt3, alineado_izq, alineado_arriba, cantidad from etiquetas where id=1";
//echo $sqlConf;
$respConf=mysqli_query($enlaceCon,$sqlConf);
$txt1=mysqli_result($respConf,0,1);
$txt2=mysqli_result($respConf,0,2);
$txt3=mysqli_result($respConf,0,3);

$alignIzq=mysqli_result($respConf,0,4);
$alignTop=mysqli_result($respConf,0,5);
$cantidadPrint=mysqli_result($respConf,0,6);

$x=$alignIzq;
$y=$alignTop;
$pdf->AddPage();
for($i=1;$i<=$cantidadPrint;$i++){
	// 

	$pdf->SetXY($x+25,$y);		$pdf->Cell(40,3,$txt1,0,0,"C");
	$pdf->SetXY($x,$y+8);		$pdf->Cell(70,3,$txt2,0,0,"C");
	$pdf->SetXY($x,$y+12);		$pdf->Cell(70,3,$txt3,0,0,"C");	
	
	$y=$y+29;
}


$pdf->Output();
?>