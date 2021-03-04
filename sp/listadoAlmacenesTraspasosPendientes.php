<?php
ini_set('memory_limit','1G');
set_time_limit(0);
require_once __DIR__.'/../conexion_externa_farma.php';
require '../conexionmysqli.inc';
require_once '../function_web.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>

<?php
$sql="DELETE FROM traspasos_pendientes";
$sqlDelete=mysqli_query($enlaceCon,$sql);

//DATOS PARA LISTAR DOCUMENTOS
$fechaDesde="04/03/2021";
$fechaHasta="05/03/2021";
$ipOrigen="10.10.1.11";
$tabla_detalleOrigen="ADETALLE";
$codCiudadOrigen=verificarAlmacenCiudadExistente("ALMACE"); //PONER EL $AGE1 DEL ALMACEN ORIGEN


?><br><br>Iniciando....<br><br><br><br><?php
$listAlma=obtenerListadoAlmacenes();//web service
$contador=0;
foreach ($listAlma->lista as $alma) {
  $contador++;
  ?>EN SUC.: <?=$alma->des?> (<?=$alma->ip?>)<br><?php
  $age1=$alma->age1;
  $cod_existe=verificarAlmacenCiudadExistente($age1);
  //QUERY SUCURSAL ORIGEN (ALMACEN)
  $sql="SELECT am.DCTO,am.TIPO,am.GLO,am.FECHA  FROM AMAESTRO am where am.STA!='B' AND am.TIPO='K' AND FECHA BETWEEN '$fechaDesde' AND '$fechaHasta' AND am.DAGE1='$age1'";
  $dbh = new ConexionFarma(); 
  if($ipOrigen!="10.10.1.11"){// verificar si es almacen para no cambiar la ip por defecto
    $dbh->setHost($ipOrigen);
  }
  $stmt = $dbh->prepare($sql);
  $dbh=null;
  $stmt->execute();
  $ip=$alma->ip;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $dctoOrigen=$row['DCTO'];
      $tipoOrigen=$row['TIPO'];
      $gloOrigen=$row['GLO'];
      $fechaOrigen=$row['FECHA'];
      $codCiudadDestino=$cod_existe;
      $codigoUnico=obtenerCodigoTraspasoDocumentos($tabla_detalleOrigen,$tipoOrigen,$dctoOrigen,$ipOrigen);   
     ?>DOCUMENTO: <?=$dctoOrigen?><?php         

     $existeCon=verificarExisteTraspasoDocumentos("VDETALLE","VMAESTRO",$dctoOrigen,$codigoUnico,$ip);
      if($existeCon==1){
        ?>SE INGRESO EL DOC <?php
        //insertar datos documento
         /*$sql="INSERT INTO traspasos_pendientes (cod_documento,cod_documento_entrada,tipo_documento,descripcion,fecha_entrada,fecha_salida,cod_ciudad_origen,cod_ciudad_destino,codigo_unico_generado) VALUES($dctoOrigen,$tipoOrigen,'$gloOrigen','$fechaOrigen')";*/
      }else{
       ?>NO EXISTE <?php
       //insertar datos documento
        $sqlInsert="INSERT INTO traspasos_pendientes (cod_documento,tipo_documento,descripcion,fecha_salida,cod_ciudad_origen,cod_ciudad_destino,codigo_unico_generado) VALUES($dctoOrigen,'$tipoOrigen','$gloOrigen','$fechaOrigen',$codCiudadOrigen,$codCiudadDestino,'$codigoUnico')";
        $executeInsert=mysqli_query($enlaceCon,$sqlInsert);
      }


  ?><br><?php       
    }   
}
 
$dbh = null;
echo "Realizado! Total Almacenes".$contador;


?></body>
</html>
