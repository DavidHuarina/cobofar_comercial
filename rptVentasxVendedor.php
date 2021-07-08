<html>
<head>
  <meta charset="utf-8" />
</head>
<body>
<?php
require('estilos_reportes_almacencentral.php');
require('function_formatofecha.php');
require('conexionmysqli.inc');
require('funcion_nombres.php');
require('funciones.php');
$fecha_ini=$_GET['fecha_ini'];
$fecha_fin=$_GET['fecha_fin'];
if(!isset($_GET['rpt_ver'])){
  $rpt_ver=0;	
}else{
  $rpt_ver=$_GET['rpt_ver'];
}
$codPersonal=$_GET['codPersonal'];

//desde esta parte viene el reporte en si
$fecha_iniconsulta=$fecha_ini;//cambia_formatofecha($fecha_ini);
$fecha_finconsulta=$fecha_fin;//cambia_formatofecha($fecha_fin);


$rpt_territorio=$_GET['rpt_territorio'];

$fecha_reporte=date("d/m/Y");

$nombre_territorio=nombreTerritorio($rpt_territorio);

echo "<table align='center' class='textotit' width='100%'><tr><td align='center'>Reporte Ventas x Dispensador
	<br>Territorio: $nombre_territorio <br> De: $fecha_ini A: $fecha_fin
	<br>Fecha Reporte: $fecha_reporte</tr></table>";


$sql="select f.`codigo_funcionario`, concat(f.`paterno`,' ',f.`materno`,' ',f.`nombres`)as vendedor,
       sum(sd.monto_unitario) montoVenta,count(s.cod_salida_almacenes)cantidadVentas
from `salida_almacenes` s,
     `salida_detalle_almacenes` sd, `funcionarios` f
where s.`cod_salida_almacenes` = sd.`cod_salida_almacen` and
      s.`fecha` BETWEEN '$fecha_iniconsulta' and
      '$fecha_finconsulta'      and
      s.`salida_anulada` = 0 and
      s.`cod_almacen` in (
                           select a.`cod_almacen`
                           from `almacenes` a
                           where a.`cod_ciudad` = '$rpt_territorio'
      ) and 
      s.`cod_chofer`=f.`codigo_funcionario` and f.codigo_funcionario in ($codPersonal) group by f.`codigo_funcionario`";		
//echo $sql;
$resp=mysqli_query($enlaceCon,$sql);

?><br><table align='center' class='texto' width='100%'  id="ventasSucursal">
 <thead>
<tr>
<th>Codigo</th>
<th>Vendedor</th>
<th>Cantidad Atenciones</th>
<th>Monto</th>
<th>% Cantidad</th>
<th>% Monto</th>
</tr></thead><tbody>
<?php
$totalVenta=0;
$datosTotal=obtenerMontoVentasPersonalHoraTotal($fecha_iniconsulta,$fecha_finconsulta,$rpt_territorio,$codPersonal);
$montoTotal=number_format($datosTotal[1],2,'.','');
$cantidadTotal=number_format($datosTotal[0],2,'.','');
$arrPor=[]; 
$arrPorCant=[];
$index=0;
while($datos=mysqli_fetch_array($resp)){	
	$codItem=$datos[0];
	$nombrePersona=$datos[1];
	$montoVenta=$datos[2];	
	$cantidadVenta=$datos[3];	
	$montoPtr=number_format($montoVenta,2,".",",");
	
	if($montoTotal>0){
      $porc=(number_format($montoVenta,2,'.','')*100)/$montoTotal;   
    }else{
      $porc=0; 
    }
    if($cantidadTotal>0){
      $porcCnt=(number_format($cantidadVenta,2,'.','')*100)/$cantidadTotal;   
    }else{
      $porcCnt=0; 
    }
    $arrPor['0_'.$index]=$porc;   
    $arrPorCant['c_0_'.$index]=$porcCnt;

	$totalVenta=$totalVenta+$montoVenta;
	?>
	<tr id="0_<?=$index?>">
	<td><?=$codItem?></td>
	<td><?=$nombrePersona?></td>
	<td align="right"><?=$cantidadVenta?></td><td align="right"><?=number_format($montoVenta,2,'.',',')?></td><td id="c_0_<?=$index?>" align="right"><?=number_format($porcCnt,2,'.','')." %"?></td><td align="right"><?=number_format($porc,2,'.','')." %"?></td></tr>
	<?php
	$index++;
}
$ind = array_search(max($arrPor),$arrPor); 
$ind2 = array_search(max($arrPorCant),$arrPorCant); 
    ?><script type="text/javascript">$("#<?=$ind?>").attr("style","background:#44C28B;color:white;");</script><script type="text/javascript">$("#<?=$ind2?>").attr("style","background:#FF5733;color:white;");</script><?php

echo "</tbody><tfoot><tr></tr></tfoot></table>";
include("imprimirInc.php");
?>
<script type="text/javascript">
  totalesTablaVertical('ventasSucursal',2,1);
</script>
</body></html>