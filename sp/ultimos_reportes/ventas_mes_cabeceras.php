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

require_once __DIR__.'/../../conexion_externa_farma.php';
error_reporting(0);
require_once '../../function_web.php';

$fechaInicio="01/03/2021";
$fechaFinal="29/04/2021";

?>
<center><h3><b>PRODUCTOS VENTAS Y SALDO</b></h3></center>
<table class="table table-condensed table-bordered " border="1">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Fecha</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Ventas</th> 
<!--<tr>
  <th style='background: #EFDCA2 !important;font-weight: bold;' colspan="3"></th>-->
  <?php 
?>
<!--</tr>-->
</tr>
   </thead>
<?php
$listAlma=obtenerListadoAlmacenesEspecifico("A:");
foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      $dbh = ConexionFarma($ip,"Gestion");

$sql="SELECT YEAR(d.fecha) as anio,MONTH(d.fecha) as mes,SUM(d.MFACTURA) AS MONTO_V
FROM VFICHAM d
WHERE d.STA in ('V','M')
AND d.tipo in ('F') AND d.fecha BETWEEN '$fechaInicio' AND '$fechaFinal'
GROUP BY YEAR(d.fecha),MONTH(d.fecha);";
//echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $anio_prod=$row['anio'];
   $mes_prod=$row['mes'];
   $monto_ven=$row['MONTO_V']; 
       ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><b><?=$mes_prod."/".$anio_prod?></b></td>
          <td><?=number_format($monto_ven,2,'.',',')?></td>
        </tr><?php
      }
}

?>
  </table>
