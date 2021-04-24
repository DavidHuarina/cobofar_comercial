<?php
ini_set('memory_limit','1G');
set_time_limit(0);

header("Pragma: public");
header("Expires: 0");
$filename = "datos_market.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

require_once __DIR__.'/../conexion_externa_farma.php';
error_reporting(0);
require_once '../function_web.php';

$idProveedor=implode(",",$_POST["proveedor"]);
$idCiudad=implode(" ",$_POST["sucursales"]);
$fechaI=explode("-",$_POST["desde"]);
$fechaF=explode("-",$_POST["hasta"]);
$fechaInicio=$fechaI[2]."/".$fechaI[1]."/".$fechaI[0];
$fechaFinal=$fechaF[2]."/".$fechaF[1]."/".$fechaF[0];

?>
<center><h3><b>PRODUCTOS VENTAS Y SALDO</b></h3></center>
<table class="table table-condensed table-bordered " border="1">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Codigo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Descripcion</th>

        <?php 
setlocale(LC_ALL, 'es_ES');
$tiempoInicio = strtotime($_POST["desde"]);//obtener tiempo de inicio
$tiempoFin = strtotime(date("Y-m-t", strtotime($_POST["hasta"])).""); //obtener el tiempo final pero al ultimo día, para que muestre todos los meses 
$cantidadMes=0;
while($tiempoInicio <= $tiempoFin){
  $fechaActual = date("Y-m-d", $tiempoInicio);
  ?><th style='background: #EFDCA2 !important;font-weight: bold;' colspan="2"><?=strftime('%m/%Y', strtotime($fechaActual))?></th><?php
  $tiempoInicio += strtotime("+1 month","$fechaActual");
  $cantidadMes++;
}
?>
</tr>
<tr>
  <th style='background: #EFDCA2 !important;font-weight: bold;' colspan="3"></th>
  <?php 
setlocale(LC_ALL, 'es_ES');
$tiempoInicio = strtotime($_POST["desde"]);//obtener tiempo de inicio
$tiempoFin = strtotime(date("Y-m-t", strtotime($_POST["hasta"])).""); //obtener el tiempo final pero al ultimo día, para que muestre todos los meses 
$cantidadMes=0;
while($tiempoInicio <= $tiempoFin){
  $fechaActual = date("Y-m-d", $tiempoInicio);
  ?><th style='background: #EFDCA2 !important;font-weight: bold;'>C</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Venta</th><?php
  $tiempoInicio += strtotime("+1 month","$fechaActual");
  $cantidadMes++;
}
?>
</tr>

        
        
    </tr>
   </thead>
<?php
$listAlma=obtenerListadoMarkets(utf8_decode($idCiudad));
foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      $dbh = ConexionFarma($ip,"Gestion");

$sql="SELECT d.CPROD,P.DES,SUM(CAN+CAN1) AS CANTIDAD,sum(((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))-((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))*DESCTO2)/100))-(((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))-((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))*DESCTO2)/100))*DESCTO3)/100))) AS MONTO_V
FROM VFICHAD d LEFT JOIN APRODUCTOS P ON P.CPROD=d.CPROD
WHERE d.STA in ('V','M')
AND d.tipo in ('F') AND d.fecha BETWEEN '$fechaInicio' AND '$fechaFinal'
GROUP BY d.CPROD,P.DES;";
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $cod_prod=$row['CPROD'];
   $des_prod=$row['DES'];
   $cant_ven=$row['CANTIDAD'];
   $monto_ven=$row['MONTO_V']; 
       ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><?=$cod_prod?></td>
          <td><?=$des_prod?></td>
  <?php
setlocale(LC_ALL, 'es_ES');
$tiempoInicio = strtotime($_POST["desde"]);//obtener tiempo de inicio
$tiempoFin = strtotime(date("Y-m-t", strtotime($_POST["hasta"])).""); //obtener el tiempo final pero al ultimo día, para que muestre todos los meses 
$cantidadMes=0;
while($tiempoInicio <= $tiempoFin){
  $fechaActual = date("Y-m-d", $tiempoInicio);
  $fa=explode("-",$fechaActual);
  $fechaActualInicio=$fa[0]."-".$fa[1]."-01";
  $fechaActualFin = date("Y-m-t",strtotime($fechaActual));

  $sqlDetalle="SELECT d.CPROD,P.DES,SUM(CAN+CAN1) AS CANTIDAD,sum(((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))-((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))*DESCTO2)/100))-(((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))-((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))*DESCTO2)/100))*DESCTO3)/100))) AS MONTO_V
FROM VFICHAD d LEFT JOIN APRODUCTOS P ON P.CPROD=d.CPROD
WHERE d.STA in ('V','M')
AND d.tipo in ('F') AND d.fecha BETWEEN '$fechaActualInicio' AND '$fechaActualFin'
AND  d.CPROD='$cod_prod'";
$stmtDetalle = $dbh->prepare($sqlDetalle);
$stmtDetalle->execute();
  while ($rowDetalle = $stmtDetalle->fetch(PDO::FETCH_ASSOC)) {
   $cant_ven_detalle=$rowDetalle['CANTIDAD'];
   $monto_ven_detalle=$rowDetalle['MONTO_V']; 
   ?><td><?=$cant_ven_detalle?></td>
     <td><?=number_format($monto_ven_detalle,2,'.',',')?></td><?php  
    }
  $tiempoInicio += strtotime("+1 month","$fechaActual");
  $cantidadMes++;
   }
   ?>        
   </tr><?php
 }
}

?>
  </table>
