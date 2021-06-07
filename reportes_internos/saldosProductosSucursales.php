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

?>
<table border="1">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;' colspan="6">PRODUCTOS VENTAS Y SALDO</th>
    </tr>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Codigo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Descripcion</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Saldo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Tipo</th> 
</tr>
   </thead>
<?php
$listAlma=obtenerListadoAlmacenes();//obtenerListadoAlmacenes();//obtenerListadoAlmacenesEspecifico("Aà");//obtenerListadoAlmacenes();
foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      $dbh = ConexionFarma($ip,"Gestion");

$sql="SELECT D.CPROD,P.DES,SUM(D.INGRESO)-SUM(D.SALIDA) AS SALDOS,D.TIPO 
FROM VSALDOS D JOIN APRODUCTOS P ON P.CPROD=D.CPROD
GROUP BY D.CPROD,P.DES,D.TIPO;";
//echo $sql;
if($dbh!=false){
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $cod_prod=$row['CPROD'];
   $des_prod=$row['DES'];
   $saldos=$row['SALDOS'];
   $tipo=$row['TIPO']; 
       ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><?=$cod_prod?></td>
          <td><?=$des_prod?></td>
          <td><?=$saldos?></td>
          <td><?=$tipo?></td>
        </tr><?php
      }
 }
}

?>
  </table>
