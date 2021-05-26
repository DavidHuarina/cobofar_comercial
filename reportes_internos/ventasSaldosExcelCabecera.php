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
$fechaInicio="15/05/2021";
$fechaFinal="15/05/2021";
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
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Monto<br>Venta</th>
    </tr>
   </thead>
<?php
$age1="AG";
$nombre="MIRAFLORES";
$ip="10.10.12.12";
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

$sql="SELECT SUM(MFACTURA) AS MONTO_V
FROM VFICHAM d
WHERE d.STA in ('V','M')
AND d.tipo in ('F') AND d.fecha BETWEEN '$fechaInicio' AND '$fechaFinal'";
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $monto_ven=$row['MONTO_V']; 
       ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><?=number_format($monto_ven,2,'.',',')?></td>
        </tr><?php
}
?>
  </table>
