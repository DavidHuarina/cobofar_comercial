<?php

if( !function_exists('ceiling') )
{
    function ceiling($number, $significance = 1)
    {
        return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
    }
}

ob_start();
error_reporting(0);
require('estilos_reportes_almacencentral.php');
require('function_formatofecha.php');
require('conexionmysqli2.inc');
require('funcion_nombres.php');
require('funciones.php');

$rpt_territorio=$_GET['rpt_territorio'];
//$rpt_funcionario=$_GET['rpt_funcionario'];
$fecha_ini=$_GET['fecha_ini'];
$fecha_fin=$_GET['fecha_fin'];
$hora_ini=$_GET['hora_ini'];
$hora_fin=$_GET['hora_fin'];
$variableAdmin=$_GET["variableAdmin"];
if($variableAdmin!=1){
	$variableAdmin=0;
}

//desde esta parte viene el reporte en si
$fecha_iniconsulta=$fecha_ini;
$fecha_iniconsultahora=$fecha_iniconsulta." ".$hora_ini.":00";
$fecha_finconsultahora=$fecha_fin." ".$hora_fin.":59";
$fecha_reporte=date("d/m/Y");
$montoCajaChica=0;
echo "<center><h3>Reporte Arqueo Diario de Caja S.</h3>
	<h3>Fecha Arqueo: ".strftime('%d/%m/%Y',strtotime($fecha_ini))." &nbsp;&nbsp;&nbsp; Fecha Reporte: $fecha_reporte</h3></center>";


	
$sql="select s.`fecha`, sum(s.`monto_final`),s.cod_chofer
from `salida_almacenes` s where s.`cod_tiposalida`=1001 and s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a
where a.`cod_ciudad`='$rpt_territorio' and cod_tipoalmacen=1) and CONCAT(s.fecha,' ',s.hora_salida) BETWEEN '$fecha_iniconsultahora' and '$fecha_finconsultahora' and s.cod_tipopago=1 
GROUP BY s.cod_chofer,s.cod_tipopago,s.fecha
";


$resp=mysqli_query($enlaceCon,$sql);
$respTarjeta=mysqli_query($enlaceCon,$sqlTarjetas);
$respAnuladoReal=mysqli_query($enlaceCon,$sqlAnuladoReal);


echo "<br><table align='center' class='textomediano' width='100%'>
<tr><th colspan='6'>Detalle de Ventas (EFECTIVO)</th></tr>
<tr>
<th>Fecha</th>
<th>Personal</th>
<th>Efectivo [Bs]</th>
<th>Tarjeta</th>
<th>Anulados [Bs]</th>
<th>TOTAL VENTAS [Bs]</th>
</tr>";

$totalEfectivo=0;
$totalTarjetas=0;
$totalAnuladas=0;
$total_ventas=0;
while($datos=mysqli_fetch_array($resp)){
    $codigoSalida=$datos['cod_salida_almacenes'];	
	$fechaVenta=$datos[0];
	$cod_personal=$datos['cod_chofer'];
	$montoefectivo=$datos[1];
	$montoefectivo=ceiling($montoefectivo,0.1);
	$montoTarjeta=obtenerMontoTarjeta_ventas($fechaVenta,$rpt_territorio,$cod_personal);
	$montoAnulada=obtenerMontoAnuladas_ventas($fechaVenta,$rpt_territorio,$cod_personal);;
	$monto_venta=$montoefectivo+$montoTarjeta-$montoAnulada;
	$totalEfectivo=$totalEfectivo+$montoefectivo;	
	$totalTarjetas=$totalTarjetas+$montoTarjeta;	
	$totalAnuladas=$totalAnuladas+$montoAnulada;
	$total_ventas+=$monto_venta;
	$personalCliente=nombreVisitador($cod_personal);
	$formato_montoefectivo=number_format($montoefectivo,2,".",",");
	$formato_montoTarjeta=number_format($montoTarjeta,2,".",",");
	$formato_montoAnulada=number_format($montoAnulada,2,".",",");
	$formato_montoVenta=number_format($monto_venta,2,".",",");

	echo "<tr>
	<td>$fechaVenta</td>
	<td>$personalCliente</td>
	<td align='right'>$formato_montoefectivo</td>
	<td align='right'>$formato_montoTarjeta</td>
	<td align='right'>$formato_montoAnulada</td>
	<td align='right'>$formato_montoVenta</td>
	</tr>";
	
	
}

echo "<tr>
	<td>&nbsp;</td>
	<th>Total:</th>
	<th align='right'>$totalEfectivo</th>
	<th align='right'>$totalTarjetas</th>
	<th align='right'>$totalAnuladas</th>
	<th align='right'>$total_ventas</th>
</tr>";
echo "</table></br>";

$html = ob_get_clean();

$nombreFuncionario=nombreVisitador($rpt_funcionario);
if(!isset($_GET["ruta"])){	
	descargarPDFArqueoCaja("Cierre.".strftime('%d-%m-%Y',strtotime($fecha_ini)).".".$nombreFuncionario,$html);	
}else{
	$rutaCompleta=$_GET["ruta"];
	$rutaCompleta=str_replace("@","/",$rutaCompleta);
	guardarPDFArqueoCaja("Cierre.".strftime('%d-%m-%Y',strtotime($fecha_ini)).".".$nombreFuncionario,$html,$rutaCompleta);
	echo "<script language='Javascript'>
      alert('Los datos fueron registrados exitosamente.');
      location.href='depositos/list.php';
      </script>";
}

?>



