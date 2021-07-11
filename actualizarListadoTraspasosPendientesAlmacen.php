<?php
//ini_set('memory_limit','1G');
set_time_limit(0);
require_once __DIR__.'/conexion_externa_farma.php';
$estilosVenta=1;
require 'conexionmysqli2.inc';
require_once 'function_web.php';
$ciudad=$_COOKIE["global_agencia"];
$global_almacen=$_COOKIE["global_almacen"];
$sql_detalle="SELECT codigo_anterior from ciudades where cod_ciudad='$ciudad'";
$codigo="";        
$resp=mysqli_query($enlaceCon,$sql_detalle);
while($detalle=mysqli_fetch_array($resp)){  
   $codigo=$detalle[0];     
}

//DATOS PARA LISTAR DOCUMENTOS
$fechaDesde="18/05/2021";
$fechaHasta=date("d/m/Y");
$ipOrigen="10.10.1.11";
$tabla_detalleOrigen="ADETALLE";
$age1Destino=$codigo;
$codCiudadDestino=verificarAlmacenCiudadExistente($age1Destino);
$codAlmacenDestino=obtenerCodigoAlmacenPorCiudad($codCiudadDestino);
$listAlma=obtenerListadoAlmacenesEspecifico($age1Destino);//web service
$contador=0;


$sqlNotas="SELECT nota_entrega FROM ingreso_pendientes_almacenes where cod_almacen='$codAlmacenDestino' and estado_ingreso=1;";   
$respNotas=mysqli_query($enlaceCon,$sqlNotas);
$arrayIngresados=[];$in=0;
while($datNotas=mysqli_fetch_array($respNotas)){  
   $arrayIngresados[$in]=$datNotas[0];   
   $in++;
}
$noDCTO="";
if(count($arrayIngresados)>0){
  $dctosIngre=implode(",", $arrayIngresados);
  $noDCTO=" AND am.DCTO NOT IN (".$dctosIngre.") ";
}

//BORRAR LOS QUE NO ESTAN INGRESADOS
$sql_borrar="SELECT cod_ingreso_almacen FROM ingreso_pendientes_almacenes where cod_almacen='$codAlmacenDestino' and estado_ingreso=0;";   
$resp_borrar=mysqli_query($enlaceCon,$sql_borrar);
while($det_borrar=mysqli_fetch_array($resp_borrar)){  
   $codPendiente=$det_borrar[0]; 
   $sqlPendienteDetalle="DELETE FROM ingreso_pendientes_detalle_almacenes WHERE cod_ingreso_almacen = '$codPendiente'";
   mysqli_query($enlaceCon,$sqlPendienteDetalle);     
}
$sql="DELETE FROM ingreso_pendientes_almacenes where cod_almacen='$codAlmacenDestino' and estado_ingreso=0;";
$sqlDelete=mysqli_query($enlaceCon,$sql); 


foreach ($listAlma->lista as $alma) {
  $contador++;
  $age1=$alma->age1;
  $cod_existe=verificarAlmacenCiudadExistente($age1);
  $sql="SELECT am.DCTO,am.TIPO,am.GLO,am.FECHA,am.IDPROVEEDOR,am.IDPER2  FROM AMAESTRO am where am.STA!='B' AND am.TIPO='K' AND FECHA BETWEEN '$fechaDesde' AND '$fechaHasta' AND am.DAGE1='$age1' $noDCTO";
  $dbh = new ConexionFarma(); 
  if($ipOrigen!="10.10.1.11"){// verificar si es almacen para no cambiar la ip por defecto
    $dbh->setHost($ipOrigen);
    $dbh->start($ip);
  }
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $ip=$alma->ip;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $dctoOrigen=$row['DCTO'];
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
     $existeCon=verificarExisteTraspasoDocumentos("VDETALLE","VMAESTRO",$dctoOrigen,$codigoUnico,$ip);
      if((int)$existeCon>0){
      }else{
       //HABILITAMOS LA BANDERA DE VENCIDOS PARA ACTUALIZAR EL PRECIO

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
                
               $sqlDetalle="SELECT CPROD,PREVEN,PREUNIT,HCAN,FECVEN,HCAN1,DCAN,DCAN1,LOTEFAB,DIV,APU,PRECOSTO  FROM ADETALLE WHERE DCTO=$dctoOrigen AND TIPO='K' AND DAGE1='$age1'";
             //  echo $sqlDetalle."<br>";
        $dbh = new ConexionFarma(); 
        $stmtDetalle = $dbh->prepare($sqlDetalle);
        $stmtDetalle->execute();
        while ($rowDet = $stmtDetalle->fetch(PDO::FETCH_ASSOC)) {
          $codMaterial=$rowDet["CPROD"];
          //$precioMaterial=(float)$rowDet["PREUNIT"];//APLICAR EL 
          $precioCosto=(float)$rowDet["PRECOSTO"];//APLICAR EL 
          //$precioMaterial=(float)$rowDet["PREUNIT"]-(float)$rowDet["PREUNIT"]*0.18;//APLICAR EL PORCENTAJE 18% DE DESCUENTO
          /*$cantidadMaterial=$rowDet["DCAN"];
          if($cantidadMaterial==0){
            $cantidadMaterial=$rowDet["DCAN1"];
          }*/
          $cantidadPresentacion=$rowDet["DIV"];
          $cantidadMaterial=$rowDet["HCAN"]*$cantidadPresentacion;
          if($cantidadMaterial==0){
            $cantidadMaterial=$rowDet["HCAN1"];
          }
          $fechaVenMaterial=$rowDet["FECVEN"];
          $loteFabMaterial=$rowDet["LOTEFAB"];
          $APU=$rowDet["APU"];
          $consultaDetalle="insert into ingreso_pendientes_detalle_almacenes (cod_ingreso_almacen,cod_material,cantidad_unitaria,precio_bruto,costo_almacen,fecha_vencimiento,lote,orden) values($codigo,$codMaterial,$cantidadMaterial,'$precioCosto','$precioCosto','$fechaVenMaterial','$loteFabMaterial',$APU)";
          //echo $consultaDetalle."<br>";
          $sql_insertaDetalle = mysqli_query($enlaceCon,$consultaDetalle);
        }
      }

  ?><br><?php    

       }
    }  //fin de WHILE

} 
$dbh = null;

?><script type="text/javascript">window.location.href='navegador_ingresotransitoalmacen.php'</script><?php
