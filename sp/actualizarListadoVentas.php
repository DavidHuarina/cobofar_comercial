<?php
ini_set('memory_limit','1G');
set_time_limit(0);
require_once __DIR__.'/../conexion_externa_farma.php';
require '../conexionmysqli.inc';
require_once '../function_web.php';
require_once '../funciones.php';
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
$fechaDesde="01/01/2020";
$fechaHasta="31/12/2020";
$dbh2 = new ConexionFarmaSucursal(); 
$dbh = new ConexionFarmaSucursal(); 
//$fechaHasta=date("d/m/Y");
?><br><br><h4>ACTUALIZACION DE VENTAS</h4><br><br>
<?php
$listAlma=obtenerListadoAlmacenesEspecifico("AG");//web service obtenerListadoAlmacenesEspecifico($age1Destino)   
$contador=0;
$sql = "select IFNULL(MAX(cod_salida_almacenes)+1,1) from salida_almacenes order by cod_salida_almacenes desc";
$resp = mysqli_query($enlaceCon,$sql);
$codigo=mysqli_result($resp,0,0);
foreach ($listAlma->lista as $alma) {
  $sqlInsertCabecera="";
  $$sqlInsertDetalleAc="";
  $contador++;
  $age1=$alma->age1;
  $cod_existe=verificarAlmacenCiudadExistente($age1);
  $cod_almacen=obtenerCodigoAlmacenPorCiudad($cod_existe);
  //QUERY SUCURSAL ORIGEN (ALMACEN)
  $sql="SELECT AGE1,DCTO,FECHA,GLO,MFACTURA,PAGO,RUC,PASO,DOCUM FROM VFICHAM WHERE TIPO='F' AND AGE1='$age1' AND FECHA BETWEEN '$fechaDesde 00:00:00' AND '$fechaHasta 23:59:59' AND (STA='V' OR STA='M') ORDER BY FECHA";
  $ip=$alma->ip;
 
  //$dbh->setHost($ip);
  //$verificarConexion=$dbh->start();
  $verificarConexion=true;
if($verificarConexion==true){
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $dctoOrigen=$row['DCTO'];
      $documOrigen=$row['DOCUM'];
      $tipoOrigen=$row['TIPO'];
      $gloOrigen=$row['GLO'];
      $fechaO=explode(" ",$row['FECHA']);
      $fechaOrigen=$fechaO[0];
      $horaOrigen=$fechaO[1];
      $montoFactura=$row['MFACTURA'];
      $montoPago=$row['PAGO'];
      $nit=$row['RUC'];
      $codPaso=$row['PASO'];

        $sqlInsertCabecera.="('$codigo','$cod_almacen',1001,1,'$fechaOrigen','$horaOrigen',0,0,'$dctoOrigen',1,'$documOrigen',0,146,'$montoFactura',0,'$montoFactura','$gloOrigen','$nit','$codPaso',0,'$montoPago',0,1),";
      
        $sqlDetalle="SELECT CPROD,CAN,CAN1,FECVEN,PREUNIT,DESCTO1,DESCTO2,DESCTO3 FROM VFICHAD WHERE DCTO='$dctoOrigen'";   
        
        //$dbh2->setHost($ip);
        //$dbh2->start();     
        $stmtDetalle = $dbh2->prepare($sqlDetalle);
        $stmtDetalle->execute();
        while ($rowDet = $stmtDetalle->fetch(PDO::FETCH_ASSOC)) {
          $codMaterial=$rowDet["CPROD"];
          $fechaV=explode(" ",$rowDet['FECVEN']);
          $fechaVen=$fechaV[0];
          $cantidadMaterial=(float)$rowDet["CAN"]+(float)$rowDet["CAN1"];

          $desc1=number_format($rowDet["PREUNIT"]*($rowDet["DESCTO1"]/100),2,'.','');          
          $precioUnit1=$rowDet["PREUNIT"]-$desc1;

          $desc2=number_format($precioUnit1*($rowDet["DESCTO2"]/100),2,'.','');
          $precioUnit2=$precioUnit1-$desc2;

          $desc3=number_format($precioUnit2*($rowDet["DESCTO3"]/100),2,'.','');
          $precioUnit3=number_format($precioUnit2-$desc3,2,'.','');
          $sqlInsertDetalleAc.="($codigo,$codMaterial,$cantidadMaterial,0,'$fechaVen','$precioUnit3',0,'$precioUnit3'),";         
          
        }
        //$dbh2=null;
        $codigo++;
      //echo $sql;
    }  //fin de WHILE 
    //AQUI INSERTAMOS LAS CABECERAS
    $sqlInsertCabecera = substr_replace($sqlInsertCabecera, '', -1, 1);
    $sqlInsertCab="INSERT INTO salida_almacenes (cod_salida_almacenes,cod_almacen,cod_tiposalida,cod_tipo_doc,fecha,hora_salida,territorio_destino,almacen_destino,observaciones,estado_salida,nro_correlativo,salida_anulada,cod_cliente,monto_total,descuento,monto_final,razon_social,nit,cod_chofer,cod_vehiculo,monto_cancelado,cod_dosificacion,cod_tipopago) VALUES ".$sqlInsertCabecera.";";
    $sqlinserta=mysqli_query($enlaceCon,$sqlInsertCab);

    //AQUI INSERTAMOS LOS DETALLES
    $sqlInsertDetalleAc = substr_replace($sqlInsertDetalleAc, '', -1, 1);
    $sqlInsertDet="INSERT INTO salida_detalle_almacenes (cod_salida_almacen,cod_material,cantidad_unitaria,lote,fecha_vencimiento,precio_unitario,descuento_unitario,monto_unitario) VALUES ".$sqlInsertDetalleAc.";";
    $sqlinsertadetalle=mysqli_query($enlaceCon,$sqlInsertDet);
    echo $sqlInsertCab."<br>";
    //echo $sqlInsertDet."<br>";
  }
   //$dbh = null;
}
echo "final";
?></table></body>
</html>
