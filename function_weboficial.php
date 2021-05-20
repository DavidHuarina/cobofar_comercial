<?php
function obtenerIPAnterioirSucursal($ipCentral,$age1){
  set_time_limit(0);
  require_once __DIR__.'/conexion_externa_farma_solo.php';
  $dbh = conexionSqlServer($ipCentral,"Gestion");  
  $ip="";
  if($dbh!=false){
    $sql="SELECT IP FROM ALMACEN WHERE AGE1='$age1';";
    $stmt=sqlsrv_query($dbh,$sql);    
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $ip=$row['IP'];         
    }
    sqlsrv_close($dbh);
  }  
  return $ip;
}

function obtenerValoresSaldosProductoOficial($cod_prod,$ip,$fechaFinal,$age1,$tipo,$cantidadPres){
    $ing=obtenerIngresosProducto($cod_prod,$ip,$fechaFinal,$age1);
    $sal=obtenerSalidasProducto($cod_prod,$ip,$fechaFinal,$age1);
    $ingresos=$ing[0];
    $salidas=$sal[0];
    $ingresos_unitario=$ing[1];  
    $salidas_unitario=$sal[1];
    $saldoCajas=$ingresos+$salidas;
    $saldoUnidad=$ingresos_unitario+$salidas_unitario;
    if($tipo==1){//CAJAS
      $saldo=$saldoCajas+($saldoUnidad/$cantidadPres);
    }else{ //SALDO UNIDAD
      $saldo=$saldoUnidad+($saldoCajas*$cantidadPres); 
    } 
  return $saldo;
}

function obtenerIngresosProducto($cod_prod,$ip,$fechaFinal,$age1){
  set_time_limit(0);
  $dbh = conexionSqlServer($ip,"Gestion");  
  //require_once __DIR__.'/conexion_externa_farma_solo.php';
  //$dbh = ConexionFarma($ip,"Gestion");
  $ingreso=0;
  $ingreso_unidad=0;
  if($dbh!=false){
    $sql="SELECT ISNULL(SUM(D.DCAN-D.HCAN),0)INGRESO,ISNULL(SUM(D.DCAN1-D.HCAN1),0)INGRESO_UNIDAD FROM VDETALLE D WHERE D.TIPO in ('A','D','S') AND AGE1='$age1' and D.FECHA<='$fechaFinal' AND D.CPROD='$cod_prod'";
    $stmt=sqlsrv_query($dbh,$sql);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $ingreso=$row['INGRESO']; 
      $ingreso_unidad=$row['INGRESO_UNIDAD'];         
    }
    sqlsrv_close($dbh);
  }
  return array($ingreso,$ingreso_unidad);
}
function obtenerSalidasProducto($cod_prod,$ip,$fechaFinal,$age1){
  set_time_limit(0);
  $dbh = conexionSqlServer($ip,"Gestion");  
  $salida=0;
  $salida_unidad=0;
  if($dbh!=false){
    $sql="SELECT ISNULL(SUM(D.DCAN-D.HCAN),0)SALIDA,ISNULL(SUM(D.DCAN1-D.HCAN1),0)SALIDA_UNIDAD FROM VDETALLE D WHERE D.TIPO in ('K','F','O') AND AGE1='$age1' and D.FECHA<='$fechaFinal' AND D.CPROD='$cod_prod'";
    $stmt=sqlsrv_query($dbh,$sql);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $salida=$row['SALIDA']; 
      $salida_unidad=$row['SALIDA_UNIDAD'];         
    }
    sqlsrv_close($dbh);
  }
  return array($salida,$salida_unidad);
}

function obtenerValoresVentasProductoOficial($cod_prod,$ip,$fechaInicio,$fechaFinal,$tipo,$cantidadPres){
    $ventas=obtenerCantidadVentasProducto($cod_prod,$ip,$fechaInicio,$fechaFinal);
    $ventas=$ing[0];
    $ventas_unitario=$ing[1];  
    if($tipo==1){//CAJAS
      $ventasProducto=$ventas+($ventas_unitario/$cantidadPres);
    }else{ //SALDO UNIDAD
      $ventasProducto=$ventas_unitario+($ventas*$cantidadPres); 
    } 
  return $ventasProducto;
}


function obtenerCantidadVentasProducto($cod_prod,$ip,$fechaInicio,$fechaFinal){
  set_time_limit(0);
  $dbh = conexionSqlServer($ip,"Gestion");  
  $cantidad=0;
  $cantidad_unidad=0;
  if($dbh!=false){
    $sql="SELECT ISNULL(SUM(d.CAN),0)CANTIDAD,ISNULL(SUM(d.CAN1),0)CANTIDAD_UNIDAD FROM VFICHAD d WHERE d.STA in ('V','M') AND d.tipo in ('F')  AND d.CPROD='$cod_prod' AND d.fecha BETWEEN '$fechaInicio' AND '$fechaFinal'";
    $stmt=sqlsrv_query($dbh,$sql);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $cantidad=$row['CANTIDAD']; 
      $cantidad_unidad=$row['CANTIDAD_UNIDAD'];         
    }
    sqlsrv_close($dbh);
  }
  return array($cantidad,$cantidad_unidad);
}

function cargarValoresVentasYSaldosProductoOficial($almacen,$ipAlma,$fecha_venta2,$fecha_venta_al2,$fecha_saldo2,$ageAlma,$tipo,$linea){
  set_time_limit(0);
  $codigoUserScan=$_COOKIE['global_usuario'];
  $estilosVenta=1;
  require("conexionmysqli.inc"); 
  $dbh = conexionSqlServer($ipAlma,"Gestion"); 
  $sqlInsertPedidos="";
  if($dbh!=false){
    //INGRESOS
    $sql2="SELECT P.CPROD,(
SELECT ISNULL(SUM(D.DCAN-D.HCAN),0)
FROM VDETALLE D
WHERE D.TIPO in ('A','D','S') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)INGRESO,(
SELECT ISNULL(SUM(D.DCAN1-D.HCAN1),0)
FROM VDETALLE D
WHERE D.TIPO in ('A','D','S') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)INGRESO_UNIDAD,(
SELECT ISNULL(SUM(D.DCAN-D.HCAN),0)
FROM VDETALLE D
WHERE D.TIPO in ('K','F','O') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)SALIDA,(
SELECT ISNULL(SUM(D.DCAN1-D.HCAN1),0)
FROM VDETALLE D
WHERE D.TIPO in ('K','F','O') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)SALIDA_UNIDAD,
(SELECT ISNULL(SUM(d.CAN+d.CAN1),0) FROM VFICHAD d
WHERE d.STA in ('V','M') AND d.tipo in ('F') AND d.fecha 
BETWEEN '$fecha_venta2' AND '$fecha_venta_al2' AND d.CPROD=P.CPROD
)VENTAS_CANTIDAD
FROM APRODUCTOS P 
WHERE P.IDSLINEA IN ($linea) AND P.STA='A';";
/*$sql="EXEC master.dbo.sp_configure 'show advanced options', 1
RECONFIGURE";
$stmt=sqlsrv_query($dbh,$sql);
$stmt=sqlsrv_query($dbh,$sql);
$sql="EXEC xp_cmdshell 'bcp \"".$sql2."\" queryout \"C:\bcptest.txt\" -T -c -t,'";*/
$stmt=sqlsrv_query($dbh,$sql2);
$result = array(); 
do {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
       $result[] = $row; 
    }
} while (sqlsrv_next_result($stmt));
file_put_contents(__DIR__."/temp_pedidos/pedido_".$almacen.".json", json_encode($result));
    /*while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $codMaterial=$row["CPROD"];
      $ingreso=$row["INGRESO"];
      $ingreso_unitaria=$row["INGRESO_UNIDAD"];
      $salida=$row["SALIDA"];
      $salida_unitaria=$row["SALIDA_UNIDAD"];
      $ventas=$row["VENTAS_CANTIDAD"];
      $sqlInsertPedidos.="('$codigoUserScan','$almacen','$codMaterial','$ingreso','$ingreso_unitaria','$salida','$salida_unitaria','$ventas'),";       
    }*/
    sqlsrv_close($dbh);
    //$sqlInsertPedidos = substr_replace($sqlInsertPedidos, '', -1, 1);
    //$sqlInsertPedidos="INSERT INTO temp_pedidos VALUES ".$sqlInsertPedidos.";";
    //$sqlinserta=mysqli_query($enlaceCon,$sqlInsertPedidos);
    //mysqli_close($enlaceCon);
  }
}


function cargarValoresVentasYSaldosProductoOficialArray($almacen,$ipAlma,$fecha_venta2,$fecha_venta_al2,$fecha_saldo2,$ageAlma,$tipo,$linea,$productos){
  set_time_limit(0);
  $codigoUserScan=$_COOKIE['global_usuario'];
  $dbh = conexionSqlServer($ipAlma,"Gestion"); 
  $ingresos=[];
  $ingresos_unidad=[];
  $salida=[];
  $salida_unidad=[];
  $ventas=[];
  $ventas_unidad=[];
  $devoluciones=[];
  $devoluciones_unidad=[];
  if($dbh!=false){
    //INGRESOS
    $sqlIngreso="SELECT D.CPROD,ISNULL(SUM(D.DCAN-D.HCAN),0)INGRESO,ISNULL(SUM(D.DCAN1-D.HCAN1),0)INGRESO_UNIDAD FROM VDETALLE D WHERE D.TIPO in ('A','D','S') AND AGE1='$ageAlma' and D.FECHA<='$fecha_saldo2' AND D.CPROD in ($productos) GROUP BY D.CPROD;";
    $stmt=sqlsrv_query($dbh,$sqlIngreso);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $ingresos[$row['CPROD']]=$row['INGRESO']; 
      $ingresos_unidad[$row['CPROD']]=$row['INGRESO_UNIDAD'];               
    }

    //SALIDAS
    $sqlSalida="SELECT D.CPROD,ISNULL(SUM(D.DCAN-D.HCAN),0)SALIDA,ISNULL(SUM(D.DCAN1-D.HCAN1),0)SALIDA_UNIDAD FROM VDETALLE D WHERE D.TIPO in ('K','F','O') AND AGE1='$ageAlma' and D.FECHA<='$fecha_saldo2' AND D.CPROD in ($productos) GROUP BY D.CPROD;";
    $stmt=sqlsrv_query($dbh,$sqlSalida);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $salida[$row['CPROD']]=$row['SALIDA'];  
      $salida_unidad[$row['CPROD']]=$row['SALIDA_UNIDAD'];            
    }

    //VENTAS
    $sqlVentas="SELECT d.CPROD,ISNULL(SUM(d.CAN),0)VENTAS,ISNULL(SUM(d.CAN1),0)VENTAS_UNIDAD FROM VFICHAD d WHERE d.STA in ('V','M') AND d.tipo in ('F') AND d.fecha >= '$fecha_venta2' AND d.fecha <='$fecha_venta_al2' AND d.CPROD in ($productos) GROUP BY d.CPROD;";
    $stmt=sqlsrv_query($dbh,$sqlVentas);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $ventas[$row['CPROD']]=$row['VENTAS'];  
      $ventas_unidad[$row['CPROD']]=$row['VENTAS_UNIDAD'];             
    }
    //DEVOLUCIONES
    $sqlVentas="SELECT D.CPROD,ISNULL(SUM(D.DCAN-D.HCAN),0)DEVUELTO,ISNULL(SUM(D.DCAN1-D.HCAN1),0)DEVUELTO_UNIDAD FROM VDETALLE D WHERE D.TIPO in ('K') AND DAGE1='AZ' AND d.fecha >= '$fecha_venta2' AND d.fecha <='$fecha_venta_al2' AND D.CPROD in ($productos) GROUP BY D.CPROD;";
    $stmt=sqlsrv_query($dbh,$sqlVentas);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $devoluciones[$row['CPROD']]=$row['DEVUELTO']; 
      $devoluciones_unidad[$row['CPROD']]=$row['DEVUELTO_UNIDAD'];             
    }
  }
  return array($ingresos,$ingresos_unidad,$salida,$salida_unidad,$ventas,$ventas_unidad,$devoluciones,$devoluciones_unidad);
}

function conexionSqlServer($ip,$database){
  $serverName = $ip;
  $uid = "sistema";     
  $pwd = "sistema";
  if($ip!="10.10.1.11"){
     $enlaceCon=mysqli_connect("127.0.0.1","root","","farmaciasalmacen");
     $sql = "SELECT ip FROM sucursales_minusculas where ip='$ipCon'";
     $resp = mysqli_query($enlaceCon,$sql);
     $ipSuc=mysqli_result($resp,0,0);
     $pwd="B0l1v14.@1202";
     if($serverName==$ipSuc){
          $pwd="B0l1v14.@1202";
     }
  }    
  $databaseName = $database;  
  $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=>$databaseName);  
  $conn = sqlsrv_connect( $serverName, $connectionInfo);  
  if( $conn ){  
    return $conn;
  }else{  
     return false;
  }  
  //sqlsrv_close( $conn);  
}

function cargarValoresVentasYSaldosProductoOficial3($almacen,$ipAlma,$fecha_venta2,$fecha_venta_al2,$fecha_saldo2,$ageAlma,$tipo,$linea){
  set_time_limit(0);
  $dbh = conexionSqlServer($ipAlma,"Gestion");  
  $ingresos_p=0;
  $ingresosu_p=0;
  $salidas_p=0;
  $salidasu_p=0;
  $ventas_p=0;
  if($dbh!=false){
    //INGRESOS
    $sql="SELECT P.CPROD,(
SELECT ISNULL(SUM(D.DCAN-D.HCAN),0)
FROM VDETALLE D
WHERE D.TIPO in ('A','D','S') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)INGRESO,(
SELECT ISNULL(SUM(D.DCAN1-D.HCAN1),0)
FROM VDETALLE D
WHERE D.TIPO in ('A','D','S') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)INGRESO_UNIDAD,(
SELECT ISNULL(SUM(D.DCAN-D.HCAN),0)
FROM VDETALLE D
WHERE D.TIPO in ('K','F','O') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)SALIDA,(
SELECT ISNULL(SUM(D.DCAN1-D.HCAN1),0)
FROM VDETALLE D
WHERE D.TIPO in ('K','F','O') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)SALIDA_UNIDAD,
(SELECT ISNULL(SUM(d.CAN+d.CAN1),0) FROM VFICHAD d
WHERE d.STA in ('V','M') AND d.tipo in ('F') AND d.fecha 
BETWEEN '$fecha_venta2' AND '$fecha_venta_al2' AND d.CPROD=P.CPROD
)VENTAS_CANTIDAD
FROM APRODUCTOS P 
WHERE P.CPROD IN ($linea) AND P.STA='A';";
$stmt=sqlsrv_query($dbh,$sql);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $codMaterial=$row["CPROD"];
      $ingresos_p=$row["INGRESO"];
      $ingresosu_p=$row["INGRESO_UNIDAD"];
      $salidas_p=$row["SALIDA"];
      $salidasu_p=$row["SALIDA_UNIDAD"];
      $ventas_p=$row["VENTAS_CANTIDAD"];      
    }
    sqlsrv_close($dbh);
  }
  return array($ingresos_p,$ingresosu_p,$salidas_p,$salidasu_p,$ventas_p); 
}


function cargarValoresVentasYSaldosProductoOficial2($almacen,$ipAlma,$fecha_venta2,$fecha_venta_al2,$fecha_saldo2,$ageAlma,$tipo,$linea){
  set_time_limit(0);
  $codigoUserScan=$_COOKIE['global_usuario'];
  $estilosVenta=1;
  require("conexionmysqli.inc"); 
  require_once __DIR__.'/conexion_externa_farma_solo.php'; 
  $dbh = ConexionFarma($ipAlma,"Gestion");
  $sqlInsertPedidos="";
  if($dbh!=false){
    //INGRESOS
    $sql="SELECT P.CPROD,(
SELECT ISNULL(SUM(D.DCAN-D.HCAN),0)
FROM VDETALLE D
WHERE D.TIPO in ('A','D','S') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)INGRESO,(
SELECT ISNULL(SUM(D.DCAN1-D.HCAN1),0)
FROM VDETALLE D
WHERE D.TIPO in ('A','D','S') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)INGRESO_UNIDAD,(
SELECT ISNULL(SUM(D.DCAN-D.HCAN),0)
FROM VDETALLE D
WHERE D.TIPO in ('K','F','O') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)SALIDA,(
SELECT ISNULL(SUM(D.DCAN1-D.HCAN1),0)
FROM VDETALLE D
WHERE D.TIPO in ('K','F','O') AND AGE1='$ageAlma' 
and D.FECHA<='$fecha_saldo2' AND D.CPROD=P.CPROD
)SALIDA_UNIDAD,
(SELECT ISNULL(SUM(d.CAN+d.CAN1),0) FROM VFICHAD d
WHERE d.STA in ('V','M') AND d.tipo in ('F') AND d.fecha 
BETWEEN '$fecha_venta2' AND '$fecha_venta_al2' AND d.CPROD=P.CPROD
)VENTAS_CANTIDAD
FROM APRODUCTOS P 
WHERE P.CPROD IN ($linea) AND P.STA='A';";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    /*while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codMaterial=$row["CPROD"];
      $ingreso=$row["INGRESO"];
      $ingreso_unitaria=$row["INGRESO_UNIDAD"];
      $salida=$row["SALIDA"];
      $salida_unitaria=$row["SALIDA_UNIDAD"];
      $ventas=$row["VENTAS_CANTIDAD"];
      $sqlInsertPedidos.="('$codigoUserScan','$almacen','$codMaterial','$ingreso','$ingreso_unitaria','$salida','$salida_unitaria','$ventas'),";  
    }*7

    /*$sqlInsertPedidos = substr_replace($sqlInsertPedidos, '', -1, 1);
    $sqlInsertPedidos="INSERT INTO temp_pedidos VALUES ".$sqlInsertPedidos.";";
    $sqlinserta=mysqli_query($enlaceCon,$sqlInsertPedidos);*/
    
  }
  $dbh=null;
}


function obtenerValoresSaldosProductoOficial3($almacen,$ipAlma,$fecha_venta2,$fecha_venta_al2,$fecha_saldo2,$ageAlma,$tipo,$linea){
    $datos=cargarValoresVentasYSaldosProductoOficial3($almacen,$ipAlma,$fecha_venta2,$fecha_venta_al2,$fecha_saldo2,$ageAlma,$tipo,$linea);
    $ingresos=$datos[0];
    $salidas=$datos[2];
    $ingresos_unitario=$datos[1];  
    $salidas_unitario=$datos[3];
    $saldoCajas=$ingresos+$salidas;
    $saldoUnidad=$ingresos_unitario+$salidas_unitario;
    if($tipo==1){//CAJAS
      $saldo=$saldoCajas+($saldoUnidad/$cantidadPres);
    }else{ //SALDO UNIDAD
      $saldo=$saldoUnidad+($saldoCajas*$cantidadPres); 
    } 
    //VENTAS
    $ventas=$datos[4];
    return array($saldo,$ventas);
}

function obtenerPrecioCompraProductoAntiguo($cod_prod,$ip){
  set_time_limit(0);
  $dbh = conexionSqlServer($ip,"Gestion");  
  $precio=0;
  if($dbh!=false){
    $sql="SELECT TOP 1 PRECOMP FROM ADETALLE D WHERE D.TIPO in ('A') AND D.CPROD='$cod_prod' ORDER BY FECHA DESC";
    $stmt=sqlsrv_query($dbh,$sql);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $precio=$row['PRECOMP'];    
    }
    sqlsrv_close($dbh);
  }
  return $precio;
}

function obtenerINCDECProveedorAnterior($ip,$cod_prov){
  $dbh = conexionSqlServer($ip,"Gestion");  
  $inc="";
  $dec="";
  if($dbh!=false){
    $sql="SELECT INC,DEC FROM PROVEEDORES WHERE IDPROVEEDOR='$cod_prov';";
    $stmt=sqlsrv_query($dbh,$sql);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $inc=$row['INC']; 
      $dec=$row['DEC'];         
    }
    sqlsrv_close($dbh);
  }
  return array($inc,$dec);
}



function obtenerMontoVentasGeneradasAnterior($dateInicio,$dateFin,$codigoSuc){
  set_time_limit(0);
  $ipAlma=obtenerIPAnterioirSucursal("10.10.1.11",obtenerAGE1AnterioirSucursal($codigoSuc));
  $codigoUserScan=$_COOKIE['global_usuario'];
  $dbh = conexionSqlServer($ipAlma,"Gestion"); 
  $ingresos=[];
  $ingresos_unidad=[];
  $salida=[];
  $salida_unidad=[];
  $ventas=[];
  $ventas_unidad=[];
  $devoluciones=[];
  $devoluciones_unidad=[];
  if($dbh!=false){
    $sqlVentas="SELECT SUM(MFACTURA) AS MONTO_V FROM VFICHAM d WHERE d.STA in ('V','M') AND d.tipo in ('F') AND d.fecha BETWEEN '$dateInicio' AND '$dateFin'";
    //echo $sqlVentas;
    $stmt=sqlsrv_query($dbh,$sqlVentas);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $montoVenta=$row['MONTO_V'];           
    }
  }
  return $montoVenta;
}

function obtenerAGE1AnterioirSucursal($almacen){
  $estilosVenta=1;
  require("conexionmysqli2.inc");
  $sql = "SELECT c.codigo_anterior FROM almacenes a join ciudades c on c.cod_ciudad=a.cod_ciudad where a.cod_almacen='$almacen';";
  $resp=mysqli_query($enlaceCon,$sql);
  $codigo='';
  while ($dat = mysqli_fetch_array($resp)) {
    $codigo=$dat['codigo_anterior'];
  }
  return($codigo);
}

