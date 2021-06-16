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
$estilosVenta=1;
require_once '../function_web.php';

$fechaInicio="01/05/2021";
$fechaFinal="31/05/2021";

?>
<table border="1">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;' colspan="6">PRODUCTOS VENTAS Y SALDO</th>
    </tr>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Monto</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Fecha</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Ultima Hora</th>
</tr>
   </thead>
<?php
$listAlma=obtenerListadoAlmacenes();//obtenerListadoAlmacenes();//obtenerListadoAlmacenesEspecifico("Aà");//obtenerListadoAlmacenes();
foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      $dbh = ConexionFarma($ip,"Gestion");

$sql="SELECT SUM(MFACTURA) AS MONTO_V,YEAR(d.fecha) as anio,MONTH(d.fecha) as mes,DAY(d.fecha) as dia,MAX(fechat) AS HORA
FROM VFICHAM d
WHERE d.STA in ('V','M')
AND d.tipo in ('F') AND d.fecha BETWEEN '$fechaInicio' AND '$fechaFinal' AND DATEPART(HOUR, d.fechat)>20  GROUP BY YEAR(d.fecha),MONTH(d.fecha),DAY(d.fecha);";
//echo $sql;
if($dbh!=false){
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $monto_ven=$row['MONTO_V']; 
      $fecha=$row['dia']."/".$row['mes']."/".$row['anio']; 
      $hora=explode(".",explode(" ",$row['HORA'])[1])[0];
       ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><?=number_format($monto_ven,2,'.',',')?></td>
          <td><?=$fecha?></td>
          <td><?=$hora?></td>
        </tr><?php
      }
 }
}

?>
  </table>
