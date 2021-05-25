<?php
$estilosVenta=1;
header('Content-Type: text/html; charset=UTF-8'); 
require('fpdf.php');
require('conexionmysqli2.inc');
require('funciones.php');
require('NumeroALetras.php');
include('phpqrcode/qrlib.php'); 

$codigoVenta=$_GET["codVenta"];

//consulta cuantos items tiene el detalle
$sqlNro="select count(*) from `salida_detalle_almacenes` s where s.`cod_salida_almacen`=$codigoVenta";
$respNro=mysqli_query($enlaceCon,$sqlNro);
$nroItems=mysqli_result($respNro,0,0);

$tamanoLargo=200+($nroItems*5)-3;

$pdf=new FPDF('P','mm',array(76,$tamanoLargo));
$pdf->SetMargins(0,0,0);
$pdf->AddPage(); 
$pdf->SetFont('Arial','',8);


$sqlConf="select id, valor from configuracion_facturas where id=1";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nombreTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=2";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$sucursalTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=3";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$direccionTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=4";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$telefonoTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=5";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$ciudadTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=6";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$txt1=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=7";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$txt2=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=8";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$txt3=mysqli_result($respConf,0,1);


$sqlConf="select id, valor from configuracion_facturas where id=9";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nitTxt=mysqli_result($respConf,0,1);

$sqlDatosFactura="select d.nro_autorizacion, DATE_FORMAT(d.fecha_limite_emision, '%d/%m/%Y'), f.codigo_control, f.nit, f.razon_social from facturas_venta f, dosificaciones d
	where f.cod_dosificacion=d.cod_dosificacion and f.cod_venta=$codigoVenta";
$respDatosFactura=mysqli_query($enlaceCon,$sqlDatosFactura);
$nroAutorizacion=mysqli_result($respDatosFactura,0,0);
$fechaLimiteEmision=mysqli_result($respDatosFactura,0,1);
$codigoControl=mysqli_result($respDatosFactura,0,2);
$nitCliente=mysqli_result($respDatosFactura,0,3);
$razonSocialCliente=mysqli_result($respDatosFactura,0,4);

//datos documento
$sqlDatosVenta="select DATE_FORMAT(s.fecha, '%d/%m/%Y'), t.`nombre`, c.`nombre_cliente`, s.`nro_correlativo`
		from `salida_almacenes` s, `tipos_docs` t, `clientes` c
		where s.`cod_salida_almacenes`='$codigoVenta' and s.`cod_cliente`=c.`cod_cliente` and
		s.`cod_tipo_doc`=t.`codigo`";
$respDatosVenta=mysqli_query($enlaceCon,$sqlDatosVenta);
while($datDatosVenta=mysqli_fetch_array($respDatosVenta)){
	$fechaVenta=$datDatosVenta[0];
	$nombreTipoDoc=$datDatosVenta[1];
	$nombreCliente=$datDatosVenta[2];
	$nroDocVenta=$datDatosVenta[3];
}

$y=5;
$incremento=3;

$pdf->SetXY(0,$y+3);		$pdf->Cell(0,0,$nombreTxt,0,0,"C");
$pdf->SetXY(0,$y+6);		$pdf->Cell(0,0,$sucursalTxt,0,0,"C");
$pdf->SetXY(5,$y+9);		$pdf->MultiCell(70,3,$direccionTxt, 0,"C");
$y=$y+6;
$pdf->SetXY(0,$y+12);		$pdf->Cell(0,0,"FACTURA", 0,0,"C");
$pdf->SetXY(0,$y+15);		$pdf->Cell(0,0,$ciudadTxt,0,0,"C");
$pdf->SetXY(0,$y+18);		$pdf->Cell(0,0,"-------------------------------------------------------------------------------", 0,0,"C");
$pdf->SetXY(0,$y+21);		$pdf->Cell(0,0,"NIT: $nitTxt", 0,0,"C");
$pdf->SetXY(0,$y+24);		$pdf->Cell(0,0,"$nombreTipoDoc Nro. $nroDocVenta", 0,0,"C");
$pdf->SetXY(0,$y+27);		$pdf->Cell(0,0,"Autorizacion Nro. $nroAutorizacion", 0,0,"C");


$pdf->SetXY(0,$y+30);		$pdf->Cell(0,0,"-------------------------------------------------------------------------------", 0,0,"C");
$pdf->SetXY(0,$y+32);		$pdf->MultiCell(0,3,$txt1,0,"C");
$pdf->SetXY(0,$y+42);		$pdf->Cell(0,0,"-------------------------------------------------------------------------------", 0,0,"C");

$y=$y+10;
$pdf->SetXY(0,$y+36);		$pdf->Cell(0,0,"FECHA: $fechaVenta",0,0,"C");
$pdf->SetXY(0,$y+39);		$pdf->Cell(0,0,"Sr(es): $razonSocialCliente",0,0,"C");
$pdf->SetXY(0,$y+42);		$pdf->Cell(0,0,"NIT/CI:	$nitCliente",0,0,"C");

$y=$y+3;
$pdf->SetXY(0,$y+45);		$pdf->Cell(0,0,"=================================================================================",0,0,"C");
$pdf->SetXY(15,$y+48);		$pdf->Cell(0,0,"ITEM");
$pdf->SetXY(50,$y+48);		$pdf->Cell(0,0,"Cant.");
$pdf->SetXY(58,$y+48);		$pdf->Cell(0,0,"Importe");
$pdf->SetXY(0,$y+52);		$pdf->Cell(0,0,"=================================================================================",0,0,"C");


$sqlDetalle="select m.codigo_material, sum(s.`cantidad_unitaria`), m.`descripcion_material`, s.`precio_unitario`, 
		sum(s.`descuento_unitario`), sum(s.`monto_unitario`) from `salida_detalle_almacenes` s, `material_apoyo` m where 
		m.`codigo_material`=s.`cod_material` and s.`cod_salida_almacen`=$codigoVenta 
		group by s.cod_material
		order by 3";
$respDetalle=mysqli_query($enlaceCon,$sqlDetalle);

$yyy=55;

$montoTotal=0;
while($datDetalle=mysqli_fetch_array($respDetalle)){
	$codInterno=$datDetalle[0];
	$cantUnit=$datDetalle[1];
	$cantUnit=redondear2($cantUnit);
	$nombreMat=$datDetalle[2];
	$precioUnit=$datDetalle[3];
	$precioUnit=redondear2($precioUnit);
	$descUnit=$datDetalle[4];
	$montoUnit=$datDetalle[5];
	$montoUnit=redondear2($montoUnit);
	
	$pdf->SetXY(5,$y+$yyy);		$pdf->MultiCell(50,3,"$nombreMat","C");
	$pdf->SetXY(56,$y+$yyy+1);		$pdf->Cell(0,0,"$cantUnit");
	$pdf->SetXY(61,$y+$yyy+1);		$pdf->Cell(0,0,"$montoUnit");
	$montoTotal=$montoTotal+$montoUnit;
	
	$yyy=$yyy+6;
}
$pdf->SetXY(0,$y+$yyy+2);		$pdf->Cell(0,0,"=================================================================================",0,0,"C");		
$yyy=$yyy+5;


$pdf->SetXY(42,$y+$yyy);		$pdf->Cell(0,0,"Total Venta:  $montoTotal",0,0);
$pdf->SetXY(44,$y+$yyy+4);		$pdf->Cell(0,0,"Descuento:  0",0,0);
$pdf->SetXY(43,$y+$yyy+8);		$pdf->Cell(0,0,"Total Final:  $montoTotal",0,0);

$datosTot=explode('.', $montoTotal);
if(isset($datosTot[1])){
	list($montoEntero, $montoDecimal) = explode('.', $montoTotal);
}else{
	list($montoEntero, $montoDecimal) = [$montoTotal,0];
}

if($montoDecimal==""){
	$montoDecimal="00";
}
$txtMonto=NumeroALetras::convertir($montoEntero);
$pdf->SetXY(5,$y+$yyy+11);		$pdf->MultiCell(0,3,"Son:  $txtMonto"." ".$montoDecimal."/100 Bolivianos",0,"L");
$pdf->SetXY(0,$y+$yyy+19);		$pdf->Cell(0,0,"=================================================================================",0,0,"C");		

$yyy=$yyy+10;
$pdf->SetXY(5,$y+$yyy+16);		$pdf->Cell(0,0,"CODIGO DE CONTROL: $codigoControl",0,0,"C");
$pdf->SetXY(5,$y+$yyy+20);		$pdf->Cell(0,0,"FECHA LIMITE DE EMISION: $fechaLimiteEmision",0,0,"C");
$pdf->SetXY(5,$y+$yyy+23);		$pdf->Cell(0,0,"-------------------------------------------------------------------------------",0,0,"C");


$pdf->SetXY(10,$y+$yyy+25);		$pdf->MultiCell(60,3,$txt2,0,"C");

//GENERAMOS LA CADENA DEL QR
$cadenaQR=$nitTxt."|".$nroDocVenta."|".$nroAutorizacion."|".$fechaVenta."|".$montoTotal."|".$montoTotal."|".$codigoControl."|".$nitCliente."|0|0|0|0";
$codeContents = $cadenaQR; 

$fechahora=date("dmy.His");
$fileName="qrs/".$fechahora.$nroDocVenta.".png"; 
    
QRcode::png($codeContents, $fileName,QR_ECLEVEL_L, 4);

$pdf->Image($fileName , 23 ,$y+$yyy+38, 30, 30,'PNG');

$pdf->SetXY(5,$y+$yyy+68);		$pdf->MultiCell(60,3,$txt3,0,"C");

//$pdf->Output();




//DESDE ACA SALDRIA LA SEGUNDA PAGINA



$tamanoLargo=200+($nroItems*3)-3;

//$pdf=new FPDF('P','mm',array(76,$tamanoLargo));
//$pdf->SetMargins(0,0,0);
$pdf->AddPage(); 
$pdf->SetFont('Arial','',8);

$y=0;
$incremento=3;

$y=$y+(-15);
$pdf->SetXY(0,$y+24);		$pdf->Cell(0,0,"$nombreTipoDoc Nro. $nroDocVenta", 0,0,"C");

$y=$y+(-8);
$pdf->SetXY(0,$y+36);		$pdf->Cell(0,0,"FECHA: $fechaVenta",0,0,"C");
$pdf->SetXY(0,$y+39);		$pdf->Cell(0,0,"Sr(es): $razonSocialCliente",0,0,"C");

$y=$y+(-2);
$pdf->SetXY(0,$y+45);		$pdf->Cell(0,0,"=================================================================================",0,0,"C");
$pdf->SetXY(15,$y+48);		$pdf->Cell(0,0,"ITEM");
$pdf->SetXY(50,$y+48);		$pdf->Cell(0,0,"Cant.");
$pdf->SetXY(58,$y+48);		$pdf->Cell(0,0,"Importe");
$pdf->SetXY(0,$y+52);		$pdf->Cell(0,0,"=================================================================================",0,0,"C");


$sqlDetalle="select m.codigo_material, sum(s.`cantidad_unitaria`), m.`descripcion_material`, s.`precio_unitario`, 
		sum(s.`descuento_unitario`), sum(s.`monto_unitario`) from `salida_detalle_almacenes` s, `material_apoyo` m where 
		m.`codigo_material`=s.`cod_material` and s.`cod_salida_almacen`=$codigoVenta 
		group by s.cod_material
		order by 3";
$respDetalle=mysqli_query($enlaceCon,$sqlDetalle);

$yyy=55;

$montoTotal=0;
while($datDetalle=mysqli_fetch_array($respDetalle)){
	$codInterno=$datDetalle[0];
	$cantUnit=$datDetalle[1];
	$cantUnit=redondear2($cantUnit);
	$nombreMat=$datDetalle[2];
	$precioUnit=$datDetalle[3];
	$precioUnit=redondear2($precioUnit);
	$descUnit=$datDetalle[4];
	$montoUnit=$datDetalle[5];
	$montoUnit=redondear2($montoUnit);
	
	$pdf->SetXY(5,$y+$yyy);		$pdf->MultiCell(50,3,"$nombreMat","C");
	$pdf->SetXY(56,$y+$yyy+1);		$pdf->Cell(0,0,"$cantUnit");
	$pdf->SetXY(61,$y+$yyy+1);		$pdf->Cell(0,0,"$montoUnit");
	$montoTotal=$montoTotal+$montoUnit;
	
	$yyy=$yyy+6;
}
$pdf->SetXY(0,$y+$yyy+2);		$pdf->Cell(0,0,"=================================================================================",0,0,"C");		
$yyy=$yyy+5;


$pdf->SetXY(42,$y+$yyy);		$pdf->Cell(0,0,"Total Venta:  $montoTotal",0,0);
$pdf->SetXY(44,$y+$yyy+4);		$pdf->Cell(0,0,"Descuento:  0",0,0);
$pdf->SetXY(43,$y+$yyy+8);		$pdf->Cell(0,0,"Total Final:  $montoTotal",0,0);

$datosTot=explode('.', $montoTotal);
if(isset($datosTot[1])){
	list($montoEntero, $montoDecimal) = explode('.', $montoTotal);
}else{
	list($montoEntero, $montoDecimal) = [$montoTotal,0];
}


if($montoDecimal==""){
	$montoDecimal="00";
}
$txtMonto=NumeroALetras::convertir($montoEntero);
$pdf->SetXY(5,$y+$yyy+11);		$pdf->MultiCell(0,3,"Son:  $txtMonto"." ".$montoDecimal."/100 Bolivianos",0,"L");

$pdf->Output();




?>