<html>
<head>
  <meta charset="utf-8" />
</head>
<body>
<?php
set_time_limit(0);
require('estilos.php');
require('../function_formatofecha.php');
require('../conexionmysqli.inc');
require('../funcion_nombres.php');
require('../funciones.php');
$fecha_ini=$_GET['fecha_ini'];
$fecha_fin=$_GET['fecha_fin'];
$codSubGrupo=$_GET['codSubGrupo'];
$rpt_formato=(int)$_GET['rpt_formato'];
//desde esta parte viene el reporte en si
$fecha_iniconsulta=$fecha_ini;
$fecha_finconsulta=$fecha_fin;


$rpt_territorio=$_GET['codTipoTerritorio'];
$almacenes=obtenerAlmacenesDeCiudadString($rpt_territorio);
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
<table style='margin-top:-90 !important' align='center' class='textotit' width='70%'><tr><td align='center'>Reporte Logs de Precios
  <br> De: <?=$fecha_ini?> A: <?=$fecha_fin?>
  <br>Fecha Reporte: <?=$fecha_reporte?></tr></table>
  <center><div style='width:70%;text-align:center;'><b>Sucursales:</b><br><small><?=$nombre_territorio?></small></div></center>
<?php

setlocale(LC_ALL, 'es_ES');
$tiempoInicio = strtotime($fecha_iniconsulta);//obtener tiempo de inicio
$tiempoFin = strtotime(date("Y-m-t", strtotime($fecha_finconsulta)).""); //obtener el tiempo final pero al ultimo día, para que muestre todos los meses
?>
<br><center><table align='center' class='texto' width='70%' id='ventasLinea'>
  <thead>
<tr><th width="5%">N.</th><th><small>Proveedor</small></th><th><small>Línea</small></th>
<th><small>Producto</small></th>
<th>Detalles</th>
</tr>
</thead>
<tbody>
<?php
$sqlSucursal="select m.codigo_material, m.descripcion_material,m.cod_linea_proveedor,(SELECT nombre_linea_proveedor from proveedores_lineas where cod_linea_proveedor=m.cod_linea_proveedor) as nombre_linea_proveedor,(SELECT nombre_proveedor from proveedores where cod_proveedor=(SELECT cod_proveedor from proveedores_lineas where cod_linea_proveedor=m.cod_linea_proveedor)) as nombre_proveedor from material_apoyo m where m.cod_linea_proveedor in ($codSubGrupo) and m.estado=1 order by m.descripcion_material";

$respSucursal=mysqli_query($enlaceCon,$sqlSucursal);
//echo $sqlSucursal;
$index=0;
while($datosSuc=mysqli_fetch_array($respSucursal)){ 
  $totalesHorizontal=0;
  $index++;
  $nombreLinea=$datosSuc[3];
  $nombreProveedor=$datosSuc[4];
  ?><tr><th><?=$index?></th><th><?=$nombreProveedor?></th><th><?=$nombreLinea?></th><?php
   $codigoSubGrupo=$datosSuc[0];
   ?><th><?=$datosSuc[1];?></th><?php
  ?><th>0</th>
 </tr>
  <?php
}
?>
</tbody></table></center></br>
<?php include("imprimirInc.php");?>

</body></html>