<?php
ini_set('memory_limit','1G');
set_time_limit(0);

require_once __DIR__.'/../conexion_externa_farma.php';
require_once '../function_web.php';
if(file_exists('descarga_file.csv')){
    unlink('descarga_file.csv');
}

$fp = fopen('descarga_file.csv', 'w');


$idProveedor=implode(",",$_POST["proveedor"]);
$fechaI=explode("-",$_POST["desde"]);
$fechaF=explode("-",$_POST["hasta"]);
$fechaInicio=$fechaI[2]."/".$fechaI[1]."/".$fechaI[0];
$fechaFinal=$fechaF[2]."/".$fechaF[1]."/".$fechaF[0];

$listAlma=obtenerListadoAlmacenes();
$dbh = new ConexionFarma();
$sql="SELECT p.IDPROVEEDOR,(SELECT DES FROM PROVEEDORES WHERE IDPROVEEDOR=p.IDPROVEEDOR) AS DES_PROV,p.IDSLINEA,(SELECT DES FROM PROVEESLINEA WHERE IDSLINEA=p.IDSLINEA) AS DES_LINEA,
  p.CPROD,p.DES
  FROM APRODUCTOS p  
  WHERE p.IDPROVEEDOR in ($idProveedor) ORDER BY p.IDSLINEA;";
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $cod_prov=$row['IDPROVEEDOR'];
   $cod_linea=$row['IDSLINEA'];
   $cod_prod=$row['CPROD'];
   $des_prov=$row['DES_PROV'];
   $des_linea=$row['DES_LINEA'];
   $des_prod=$row['DES'];

   foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      $datosVentas=obtenerValoresVentasProducto($cod_prod,$ip,$fechaInicio,$fechaFinal);
      $cant_ven=$datosVentas[0];
      $monto_ven=$datosVentas[1];
      $saldo_prod=$datosVentas[2];
      fputcsv($fp, array($nombre,$cod_prod,$des_prod,$cant_ven,number_format($monto_ven,2,'.',''),$saldo_prod),';');     
   }
}
fclose($fp);
?>
<script>
window.location.href = 'descarga_file.csv';
</script>
<?php
