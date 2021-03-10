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
$fechaHasta=date("d/m/Y");
$ipOrigen="10.10.1.11";
$tabla_detalleOrigen="ADETALLE";
$codCiudadOrigen=verificarAlmacenCiudadExistente("ALMACE"); //PONER EL $AGE1 DEL ALMACEN ORIGEN
$age1Destino="A1";
//$age1Destino="A=";
$codCiudadDestino=verificarAlmacenCiudadExistente($age1Destino);
$codAlmacenDestino=obtenerCodigoAlmacenPorCiudad($codCiudadDestino);


?><br><br>Iniciando....<br><br><br><br><?php
$listAlma=obtenerListadoAlmacenesEspecifico($age1Destino);//web service
$contador=0;
foreach ($listAlma->lista as $alma) {
  $contador++;
  ?>EN SUC.: <?=$alma->des?> (<?=$alma->ip?>)<br><?php
  $age1=$alma->age1;
  $cod_existe=verificarAlmacenCiudadExistente($age1);
  //QUERY SUCURSAL ORIGEN (ALMACEN)
  $sql="SELECT am.DCTO,am.TIPO,am.GLO,am.FECHA,am.IDPROVEEDOR,am.IDPER2  FROM AMAESTRO am where am.STA!='B' AND am.TIPO='K' AND FECHA BETWEEN '$fechaDesde' AND '$fechaHasta' AND am.DAGE1='$age1'";
  $dbh = new ConexionFarma(); 
  if($ipOrigen!="10.10.1.11"){// verificar si es almacen para no cambiar la ip por defecto
    $dbh->setHost($ipOrigen);
    $dbh->start($ip);
  }
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $ip=$alma->ip;

  $dctoArray=[];$idc=0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $dctoOrigen=$row['DCTO'];
      $dctoArray[$idc]=$dctoOrigen;
      $idc++;
      //BUSCAR SALIDAS
      $sqlSalida = "SELECT IFNULL(nota_entrega,0) from ingreso_pendientes_almacenes where nota_entrega=$dctoOrigen and cod_almacen=$codAlmacenDestino";
      $resp = mysqli_query($enlaceCon,$sqlSalida);
      $ingreso_traspaso=mysqli_result($resp,0,0);
     if($ingreso_traspaso==0){
      $tipoOrigen=$row['TIPO'];
      $gloOrigen=$row['GLO'];
      $fechaOrigen=$row['FECHA'];
      $codProveedor=$row['IDPROVEEDOR'];
      $codPersonal=$row['IDPER2']; //revisar si guarda la columna con valores 0
      $codCiudadDestino=$cod_existe;
      $codigoUnico=obtenerCodigoTraspasoDocumentos($tabla_detalleOrigen,$tipoOrigen,$dctoOrigen,$ipOrigen);   
     ?>DOCUMENTO: <?=$dctoOrigen?><?php         

     $existeCon=verificarExisteTraspasoDocumentos("VDETALLE","VMAESTRO",$dctoOrigen,$codigoUnico,$ip);
      if((int)$existeCon>0){
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


$sql = "select IFNULL(MAX(cod_ingreso_almacen)+1,1) from ingreso_pendientes_almacenes order by cod_ingreso_almacen desc";
$resp = mysqli_query($enlaceCon,$sql);
$codigo=mysqli_result($resp,0,0);

$sql = "select IFNULL(MAX(nro_correlativo)+1,1) from ingreso_pendientes_almacenes where cod_almacen='$codAlmacenDestino' order by cod_ingreso_almacen desc";
$resp = mysqli_query($enlaceCon,$sql);
$nro_correlativo=mysqli_result($resp,0,0);

$hora_sistema = date("H:i:s");

$tipo_ingreso=1000; //INGRESO POR TRASPASO CENTRAL
$nota_entrega=$dctoOrigen;//SE ALMACENA EL DCTO
$nro_factura=0;// NRO DE FACTURA
$observaciones=$gloOrigen;
$proveedor=$codProveedor;

$createdBy=$codPersonal;
$createdDate=date("Y-m-d H:i:s");

$fecha_real=date("Y-m-d");
               $consulta="insert into ingreso_pendientes_almacenes (cod_ingreso_almacen,cod_almacen,cod_tipoingreso,fecha,hora_ingreso,observaciones,cod_salida_almacen,nota_entrega,nro_correlativo,ingreso_anulado,cod_tipo_compra,cod_orden_compra,nro_factura_proveedor,factura_proveedor,estado_ingreso,cod_proveedor,created_by,modified_by,created_date,modified_date) values($codigo,$global_almacen,$tipo_ingreso,'$fecha_real','$hora_sistema','$observaciones','0','$nota_entrega','$nro_correlativo',0,0,0,$nro_factura,0,0,'$proveedor','$createdBy','0','$createdDate','')";
           //echo $consulta."<br>";
               $sql_inserta = mysqli_query($enlaceCon,$consulta);
               $sql="DELETE FROM ingreso_pendientes_detalle_almacenes WHERE cod_ingreso_almacen=$codigo";
               $sqlDelete=mysqli_query($enlaceCon,$sql);
                
               $sqlDetalle="SELECT CPROD,PREVEN,HCAN,FECVEN,LOTEFAB FROM ADETALLE WHERE DCTO=$dctoOrigen AND TIPO='K' AND DAGE1='$age1'";
             //  echo $sqlDetalle."<br>";
        $dbh = new ConexionFarma(); 
        $stmtDetalle = $dbh->prepare($sqlDetalle);
        $stmtDetalle->execute();
        while ($rowDet = $stmtDetalle->fetch(PDO::FETCH_ASSOC)) {
          $codMaterial=$rowDet["CPROD"];
          $precioMaterial=$rowDet["PREVEN"];
          $cantidadMaterial=$rowDet["HCAN"];
          $fechaVenMaterial=$rowDet["FECVEN"];
          $loteFabMaterial=$rowDet["LOTEFAB"];
          $consultaDetalle="insert into ingreso_pendientes_detalle_almacenes (cod_ingreso_almacen,cod_material,cantidad_unitaria,precio_bruto,costo_almacen,fecha_vencimiento,lote) values($codigo,$codMaterial,$cantidadMaterial,'$precioMaterial','$precioMaterial','$fechaVenMaterial','$loteFabMaterial')";
          echo $consultaDetalle."<br>";
          $sql_insertaDetalle = mysqli_query($enlaceCon,$consultaDetalle);
        }
      }

  ?><br><?php    

       }
    }  //fin de WHILE
   if(count($dctoArray)>0){
     $stringDCTO=implode(",",$dctoArray);
   }else{
     $stringDCTO=-999999; // PARA ELIMINAR TODOS NO SE ENCONTRO NINGUNO
   }

   //BORRAR CABECERAS
   $sql="DELETE FROM ingreso_pendientes_almacenes where cod_almacen=$codAlmacenDestino and nota_entrega NOT IN ($stringDCTO) and estado_ingreso=0";
   $sqlDelete=mysqli_query($enlaceCon,$sql); 
   //BORRAR DETALLES
   $sql="DELETE FROM ingreso_pendientes_detalle_almacenes WHERE cod_ingreso_almacen IN (SELECT cod_ingreso_almacen FROM ingreso_pendientes_almacenes where cod_almacen=$codAlmacenDestino and nota_entrega NOT IN ($stringDCTO) and estado_ingreso=0)";
   $sqlDelete=mysqli_query($enlaceCon,$sql); 
}
 
$dbh = null;
echo "Realizado! Total Almacenes".$contador;


?></body>
</html>
