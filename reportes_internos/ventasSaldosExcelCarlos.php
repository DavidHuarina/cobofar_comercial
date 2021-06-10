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
require_once '../function_web.php';

$fechaInicio="14/04/2021";
$fechaFinal="07/05/2021";
$stringProductos="101401,
101402,
101403,
101404,
101405,
101406,
101407,
101408,
101409,
101410,
101411,
101412,
101413,
101414,
101565,
101566,
101591,
101592,
101812";

?>
<center><h3><b>PRODUCTOS VENTAS Y SALDO</b></h3></center>
<table class="table table-condensed table-bordered ">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <!--<th style='background: #EFDCA2 !important;font-weight: bold;'>Proveedor</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Linea</th>-->
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Codigo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Descripcion</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Cantidad<br>Venta</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Monto<br>Venta</th>
    </tr>
   </thead>
<?php
$listAlma=obtenerListadoAlmacenes();
foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      $dbh = ConexionFarma($ip,"Gestion");
$sql="SELECT d.CPROD,P.DES,SUM(CAN+CAN1) AS CANTIDAD,sum(((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))-((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))*DESCTO2)/100))-(((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))-((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))*DESCTO2)/100))*DESCTO3)/100))) AS MONTO_V
FROM VFICHAD d LEFT JOIN APRODUCTOS P ON P.CPROD=d.CPROD
WHERE d.STA in ('V','M')
AND d.tipo in ('F') AND d.fecha BETWEEN '$fechaInicio' AND '$fechaFinal' AND d.CPROD IN ($stringProductos)
GROUP BY d.CPROD,P.DES;";
//echo $sql;
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
          <td><?=$cant_ven?></td>
          <td><?=number_format($monto_ven,2,'.',',')?></td>
        </tr><?php
      }
}

?>
  </table>
