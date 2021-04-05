<?php
$estilosVenta=1;
require("../conexionmysqli.inc");
require("../funciones.php");

$fecha = $_GET["fecha"];
$rpt_territorio=$_COOKIE["global_agencia"];
$rpt_funcionario=$_COOKIE["global_usuario"];
$sql="select s.`monto_final`, s.cod_tipopago
	from `salida_almacenes` s where s.`cod_tiposalida`=1001 and s.salida_anulada=0 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad`='$rpt_territorio')
	and STR_TO_DATE(CONCAT(s.fecha,' ',s.hora_salida),'%Y-%m-%d %h:%i') BETWEEN '$fecha 00:00:00' and '$fecha 23:59:59' and s.`cod_chofer`='$rpt_funcionario' ";

$resp=mysqli_query($enlaceCon,$sql);

$totalEfectivo=0;
$totalTarjeta=0;
while($datos=mysqli_fetch_array($resp)){	
	$montoVenta=$datos[0];
	$totalVenta=$totalVenta+$montoVenta;
	$codTipoPago=$datos[1];
	if($codTipoPago==1){
		$totalEfectivo+=$montoVenta;
	}else{
		$totalTarjeta+=$montoVenta;
	}
}

echo number_format($totalEfectivo,2,'.','');