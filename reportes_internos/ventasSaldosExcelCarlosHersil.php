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

$fechaInicio="01/01/2021";
$fechaFinal="31/05/2021";
//HERSIL
$stringProductos="8701,
8702,
8703,
8704,
8705,
10624,
23837,
23838,
24501,
24502,
24641,
24642,
27882,
27883,
27884,
27885,
27886,
27887,
29063,
29064,
29065,
29562,
92110";

?>
<center><h3><b>PRODUCTOS VENTAS Y SALDO</b></h3></center>
<table class="table table-condensed table-bordered ">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <!--<th style='background: #EFDCA2 !important;font-weight: bold;'>Proveedor</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Linea</th>-->
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Fecha</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Codigo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Descripcion</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Cantidad<br>Venta</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Monto<br>Venta</th>
    </tr>
   </thead>
<?php
$idprov=12;
$listAlma=obtenerListadoAlmacenes();
foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      $dbh = ConexionFarma($ip,"Gestion");
$sql="SELECT YEAR(d.fecha) as anio,MONTH(d.fecha) as mes,d.CPROD,P.DES,SUM(CAN+CAN1) AS CANTIDAD,sum(((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))-((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))*DESCTO2)/100))-(((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))-((((PREUNIT*(CAN+CAN1))-(((PREUNIT*(CAN+CAN1))*DESCTO1)/100))*DESCTO2)/100))*DESCTO3)/100))) AS MONTO_V
FROM VFICHAD d LEFT JOIN APRODUCTOS P ON P.CPROD=d.CPROD
WHERE d.STA in ('V','M')
AND d.tipo in ('F') AND d.fecha BETWEEN '$fechaInicio' AND '$fechaFinal' AND P.CPROD IN ($stringProductos)
GROUP BY d.CPROD,P.DES,YEAR(d.fecha),MONTH(d.fecha);";
//echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $cod_prod=$row['CPROD'];
   $des_prod=$row['DES'];
   $cant_ven=$row['CANTIDAD'];
   $monto_ven=$row['MONTO_V']; 
   $anio_prod=$row['anio'];
   $mes_prod=$row['mes'];
       ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><b><?=$mes_prod."/".$anio_prod?></b></td>
          <td><?=$cod_prod?></td>
          <td><?=$des_prod?></td>
          <td><?=$cant_ven?></td>
          <td><?=number_format($monto_ven,2,'.',',')?></td>
        </tr><?php
      }
}

?>
  </table>
