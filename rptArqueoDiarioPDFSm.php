<?php
if( !function_exists('ceiling') )
{
    function ceiling($number, $significance = 1)
    {
        return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
    }
}
$estilosVenta=1;
require('conexionmysqli2.inc');
require('NumeroALetras.php');
include('phpqrcode/qrlib.php'); 

//require('estilos_reportes_almacencentral.php');
require('function_formatofecha.php');
require('funcion_nombres.php');
require('funciones.php');

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
$tamanoLargo=230+($nroItems*5)-5;

$rpt_territorio=$_GET['rpt_territorio'];
$rpt_funcionario=$_GET['rpt_funcionario'];
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

$sql="select s.`fecha`,  
	(select c.nombre_cliente from clientes c where c.`cod_cliente`=s.cod_cliente) as cliente, 
	s.`razon_social`, s.`observaciones`, 
	(select t.`abreviatura` from `tipos_docs` t where t.`codigo`=s.cod_tipo_doc),
	s.`nro_correlativo`, s.`monto_final`, s.cod_tipopago, (select tp.nombre_tipopago from tipos_pago tp where tp.cod_tipopago=s.cod_tipopago), 
	s.hora_salida,s.cod_chofer,s.monto_cancelado_usd,s.tipo_cambio
	from `salida_almacenes` s where s.`cod_tiposalida`=1001 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad`='$rpt_territorio' and cod_tipoalmacen=1)
	and CONCAT(s.fecha,' ',s.hora_salida) BETWEEN '$fecha_iniconsultahora' and '$fecha_finconsultahora' and s.`cod_chofer`='$rpt_funcionario' ";

$sqlAnulado="select s.`fecha`,  
	(select c.nombre_cliente from clientes c where c.`cod_cliente`=s.cod_cliente) as cliente, 
	s.`razon_social`, s.`observaciones`, 
	(select t.`abreviatura` from `tipos_docs` t where t.`codigo`=s.cod_tipo_doc),
	s.`nro_correlativo`, s.`monto_final`, s.cod_tipopago, (select tp.nombre_tipopago from tipos_pago tp where tp.cod_tipopago=s.cod_tipopago), 
	s.hora_salida,s.cod_chofer,s.monto_cancelado_usd,s.tipo_cambio
	from `salida_almacenes` s where s.`cod_tiposalida`=1001 and s.salida_anulada!=0 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad`='$rpt_territorio' and cod_tipoalmacen=1)
	and CONCAT(s.fecha,' ',s.hora_salida) BETWEEN '$fecha_iniconsultahora' and '$fecha_finconsultahora' and s.`cod_chofer`='$rpt_funcionario' ";

$sqlAnuladoReal="select s.`fecha`,  
	(select c.nombre_cliente from clientes c where c.`cod_cliente`=s.cod_cliente) as cliente, 
	s.`razon_social`, s.`observaciones`, 
	(select t.`abreviatura` from `tipos_docs` t where t.`codigo`=s.cod_tipo_doc),
	s.`nro_correlativo`, s.`monto_final`, s.cod_tipopago, (select tp.nombre_tipopago from tipos_pago tp where tp.cod_tipopago=s.cod_tipopago), 
	s.hora_salida,s.cod_chofer,s.monto_cancelado_usd,s.tipo_cambio
	from `salida_almacenes` s where s.`cod_tiposalida`=1001 and s.salida_anulada!=0 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad`='$rpt_territorio' and cod_tipoalmacen=1)
	and s.fecha_anulacion BETWEEN '$fecha_iniconsultahora' and '$fecha_finconsultahora' and s.`cod_chofer`='$rpt_funcionario' ";


if($variableAdmin==1){
	$sql.=" and s.cod_tipo_doc in (1,2,3,4)";
	$sqlAnulado.=" and s.cod_tipo_doc in (1,2,3,4)";
	$sqlAnuladoReal.=" and s.cod_tipo_doc in (1,2,3,4)";
}else{
	$sql.=" and s.cod_tipo_doc in (1,4)";
	$sqlAnulado.=" and s.cod_tipo_doc in (1,4)";
	$sqlAnuladoReal.=" and s.cod_tipo_doc in (1,4)";
}
$sql.=" order by s.fecha, s.hora_salida";
$sqlAnulado.=" order by s.fecha, s.hora_salida";
$sqlAnuladoReal.=" order by s.fecha, s.hora_salida";

$resp=mysqli_query($enlaceCon,$sql);
$respAnulado=mysqli_query($enlaceCon,$sqlAnulado);
$respAnuladoReal=mysqli_query($enlaceCon,$sqlAnuladoReal);


$totalVenta=0;
$totalEfectivo=0;
$totalTarjeta=0;
$totalEfectivoUsd=0;
$totalEfectivoBs=0;
while($datos=mysqli_fetch_array($resp)){	
	$fechaVenta=$datos[0];
	$nombreCliente=$datos[1];
	$razonSocial=$datos[2];
	$obsVenta=$datos[3];
	$datosDoc=$datos[4]."-".$datos[5];
	$montoVenta=$datos[6];
	$montoVenta=number_format($montoVenta,1,'.','');
	$totalVenta=$totalVenta+$montoVenta;
	$codTipoPago=$datos[7];
	$nombreTipoPago=$datos[8];
	$horaVenta=$datos[9];
	$montoDolares=$datos['monto_cancelado_usd'];
	$tipoCambio=$datos['tipo_cambio'];	
	$personalCliente=nombreVisitador($datos['cod_chofer']);
	
	if($codTipoPago==1){
		$totalEfectivoBs+=($montoDolares*$tipoCambio);
		$totalEfectivoUsd+=$montoDolares;	
		$totalEfectivo+=$montoVenta;
	}else{
		$montoVenta=number_format($montoVenta,1,'.','');
		$totalTarjeta+=$montoVenta;
	}
	$montoVentaFormat=number_format($montoVenta,2,".",",");
	$totalEfectivoF=number_format($totalEfectivo,2,".",",");
	$totalEfectivoFUSD=number_format($totalEfectivoUsd,2,".",",");
	$totalTarjetaF=number_format($totalTarjeta,2,".",",");	
	
}

$totalVentaFormat=number_format($totalVenta,2,".",",");


$totalVentaAnulada=0;
while($datos=mysqli_fetch_array($respAnulado)){	
	$fechaVenta=$datos[0];
	$nombreCliente=$datos[1];
	$razonSocial=$datos[2];
	$obsVenta=$datos[3];
	$datosDoc=$datos[4]."-".$datos[5];
	$montoVenta=$datos[6];
	$montoVenta=number_format($montoVenta,1,'.','');
	if($codTipoPago==1){
		$totalVentaAnulada=$totalVentaAnulada+$montoVenta;
	}
	
	$codTipoPago=$datos[7];
	$nombreTipoPago=$datos[8];
	$horaVenta=$datos[9];
	$personalCliente=nombreVisitador($datos['cod_chofer']);
	$montoVentaFormat=number_format($montoVenta,2,".",",");
	

}

$totalVentaAnuladaReal=0;
while($datos=mysqli_fetch_array($respAnuladoReal)){	
	$fechaVenta=$datos[0];
	$nombreCliente=$datos[1];
	$razonSocial=$datos[2];
	$obsVenta=$datos[3];
	$datosDoc=$datos[4]."-".$datos[5];
	$montoVenta=$datos[6];
	$montoVenta=number_format($montoVenta,1,'.','');
	$codTipoPago=$datos[7];
	if($codTipoPago==1){
		$totalVentaAnuladaReal=$totalVentaAnuladaReal+$montoVenta;
	}
	$codTipoPago=$datos[7];
	$nombreTipoPago=$datos[8];
	$horaVenta=$datos[9];
	$personalCliente=nombreVisitador($datos['cod_chofer']);
	$montoVentaFormat=number_format($montoVenta,2,".",",");
	

}


$totalGastos=0;
$totalVentaAnuladaFormat=number_format($totalVentaAnulada,2,".",",");
$totalVentaAnuladaFormatReal=number_format($totalVentaAnuladaReal,2,".",",");

$saldoCajaChica=$montoCajaChica+$totalVenta-$totalGastos;
$saldoCajaChicaF=number_format($saldoCajaChica,2,".",",");

$saldoCajaChica2=$montoCajaChica+$totalEfectivo-$totalGastos;
$saldoCajaChica2F=number_format($saldoCajaChica2,2,".",",");

$saldoCajaChica3=$totalVentaAnulada;
$saldoCajaChica3F=number_format($saldoCajaChica3,2,".",",");

$saldoCajaChica4=$totalVentaAnuladaReal;
$saldoCajaChica4F=number_format($saldoCajaChica4,2,".",",");

$saldoCajaChica5=$saldoCajaChica2-$totalVentaAnuladaReal;
$saldoCajaChica5F=number_format($saldoCajaChica5,2,".",",");

$saldoCajaChica6=$saldoCajaChica5-($totalEfectivoBs);
if($saldoCajaChica6<0){
	$saldoCajaChica6=0;
}
$saldoCajaChica6F=number_format($saldoCajaChica6,2,".",",");

$nombreFuncionario=nombreVisitador($rpt_funcionario);
$fechaCajaCierre=strftime('%d/%m/%Y',strtotime($fecha_ini));
$fechaCajaCierreFin=strftime('%d/%m/%Y',strtotime($fecha_fin));
$nombreFuncionario=nombreVisitador($rpt_funcionario);

$totalIngresos=($totalEfectivo+$totalTarjeta)-$saldoCajaChica4;
$totalIngresosFormat=number_format($totalIngresos,2,".",",");


?>
<div style="width:320;margin:0;padding-left:30px !important;padding-right:30px !important;height:<?=$tamanoLargo?>; font-family:Arial;">
<br>
<center><p class="arial-12">CIERRE DE CAJA</p>
<label class="arial-12"><?=obtenerNombreCiudad($rpt_territorio)?></label><br>
<label class="arial-12"><?="FECHA DEL REPORTE: ".$fecha_reporte?></label><br>
<label class="arial-12"><?="-------------------------------------------"?></label><br>
<label class="arial-12"><?="Personal: $nombreFuncionario"?></label><br>
<label class="arial-12"><?="DEL: $fechaCajaCierre $hora_ini"?></label><br>
<label class="arial-12"><?="AL: $fechaCajaCierreFin $hora_fin"?></label><br>
<label class="arial-12"><?="============================================="?></label><br>
<table width="100%"><tr align="center" class="arial-12"><td><?="DESCRIPCION"?></td><td><?="IMPORTE"?></td><td><?="Bs."?></td></tr></table>
<label class="arial-12"><?="============================================="?></label><br>
<?php

?>
    <table width="100%">
    <tr align="center" class="arial-8"><td><?="TOTAL EFECTIVO"?></td><td><?="$totalEfectivoF"?></td><td></td></tr>
    <tr align="center" class="arial-8"><td><?="TOTAL TARJETA"?></td><td><?="$totalTarjetaF"?></td><td></td></tr>
    <tr align="center" class="arial-8"><td><?="TOTAL VENTAS ANULADAS"?></td><td><?="$saldoCajaChica4F"?></td><td></td></tr>    
    <tr align="center" class="arial-8"><td style='font-weight: bold'><?="TOTAL A DEPOSITAR (BS)"?></td><td style='font-weight: bold'><?="$saldoCajaChica6F"?></td><td></td></tr>
    <tr align="center" class="arial-8"><td style='font-weight: bold'><?="TOTAL A DEPOSITAR (USD)"?></td><td style='font-weight: bold'><?="$totalEfectivoFUSD ($)"?></td><td></td></tr>
   </table>
<br><br>

</center>
<br><br>
</div>
<script type="text/javascript">
 javascript:window.print();
 setTimeout(function () { window.location.href="registrar_salidaventas.php";}, 100);
</script>

