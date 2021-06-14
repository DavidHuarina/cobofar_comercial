<?php
// require_once '../conexion_prueba.php'; 
// require_once '../styles.php';
// // require_once 'configModule.php';
// require_once '../functions.php';
// require_once '../layouts/bodylogin2.php';
if( !function_exists('ceiling') )
{
    function ceiling($number, $significance = 1)
    {
        return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
    }
}

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

$respTarjeta=mysqli_query($enlaceCon,$sqlTarjetas);
$respAnuladoReal=mysqli_query($enlaceCon,$sqlAnuladoReal);
?>

<table class="textomediano" align='center' width='100%'>
  <thead>
    
  	<tr><th colspan='8'>Reporte Arqueo Diario de Caja </th></tr>
  	<tr><th colspan='8'>Fecha Arqueo: <?=strftime('%d/%m/%Y',strtotime($fecha_ini));?>  &nbsp;&nbsp;&nbsp; Fecha Reporte: <?=$fecha_reporte?> </th></tr>
  	<tr><th colspan='8'>Detalle de Ventas </th></tr>
	<tr>
		<th>Fecha</th>
		<th>Personal</th>
		<th>Ventas Efectivo [Bs]</th>
		<th>Ventas Tarjeta</th>
		<th>Anulados </th>
		<th>Monto a Depositar [Bs]</th>
		<th>Monto Depositado [Bs]</th>
		<th>TOTAL VENTAS [Bs]</th>
	</tr>
  </thead>
  <tbody>
    <?php $index=1;
      $totalEfectivo=0;
		$totalTarjetas=0;
		$totalAnuladas=0;
		$total_ventas=0;
		$totaldepositar=0;
		$totaldepositado=0;
		$sql="SELECT s.`fecha`, sum(s.`monto_final`),s.cod_chofer
			from `salida_almacenes` s where s.`cod_tiposalida`=1001 and s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a
			where a.`cod_ciudad`='$rpt_territorio' and cod_tipoalmacen=1) and CONCAT(s.fecha,' ',s.hora_salida) BETWEEN '$fecha_iniconsultahora' and '$fecha_finconsultahora' and s.cod_tipopago=1 
			GROUP BY s.cod_chofer,s.cod_tipopago,s.fecha order by s.fecha,s.cod_chofer";
			//echo $sql;
			$resp=mysqli_query($enlaceCon,$sql);
		while($datos=mysqli_fetch_array($resp)){
		    $codigoSalida=$datos['cod_salida_almacenes'];	
			$fechaVenta=$datos[0];
			$cod_personal=$datos['cod_chofer'];
			$montoefectivo=$datos[1];
			$montoefectivo=ceiling($montoefectivo,0.1);
			$montoTarjeta=obtenerMontoTarjeta_ventas($fechaVenta,$rpt_territorio,$cod_personal);
			$montoAnulada=obtenerMontoAnuladas_ventas($fechaVenta,$rpt_territorio,$cod_personal);
			$monto_depositado=obtenerMontodepositado($fechaVenta,$cod_personal);
			$monto_venta=$montoefectivo+$montoTarjeta-$montoAnulada;
			$monto_depositar=$montoefectivo-$montoAnulada;
			$totalEfectivo+=$montoefectivo;	
			$totalTarjetas+=$montoTarjeta;	
			$totalAnuladas+=$montoAnulada;
			$totaldepositar+=$monto_depositar;
			$totaldepositado+=$monto_depositado;
			$total_ventas+=$monto_venta;
			$personalCliente=nombreVisitador($cod_personal);
			?>
			<tr>
				<td><?=$fechaVenta?></td>
				<td><?=$personalCliente?></td>
				<td align='right'><?=number_format($montoefectivo,2,".",",")?></td>
				<td align='right'><?=number_format($montoTarjeta,2,".",",")?></td>
				<td align='right'><?=number_format($montoAnulada,2,".",",")?></td>
				<td align='right'><?=number_format($monto_depositar,2,".",",")?></td>
				<td align='right'><?=number_format($monto_depositado,2,".",",");?></td>
				<td align='right'><?=number_format($monto_venta,2,".",",");?></td>
			</tr>
		<?php } ?>
		<tr>
			<td>&nbsp;</td>
			<th>Total:</th>
			<th align='right'><?=number_format($totalEfectivo,2,".",",")?></th>
			<th align='right'><?=number_format($totalTarjetas,2,".",",")?></th>
			<th align='right'><?=number_format($totalAnuladas,2,".",",")?></th>
			<th align='right'><?=number_format($totaldepositar,2,".",",")?></th>
			<th align='right'><?=number_format($totaldepositado,2,".",",")?></th>
			<th align='right'><?=number_format($total_ventas,2,".",",")?></th>
		</tr>
       
   
  </tbody>
</table>


