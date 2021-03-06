<?php
ini_set('memory_limit','1G');
set_time_limit(0);
require_once __DIR__.'/../conexion_externa_farma.php';
//$estilosVenta=1;
require '../conexionmysqli.inc';
require_once '../function_web.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>CONEXION SUCURSALES</title>
  <meta charset="utf-8">
</head>
<body>

<?php
set_time_limit(0);

//DATOS PARA LISTAR DOCUMENTOS
$fechaDesde="01/03/2021";
$fechaHasta=date("d/m/Y");
$fechaHastaFormato=date("Y-m-d");
$ipOrigen="10.10.1.11";
$tabla_detalleOrigen="ADETALLE";
$codCiudadOrigen=verificarAlmacenCiudadExistente("ALMACE"); //PONER EL $AGE1 DEL ALMACEN ORIGEN
$age1Destino="A=";
//$age1Destino="A=";
$codCiudadDestino=verificarAlmacenCiudadExistente($age1Destino);
$codAlmacenDestino=obtenerCodigoAlmacenPorCiudad($codCiudadDestino);


?><br><br><H4>LISTADO TRASPASOS PENDIENTES ENTRE SUCURSALES</H4><br><br>

<table class="table table-bordered table-condensed">
  <tr class='bg-success'><th>TIPO</th><th>DOCUMENTO</th><th>FECHA</th><th>SUCURSAL DESTINO</th><th>RESPONSABLE</th><th>SUCURSAL ORIGEN</th></tr>
<?php
$listAlma=obtenerListadoAlmacenes();//web service
$contador=0;
foreach ($listAlma->lista as $alma) {
  $contador++;
  $age1=$alma->age1;
  $cod_existe=verificarAlmacenCiudadExistente($age1);
  //QUERY SUCURSAL ORIGEN (ALMACEN)
  $sql="SELECT am.DCTO,am.TIPO,am.GLO,am.FECHA,am.IDPROVEEDOR,am.IDPER2,am.DAGE1,am.PASO   FROM VMAESTRO am where am.STA!='B' AND am.TIPO='K' AND FECHA BETWEEN '$fechaDesde' AND '$fechaHasta' AND DAGE1 IN (SELECT AGE1 FROM ALMACEN WHERE TIPO='X')";
  //echo $sql;
  $ip=$alma->ip;
  /*$dbh = new ConexionFarma(); 
  $dbh->setHost($ip);*/
  
  $dbh=ConexionFarma($ip,"Gestion");
if($dbh!=false){
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $dctoOrigen=$row['DCTO'];
      $tipoOrigen=$row['TIPO'];
      $gloOrigen=$row['GLO'];
      $fechaOrigen=$row['FECHA'];
      $codProveedor=$row['IDPROVEEDOR'];
      $codPersonal=$row['IDPER2']; //revisar si guarda la columna con valores 0
      $codSucursalDestino=$row['DAGE1'];
      $codPaso=$row['PASO'];
      $datos=verificarIpDestinoAlmacen($codSucursalDestino);
      $ipDestino=$datos[0];
      $sucDestino=$datos[1];
      $codCiudadDestino=$cod_existe;  
     $existeCon=verificarExisteTraspasoDocumentosSucursal("VDETALLE","VMAESTRO",$dctoOrigen,$ipDestino,strftime('%d/%m/%Y', strtotime($fechaOrigen)));          
      if((int)$existeCon>0){
        /*echo "<tr><td><small><small>".$alma->des."</small></small></td><td>".$ip."</td><td>".$codSucursalDestino."</td><td>".$codSucursalDestino."</td><td>".$ipDestino."</td><td>".$existeCon."</td><td>".$dctoOrigen."</td></tr>";*/
      }else{
        $date1 = new DateTime($fechaOrigen);
        $date2 = new DateTime($fechaHastaFormato);
        $diff = $date1->diff($date2);
        $dias_restantes=$diff->days;
        $background="#fff";
        if((int)$dias_restantes>=2){
          $background="#F1C40F";
        }
        /*echo "<tr style='background:red;color:#fff;'><td colspan='6'><small><small>".$alma->des."<br>".$ip."</small></small></td></tr>";*/

        ?><tr style="background:<?=$background?>"><td><?=$tipoOrigen?></td><td><?=$dctoOrigen?></td><td><?=strftime('%d/%m/%Y', strtotime($fechaOrigen))?></td><td><?=$sucDestino?></td></td><td><?=obtenerNombrePersonalAbreviado($codPaso,$ip)?></td><td><?=$alma->des?></tr><?php
      }
    }  //fin de WHILE <?=obtenerNombrePersonalAbreviado($codPersonal,$ip)
  }
   $dbh = null;
}

?></table></body>
</html>

