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
//require_once '../function_web.php';

$fechaInicio="01/03/2021";
$fechaFinal="14/05/2021";
if(isset($_GET["fi"])){
  $fechaInicio=$_GET["fi"];
}
if(isset($_GET["ff"])){
  $fechaFinal=$_GET["ff"];
}
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
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Cantidad<br>Caja</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Cantidad<br>Sueltas</th>
    </tr>
   </thead>
<?php
      $age1="AS";
      $nombre="ORTEGA";
      $ip="10.10.20.12";

if(isset($_GET["age1"])){
  $age1=$_GET["age1"];
}
if(isset($_GET["nombre"])){
  $nombre=$_GET["nombre"];
}
if(isset($_GET["ip"])){
  $ip=$_GET["ip"];
}

      $dbh = ConexionFarma($ip,"Gestion");

$sql="SELECT d.CPROD,P.DES,SUM(CAN+CAN1) AS CANTIDAD,d.DCTO,
(SELECT SUM(de.DCAN-de.HCAN) FROM VDETALLE de WHERE de.DCTO=d.DCTO AND de.TIPO='F' AND de.CPROD=d.CPROD AND de.FECHA BETWEEN '$fechaInicio' AND '$fechaFinal')CANTIDAD_CAJAS,
(SELECT SUM(de.DCAN1-de.HCAN1) FROM VDETALLE de WHERE de.DCTO=d.DCTO AND de.TIPO='F' AND de.CPROD=d.CPROD AND de.FECHA BETWEEN '$fechaInicio' AND '$fechaFinal')CANTIDAD_SUELTAS
FROM VFICHAD d LEFT JOIN APRODUCTOS P ON P.CPROD=d.CPROD
WHERE d.STA in ('V','M')
AND d.tipo in ('F') AND d.fecha BETWEEN '$fechaInicio' AND '$fechaFinal'
GROUP BY d.DCTO,d.CPROD,P.DES;";
//echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $cod_prod=$row['CPROD'];
   $des_prod=$row['DES'];
   $cant_ven=$row['CANTIDAD'];
   $cant_cajas=abs($row['CANTIDAD_CAJAS']); 
   $cant_sueltas=abs($row['CANTIDAD_SUELTAS']); 

   $dif=$cant_cajas+$cant_sueltas;
   if($dif!=$cant_ven){
    ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><?=$cod_prod?></td>
          <td><?=$des_prod?></td>
          <td><?=$cant_ven?></td>
          <td><?=$cant_cajas?></td>
          <td><?=$cant_sueltas?></td>
        </tr><?php
   }
       
}
?>
  </table>
