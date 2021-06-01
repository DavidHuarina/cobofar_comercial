<script type="text/javascript">
	function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
}
</script>
<?php
$estilosVenta=1;
require('conexionmysqli2.inc');
require('funciones.php');
require('NumeroALetras.php');
include('phpqrcode/qrlib.php'); 
?>
<style type="text/css">
	.arial-12{
        font-size: 14px;
	}
	.arial-7{
        font-size: 12px;
	}
	.arial-8{
        font-size: 13px;
	}
</style>
<?php
$cod_ciudad=$_COOKIE["global_agencia"];
$codigoVenta=$_GET["codVenta"];

//consulta cuantos items tiene el detalle
$sqlNro="select count(*) from `salida_detalle_almacenes` s where s.`cod_salida_almacen`=$codigoVenta";
$respNro=mysqli_query($enlaceCon,$sqlNro);
$nroItems=mysqli_result($respNro,0,0);

$tamanoLargo=230+($nroItems*5)-5;

?><div style="width:320;margin:0;padding-left:30px !important;padding-right:30px !important;height:<?=$tamanoLargo?>; font-family:Arial;">
<?php	

$sqlConf="select id, valor from configuracion_facturas where id=1 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nombreTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=10 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nombreTxt2=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=2 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$sucursalTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=3 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$direccionTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=4 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$telefonoTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=5 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$ciudadTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=6 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$txt1=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=7 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$txt2=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=8 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$txt3=mysqli_result($respConf,0,1);


$sqlConf="select id, valor from configuracion_facturas where id=9 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nitTxt=mysqli_result($respConf,0,1);

$sqlDatosFactura="select d.nro_autorizacion, DATE_FORMAT(d.fecha_limite_emision, '%d/%m/%Y'), f.codigo_control, f.nit, f.razon_social, DATE_FORMAT(f.fecha, '%d/%m/%Y') from facturas_venta f, dosificaciones d
	where f.cod_dosificacion=d.cod_dosificacion and f.cod_venta=$codigoVenta";
//echo $sqlDatosFactura;
$respDatosFactura=mysqli_query($enlaceCon,$sqlDatosFactura);
$nroAutorizacion=mysqli_result($respDatosFactura,0,0);
$fechaLimiteEmision=mysqli_result($respDatosFactura,0,1);
$codigoControl=mysqli_result($respDatosFactura,0,2);
$nitCliente=mysqli_result($respDatosFactura,0,3);
$razonSocialCliente=mysqli_result($respDatosFactura,0,4);
$razonSocialCliente=strtoupper($razonSocialCliente);
$fechaFactura=mysqli_result($respDatosFactura,0,5);


//datos documento
$sqlDatosVenta="select DATE_FORMAT(s.fecha, '%d/%m/%Y'), t.`nombre`, c.`nombre_cliente`, s.`nro_correlativo`, s.descuento, s.hora_salida
		from `salida_almacenes` s, `tipos_docs` t, `clientes` c
		where s.`cod_salida_almacenes`='$codigoVenta' and s.`cod_cliente`=c.`cod_cliente` and
		s.`cod_tipo_doc`=t.`codigo`";
$respDatosVenta=mysqli_query($enlaceCon,$sqlDatosVenta);
while($datDatosVenta=mysqli_fetch_array($respDatosVenta)){
	$fechaVenta=$datDatosVenta[0];
	$nombreTipoDoc=$datDatosVenta[1];
	$nombreCliente=$datDatosVenta[2];
	$nroDocVenta=$datDatosVenta[3];
	$descuentoVenta=$datDatosVenta[4];
	$descuentoVenta=redondear2($descuentoVenta);
	$horaFactura=$datDatosVenta[5];
}

$y=5;
$incremento=3;
?>
<br>
<center><p class="arial-12"><?=$nombreTxt?></p>
<p class="arial-12"><?=$nombreTxt2?></p>
<label class="arial-12"><?=$sucursalTxt?></label><br>
<label class="arial-12"><?=$direccionTxt?></label><br><br>
<label class="arial-12">FACTURA</label><br>
<label class="arial-12"><?=$ciudadTxt?></label><br>
<label class="arial-12"><?="Telefono ".$telefonoTxt?></label><br>
<label class="arial-12"><?="-------------------------------------------------------"?></label><br>
<label class="arial-12"><?="NIT: $nitTxt"?></label><br>
<label class="arial-12"><?="$nombreTipoDoc Nro. $nroDocVenta"?></label><br>
<label class="arial-12"><?="Autorizacion Nro. $nroAutorizacion"?></label><br>
<label class="arial-12"><?="--------------------------------------------------------"?></label><br>
<label class="arial-12"><?=utf8_decode($txt1)?></label><br>
<label class="arial-12"><?="--------------------------------------------------------"?></label><br><br>
<label class="arial-12"><?="FECHA: $fechaFactura $horaFactura"?></label><br>
<label class="arial-12"><?="Sr(es): ".utf8_decode($razonSocialCliente).""?></label><br>
<label class="arial-12"><?="NIT/CI:	$nitCliente"?></label><br><br>
<label class="arial-12"><?="======================================"?></label><br>
<table width="100%"><tr align="center" class="arial-12"><td><?="CANT."?></td><td><?="P.U."?></td><td><?="IMPORTE"?></td></tr></table>
<label class="arial-12"><?="======================================"?></label><br>
<?php
$sqlDetalle="select m.codigo_material, sum(s.`cantidad_unitaria`), m.`descripcion_material`, s.`precio_unitario`, 
		sum(s.`descuento_unitario`), sum(s.`monto_unitario`) from `salida_detalle_almacenes` s, `material_apoyo` m where 
		m.`codigo_material`=s.`cod_material` and s.`cod_salida_almacen`=$codigoVenta 
		group by s.cod_material
		order by s.orden_detalle";
$respDetalle=mysqli_query($enlaceCon,$sqlDetalle);

$yyy=65;

$montoTotal=0;
while($datDetalle=mysqli_fetch_array($respDetalle)){
	$codInterno=$datDetalle[0];
	$cantUnit=$datDetalle[1];
	$nombreMat=$datDetalle[2];
	$precioUnit=$datDetalle[3];
	$descUnit=$datDetalle[4];
	//$montoUnit=$datDetalle[5];
	$montoUnit=($cantUnit*$precioUnit)-$descUnit;
	
	//recalculamos el precio unitario para mostrar en la factura.
	$precioUnitFactura=$montoUnit/$cantUnit;
	
	$cantUnit=redondear2($cantUnit);
	$precioUnit=redondear2($precioUnit);
	$montoUnit=redondear2($montoUnit);
	
	$precioUnitFactura=redondear2($precioUnitFactura);
	
	?>
    <table width="100%"><tr align="center" class="arial-7"><td><?=$codInterno?></td><td colspan="2"><?=$nombreMat?></td></tr>
    <tr align="center" class="arial-8"><td><?="$cantUnit"?></td><td><?="$precioUnitFactura"?></td><td><?="$montoUnit"?></td></tr></table>
	<?php
	$montoTotal=$montoTotal+$montoUnit;	
	$yyy=$yyy+6;
}
$montoFinal=$montoTotal-$descuentoVenta;
 ?>
<label class="arial-12"><?="======================================"?></label><br>
<table width="100%">
	<tr align="center" class="arial-8"><td width="60%"></td><td><?="Total Venta:  $montoTotal"?></td></tr>
	<tr align="center" class="arial-8"><td width="60%"></td><td><?="Descuento:  $descuentoVenta"?></td></tr>
	<tr align="center" class="arial-8"><td width="60%"></td><td><?="Total Final:  $montoFinal"?></td></tr>
</table>
<?php
$arrayDecimal=explode('.', $montoFinal);
if(count($arrayDecimal)>1){
	list($montoEntero, $montoDecimal) = explode('.', $montoFinal);
}else{
	list($montoEntero,$montoDecimal)=array($montoFinal,0);
}

if($montoDecimal==""){
	$montoDecimal="00";
}
$txtMonto=NumeroALetras::convertir($montoEntero);
?>
<label class="arial-12"><?="Son:  $txtMonto"." ".$montoDecimal."/100 Bolivianos"?></label><br><br>
<label class="arial-12"><?="======================================"?></label><br>
<label class="arial-12"><?="CODIGO DE CONTROL: $codigoControl"?></label><br>
<label class="arial-12"><?="FECHA LIMITE DE EMISION: $fechaLimiteEmision"?></label><br>
<label class="arial-12"><?="--------------------------------------------------------"?></label><br>
<div style="width:75%"><label class="arial-12"><?=$txt2?></label><br></div>
<?php
$cadenaQR=$nitTxt."|".$nroDocVenta."|".$nroAutorizacion."|".$fechaVenta."|".$montoTotal."|".$montoTotal."|".$codigoControl."|".$nitCliente."|0|0|0|0";
$codeContents = $cadenaQR; 

$fechahora=date("dmy.His");
$fileName="qrs/".$fechahora.$nroDocVenta.".png"; 
    
QRcode::png($codeContents, $fileName,QR_ECLEVEL_L, 4);

$txt3=iconv('utf-8', 'windows-1252', $txt3); 
?>
<img src="<?=$fileName?>">
<div style="width:80%"><label class="arial-12"><?=$txt3?></label><br></div>
<?php

$sqlGlosa="select cod_tipopreciogeneral from `salida_almacenes` s where s.`cod_salida_almacenes`=$codigoVenta";
$respGlosa=mysqli_query($enlaceCon,$sqlGlosa);
$codigoPrecio=mysqli_result($respGlosa,0,0);
$txtGlosaDescuento="";
$sql1="SELECT glosa_factura from tipos_preciogeneral where codigo=$codigoPrecio and glosa_estado=1";
$resp1=mysqli_query($enlaceCon,$sql1);
while($filaDesc=mysqli_fetch_array($resp1)){	
	    $txtGlosaDescuento=iconv('utf-8', 'windows-1252', $filaDesc[0]);		
}
if($txtGlosaDescuento!=""){
	?><label class="arial-12"><?="-------------------------------------------------------------------------------"?></label><br>
	<div style="width:80%"><label class="arial-7"><?=$txtGlosaDescuento?></label><br></div><?php
}
?>
</center>
</div>
<script type="text/javascript">
 javascript:window.print();
 setTimeout(function () { window.location.href="registrar_salidaventas.php";}, 100);
</script>
