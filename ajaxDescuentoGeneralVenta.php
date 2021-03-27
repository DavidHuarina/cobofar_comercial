<?php
require("funciones.php");
require("conexionmysqli.inc");


$monto_total = $_GET["monto_total"];
if(!isset($fecha)||$fecha==""){   
	$fecha=date("d/m/Y");
}
$fechaDesc=explode("/",$fecha);
$fechaCompleta=$fechaDesc[2]."-".$fechaDesc[1]."-".$fechaDesc[0];
$ciudad=$_COOKIE['global_agencia'];
$sql1="select t.codigo,t.abreviatura,t.nombre from tipos_preciogeneral t where '$fechaCompleta 00:10:00' between t.desde and t.hasta  and estado=1 and cod_estadodescuento=3 and $ciudad in (SELECT cod_ciudad from tipos_preciogeneral_ciudad where cod_tipoprecio=t.codigo) and t.monto_inicio<=$monto_total and monto_final>=$monto_total LIMIT 1";
$resp1=mysqli_query($enlaceCon,$sql1);
$codigoDescuentoGeneral=0;
$porcentajeDescuentoReal=0;
$porcentajeDescuentoRealNombre="Descuento";
while($filaDesc=mysqli_fetch_array($resp1)){
	    $codigoDescuentoGeneral=$filaDesc[0];	
		$porcentajeDescuentoReal=$filaDesc[1];	
		$porcentajeDescuentoRealNombre="(".$filaDesc[2].")";	
}

echo "#####".$codigoDescuentoGeneral."#####".$porcentajeDescuentoReal."#####".$porcentajeDescuentoRealNombre;
?>
