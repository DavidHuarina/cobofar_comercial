<?php
ini_set('memory_limit','1G');
set_time_limit(0);

function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}
require_once __DIR__.'/../conexion_externa_farma.php';
require '../conexionmysqli.inc';
require_once '../function_web.php';

//DATOS PARA LISTAR REPORTE
$fechaDesde="01/03/2021";
$fechaHasta="31/03/2021";

?><h3>REPORTE MARKETING</h3><br><br><br><?php
$listAlma=obtenerListadoAlmacenes();//web service
$contador=0;

if(file_exists('descarga_file.csv')){
    unlink('descarga_file.csv');
}

download_send_headers("reporte_market_" . date("Y-m-d") . ".csv");
$fp = fopen('descarga_file.csv', 'w');

foreach ($listAlma->lista as $alma) {
  $contador++;
  $ip=$alma->ip;
  $sql="SELECT (select a.DES from dbo.ALMACEN a where a.AGE1=v.AGE1)as SUCURSAL,v.DOCUM, v.GLO, v.RUC, v.FECHAT, v.FECHA, v.MFACTURA from dbo.VFICHAM v where v.FECHA BETWEEN '$fechaDesde' and '$fechaHasta'";
  $dbh = new ConexionFarma(); 
  $dbh->setHost($ip);
  $verificarCon=$dbh->start();
  if($verificarCon==true){
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      fputcsv($fp, $row,';');       
     }  //fin de WHILE
  }
  $dbh = null;
}
fclose($fp);
?>
<script>
// Especifica la ruta correcta para el nuevo script
// Solo envía el nombre del archivo, sin directorio
window.location.href = 'descarga_file.csv';
</script>
<?php
die();

