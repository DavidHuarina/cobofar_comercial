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
require '../conexionmysqli.inc';
require_once '../function_web.php';

//DATOS PARA LISTAR REPORTE
$fechaDesde="01/03/2021";
$fechaHasta="31/03/2021";

?><h3>REPORTE MARKETING</h3><br><br><br><?php
$listAlma=obtenerListadoAlmacenes();//web service
$contador=0;
?>
<table class='table table-condensed table-sm table-bordered'>
  <tr>
    <th class='bg-info text-white'>SUCURSAL</th>
    <th class='bg-info text-white'>DOCUM</th>
    <th class='bg-info text-white'>GLO</th>
    <th class='bg-info text-white'>RUC</th>
    <th class='bg-info text-white'>FECHAT</th>
    <th class='bg-info text-white'>FECHA</th>
    <th class='bg-info text-white'>MFACTURA</th>
  </tr>
<?php
foreach ($listAlma->lista as $alma) {
  $contador++;
  $ip=$alma->ip;
  //QUERY SUCURSAL ORIGEN (ALMACEN)
  $sql="SELECT (select a.DES from dbo.ALMACEN a where a.AGE1=v.AGE1)as SUCURSAL,v.DOCUM, v.GLO, v.RUC, v.FECHAT, v.FECHA, v.MFACTURA from dbo.VFICHAM v where v.FECHA BETWEEN '$fechaDesde' and '$fechaHasta'";
  $dbh = new ConexionFarma(); 
  $dbh->setHost($ip);
  $verificarCon=$dbh->start();
  if($verificarCon==true){
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       ?><tr><td align='left'><?=$row['SUCURSAL']?></td>
          <td align='right'><?=$row['DOCUM']?></td>
          <td align='left'><?=$row['GLO']?></td>
          <td align='right'><?=$row['RUC']?></td>
          <td><?=strftime('%d/%m/%Y %H:%M', strtotime($row['FECHAT']))?></td>
          <td><?=strftime('%d/%m/%Y', strtotime($row['FECHA']))?></td>
          <td align='right'><?=number_format($row['MFACTURA'],2,'.',',')?></td>
        </tr><?php
     }  //fin de WHILE
  }
  $dbh = null;
}
?>
</table>

