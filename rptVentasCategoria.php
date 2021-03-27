<html>
<head>
	<meta charset="utf-8" />
</head>
<body>
<?php
set_time_limit(0);
require('estilos_reportes_almacencentral.php');
require('function_formatofecha.php');
require('conexionmysqli.inc');
require('funcion_nombres.php');
require('funciones.php');
$fecha_ini=$_GET['fecha_ini'];
$fecha_fin=$_GET['fecha_fin'];
$codTipoPago=$_GET['codTipoPago'];
$codSubGrupo=$_GET['codSubGrupo'];
//desde esta parte viene el reporte en si
$fecha_iniconsulta=$fecha_ini;
$fecha_finconsulta=$fecha_fin;


$rpt_territorio=$_GET['codTipoTerritorio'];

$fecha_reporte=date("d/m/Y");

$nombre_territorio=obtenerNombreSucursalAgrupado($rpt_territorio);
$nombre_territorio=str_replace(",",", ", $nombre_territorio);
?><style type="text/css"> 
        thead tr th { 
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #ffffff;
        }
    
        .table-responsive { 
            height:200px;
            overflow:scroll;
        }
    </style>
<table style='margin-top:-90 !important' align='center' class='textotit' width='70%'><tr><td align='center'>Reporte Ventas x Clasificador
	<br> De: <?=$fecha_ini?> A: <?=$fecha_fin?>
	<br>Fecha Reporte: <?=$fecha_reporte?></tr></table>
	<center><div style='width:70%;text-align:center;'><b>Sucursales:</b><br><small><?=$nombre_territorio?></small></div></center>
<?php

setlocale(LC_ALL, 'es_ES');
$tiempoInicio = strtotime($fecha_iniconsulta);//obtener tiempo de inicio
$tiempoFin = strtotime(date("Y-m-t", strtotime($fecha_finconsulta)).""); //obtener el tiempo final pero al ultimo día, para que muestre todos los meses
?>
<br><center><table align='center' class='texto' width='70%' id='ventasCategoria'>
	<thead>
<tr><th width="5%">N.</th><th><small>Sub Clasificador</small></th>
<?php
$cantidadMes=0;
while($tiempoInicio <= $tiempoFin){
	$fechaActual = date("Y-m-d", $tiempoInicio);
	?><th><small><?=strftime('%b %Y', strtotime($fechaActual))?></small></th><?php
	$tiempoInicio += strtotime("+1 month","$fechaActual");
	$cantidadMes++;
}
?>
<th>Totales</th>
</tr>
</thead>
<tbody>
<?php

$sqlSucursal="select codigo, nombre from subgrupos where codigo in ($codSubGrupo) order by nombre";
$respSucursal=mysqli_query($enlaceCon,$sqlSucursal);
$index=0;
$almacenes=obtenerAlmacenesStringDeSubGrupo($rpt_territorio);

while($datosSuc=mysqli_fetch_array($respSucursal)){	
  $totalesHorizontal=0;
  $index++;
	$codigoSubGrupo=$datosSuc[0];
  $materiales=obtenerMaterialesStringDeSubGrupo($codigoSubGrupo);
	$nombreSuc=$datosSuc[1];
	?><tr><th><?=$index?></th><th><?=$nombreSuc?></th><?php
  $tiempoInicio2 = strtotime($fecha_iniconsulta);
  $cantidadMes2=0;
  while($tiempoInicio2 <= $tiempoFin){
  	//obtener rangos del mes
  	$dateInicio = date("Y-m", $tiempoInicio2)."-01";
  	$dateFin = date("Y-m-t", $tiempoInicio2);
  	//para listar desde el dia escogido en el primer y ultimo mes
  	if($cantidadMes==0){
  		$dateInicio=date('Y-m-d', strtotime($fecha_iniconsulta));
  	}
  	if($cantidadMes2==$cantidadMes){
  		$dateFin=date('Y-m-d', strtotime($fecha_finconsulta));
  	}

  	$montoVenta=obtenerMontoVentasGeneradasCategoriaMaterial($dateInicio,$dateFin,$almacenes,$codTipoPago,$materiales);
    $totalesHorizontal+=number_format($montoVenta,2,'.','');
  	if($montoVenta>0){//if($dateInicio==date("Y-m")."-01"){
  		?><td><?=number_format($montoVenta,2,'.',' ')?></td><?php
  	}else{
  		?><td class='text-muted'><?=number_format($montoVenta,2,'.',' ')?></td><?php
  	} 	
    // para sumar mes
  	$fechaActual = date("Y-m-d", $tiempoInicio2);  	
  	$tiempoInicio2 += (float)strtotime("+1 month","$fechaActual");
  }
  ?><th><?=number_format($totalesHorizontal,2,'.',',')?></th>
  </tr>
  <?php
}
?>
</tbody><tfoot><tr></tr></tfoot></table></center></br>
<?php include("imprimirInc.php");
?>
<script type="text/javascript">
  totalesTablaVertical('ventasCategoria',2,1);
</script>
</body></html>