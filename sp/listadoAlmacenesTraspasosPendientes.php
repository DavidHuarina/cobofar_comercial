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


//DATOS PARA LISTAR DOCUMENTOS
$fechaDesde="01/01/2021";
$fechaHasta="06/03/2021";
$ipOrigen="10.10.1.11";
$tabla_detalleOrigen="ADETALLE";
$codCiudadOrigen=verificarAlmacenCiudadExistente("ALMACE"); //PONER EL $AGE1 DEL ALMACEN ORIGEN
$age1Destino="A1";
$codCiudadDestino=verificarAlmacenCiudadExistente($age1Destino);
$codAlmacenDestino=obtenerCodigoAlmacenPorCiudad($codCiudadDestino);
$sql="DELETE FROM ingreso_pendientes_almacenes where cod_almacen=$codAlmacenDestino";
$sqlDelete=mysqli_query($enlaceCon,$sql);

?><br><br>Iniciando....<br><br><br><br><?php
$listAlma=obtenerListadoAlmacenesEspecifico($age1Destino);//web service
$contador=0;
foreach ($listAlma->lista as $alma) {
  $contador++;
  ?>EN SUC.: <?=$alma->des?> (<?=$alma->ip?>)<br><?php
  $age1=$alma->age1;
  $cod_existe=verificarAlmacenCiudadExistente($age1);
  //QUERY SUCURSAL ORIGEN (ALMACEN)
  $sql="SELECT am.DCTO,am.TIPO,am.GLO,am.FECHA,am.IDPROVEEDOR  FROM AMAESTRO am where am.STA!='B' AND am.TIPO='K' AND FECHA BETWEEN '$fechaDesde' AND '$fechaHasta' AND am.DAGE1='$age1'";
  $dbh = new ConexionFarma(); 
  if($ipOrigen!="10.10.1.11"){// verificar si es almacen para no cambiar la ip por defecto
    $dbh->setHost($ipOrigen);
    $dbh->start($ip);
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
      $codProveedor=$row['IDPROVEEDOR'];
      $codCiudadDestino=$cod_existe;
      $codigoUnico=obtenerCodigoTraspasoDocumentos($tabla_detalleOrigen,$tipoOrigen,$dctoOrigen,$ipOrigen);   
     ?>DOCUMENTO: <?=$dctoOrigen?><?php         

     $existeCon=verificarExisteTraspasoDocumentos("VDETALLE","VMAESTRO",$dctoOrigen,$codigoUnico,$ip);
      if((int)$existeCon==1){
        ?>SE INGRESO EL DOC <?php
        //insertar datos documento
         /*$sql="INSERT INTO traspasos_pendientes (cod_documento,cod_documento_entrada,tipo_documento,descripcion,fecha_entrada,fecha_salida,cod_ciudad_origen,cod_ciudad_destino,codigo_unico_generado) VALUES($dctoOrigen,$tipoOrigen,'$gloOrigen','$fechaOrigen')";*/
      }else{
       ?>NO EXISTE <?php

       //HABILITAMOS LA BANDERA DE VENCIDOS PARA ACTUALIZAR EL PRECIO
$banderaPrecioUpd=0;
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=7";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$banderaPrecioUpd=mysqli_result($respConf,0,0);


$sql = "select IFNULL(MAX(cod_ingreso_almacen)+1,1) from ingreso_almacenes order by cod_ingreso_almacen desc";
$resp = mysqli_query($enlaceCon,$sql);
$codigo=mysqli_result($resp,0,0);

$sql = "select IFNULL(MAX(nro_correlativo)+1,1) from ingreso_almacenes where cod_almacen='$global_almacen' order by cod_ingreso_almacen desc";
$resp = mysqli_query($enlaceCon,$sql);
$nro_correlativo=mysqli_result($resp,0,0);

$hora_sistema = date("H:i:s");

$tipo_ingreso=1000; //INGRESO POR TRASPASO CENTRAL
$nota_entrega=0;
$nro_factura=0;// NRO DE FACTURA
$observaciones=$gloOrigen;
$proveedor=$codProveedor;

$createdBy=$_COOKIE['global_usuario'];
$createdDate=date("Y-m-d H:i:s");

$fecha_real=date("Y-m-d");


               $consulta="insert into ingreso_almacenes (cod_ingreso_almacen,cod_almacen,cod_tipoingreso,fecha,hora_ingreso,observaciones,cod_salida_almacen,nota_entrega,nro_correlativo,ingreso_anulado,cod_tipo_compra,cod_orden_compra,nro_factura_proveedor,factura_proveedor,estado_liquidacion,cod_proveedor,created_by,modified_by,created_date,modified_date) values($codigo,$global_almacen,$tipo_ingreso,'$fecha_real','$hora_sistema','$observaciones','0','$nota_entrega','$nro_correlativo',0,0,0,$nro_factura,0,0,'$proveedor','$createdBy','0','$createdDate','')";

               $sql_inserta = mysqli_query($enlaceCon,$consulta);


       //insertar datos documento
        $sqlInsert="INSERT INTO ingreso_pendientes_almacenes (cod_documento,tipo_documento,descripcion,fecha_salida,cod_ciudad_origen,cod_ciudad_destino,codigo_unico_generado) VALUES($dctoOrigen,'$tipoOrigen','$gloOrigen','$fechaOrigen',$codCiudadOrigen,$codCiudadDestino,'$codigoUnico')";
        $executeInsert=mysqli_query($enlaceCon,$sqlInsert);
      }


  ?><br><?php       
    }   
}
 
$dbh = null;
echo "Realizado! Total Almacenes".$contador;


?></body>
</html>
