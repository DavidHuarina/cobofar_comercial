<?php
require("funciones.php");
function obtenerListadoProveedoresWeb(){
    
    $direccion=obtenerValorConfiguracion(8);//direccion del servicio web farmacias
    $sIde = "farma";
    $sKey = "89i6u32v7xda12jf96jgi30lh";
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoProveedores");

    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion."ws_obtener_listado_proveedores.php"); 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    return json_decode($remote_server_output);
  }

  function obtenerListadoLineasProveedoresWeb($codProveedor){
    
    $direccion=obtenerValorConfiguracion(8);//direccion del servicio web farmacias
    $sIde = "farma";
    $sKey = "89i6u32v7xda12jf96jgi30lh";
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoLineasProveedor","codProveedor"=>$codProveedor);

    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion."ws_obtener_listado_lineas_proveedor.php"); 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    return json_decode($remote_server_output);
  }

  function obtenerListadoProductosWeb($sta){
    
    $direccion=obtenerValorConfiguracion(8);//direccion del servicio web farmacias
    $sIde = "farma";
    $sKey = "89i6u32v7xda12jf96jgi30lh";
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoProductos","sta"=>$sta);

    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion."ws_obtener_listado_productos.php"); 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    return json_decode($remote_server_output);
  }

  function obtenerListadoProductosWebNombres($nombre){
    
    $direccion=obtenerValorConfiguracion(8);//direccion del servicio web farmacias
    $sIde = "farma";
    $sKey = "89i6u32v7xda12jf96jgi30lh";
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoProductos","des"=>$nombre,"sta"=>"A");

    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion."ws_obtener_listado_productos.php"); 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    return json_decode($remote_server_output);
  }

  function obtenerListadoAlmacenes(){
    $estilosVenta=1;
    $direccion=obtenerValorConfiguracion(8);//direccion del servicio web farmacias
    $sIde = "farma";
    $sKey = "89i6u32v7xda12jf96jgi30lh";
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoAlmacenes","tipo"=>obtenerValorConfiguracion(9));

    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion."ws_obtener_listado_almacenes.php"); 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    return json_decode($remote_server_output);
  }
   function obtenerListadoAlmacenesCocha(){
    $estilosVenta=1;
    $direccion=obtenerValorConfiguracion(8);//direccion del servicio web farmacias
    $sIde = "farma";
    $sKey = "89i6u32v7xda12jf96jgi30lh";
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoAlmacenes","tipo"=>obtenerValorConfiguracion(9),"cocha"=>1);

    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion."ws_obtener_listado_almacenes.php"); 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    return json_decode($remote_server_output);
  }
  function obtenerListadoAlmacenesEspecifico($age1){
    
    $direccion=obtenerValorConfiguracion(8);//direccion del servicio web farmacias
    $sIde = "farma";
    $sKey = "89i6u32v7xda12jf96jgi30lh";
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO
    //$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoAlmacenes","tipo"=>obtenerValorConfiguracion(9),"age1"=>$age1);
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoAlmacenes","age1"=>$age1);

    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion."ws_obtener_listado_almacenes.php"); 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    return json_decode($remote_server_output);
  }
  function obtenerListadoMarkets($ages1){
    
    $direccion=obtenerValorConfiguracion(8);//direccion del servicio web farmacias
    $sIde = "farma";
    $sKey = "89i6u32v7xda12jf96jgi30lh";
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO
    //$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoAlmacenes","tipo"=>obtenerValorConfiguracion(9),"age1"=>$age1);
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoAlmacenes","ages1"=>'Aë Aï Aö Aä');

    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion."ws_obtener_listado_almacenes.php"); 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    return json_decode($remote_server_output);
  }

  function obtenerListadoAlmacenesAlgunos($ages1){
    
    $direccion=obtenerValorConfiguracion(8);//direccion del servicio web farmacias
    $sIde = "farma";
    $sKey = "89i6u32v7xda12jf96jgi30lh";
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO
    //$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoAlmacenes","tipo"=>obtenerValorConfiguracion(9),"age1"=>$age1);
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoAlmacenes","ages1"=>$ages1);

    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion."ws_obtener_listado_almacenes.php"); 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    return json_decode($remote_server_output);
  }
  function obtenerListadoPersonal($sta){
    
    $direccion=obtenerValorConfiguracion(8);//direccion del servicio web farmacias
    $sIde = "farma";
    $sKey = "89i6u32v7xda12jf96jgi30lh";
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoPersonal","sta"=>$sta);

    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion."ws_obtener_listado_personal.php"); 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    return json_decode($remote_server_output);
  }

  function obtenerCodigoTraspasoDocumentos($tabla_detalle,$tipo,$dcto,$ip){
    require_once __DIR__.'/conexion_externa_farma.php';
    $dbh = new ConexionFarma();
    $dbh->setHost($ip);
    $sql="SELECT REPLACE((CAST((SELECT count(*) FROM $tabla_detalle WHERE DCTO=$dcto AND TIPO='$tipo') AS CHAR)+
        CAST((SELECT SUM(CPROD) FROM $tabla_detalle WHERE DCTO=$dcto AND TIPO='$tipo')AS CHAR)+CAST($dcto AS CHAR)),' ','') AS CODIGO";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $codigo="";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       $codigo=$row['CODIGO'];
    }
    $dbh=null;
    return $codigo;
  }
  function verificarExisteTraspasoDocumentos($tabla_detalle,$tabla,$dcto,$codigoUnico,$ip){
    //TIPO A (INGRESO DESDE EL ALMACEN)
    require_once __DIR__.'/conexion_externa_farma.php';
    $dbh = new ConexionFarma();
    $dbh->setHost($ip);
    $dbh->start($ip);
    $sqlDetalle="SELECT CASE
                      WHEN REPLACE((CAST((SELECT count(*) FROM $tabla_detalle vd join $tabla v on vd.DCTO=v.DCTO and vd.TIPO=v.TIPO WHERE v.DCTO=$dcto AND v.TIPO='A') AS CHAR)+CAST((SELECT SUM(CPROD) FROM $tabla_detalle vd join $tabla v on vd.DCTO=v.DCTO and vd.TIPO=v.TIPO WHERE v.DCTO=$dcto AND v.TIPO='A')AS CHAR)+CAST((SELECT DCTO FROM $tabla WHERE DCTO=$dcto AND TIPO='A')AS CHAR)),' ','') = '$codigoUnico'
                        THEN (SELECT DCTO FROM $tabla WHERE DCTO=$dcto AND TIPO='A')
                        ELSE 0
                      END as EXISTE";
    $stmt = $dbh->prepare($sqlDetalle);
    $stmt->execute();
    $existeCon=0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $existeCon=$row['EXISTE'];
    } 
    $dbh=null;
    return $existeCon;
  }
  
  function verificarExisteTraspasoDocumentosSucursal($tabla_detalle,$tabla,$dcto,$ip,$fecha_salida){
    //TIPO A (INGRESO DESDE EL ALMACEN)
    require_once __DIR__.'/conexion_externa_farma.php';
    $dbh=ConexionFarma($ip,"Gestion");
    $existeCon=0;
    if($dbh!=false){
       $sqlDetalle="SELECT DCTO as EXISTE FROM $tabla WHERE DCTO1=$dcto AND TIPO='D' AND FECHA>='$fecha_salida'";
       $stmt = $dbh->prepare($sqlDetalle);
       $stmt->execute();
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
         $existeCon=$row['EXISTE'];
       } 
    }
    $dbh=null;
    return $existeCon;
  }
  function verificarExisteTraspasoDocumentosSucursalA($tabla_detalle,$tabla,$dcto,$ip,$fecha_salida){
    //TIPO A (INGRESO DESDE EL ALMACEN)
    require_once __DIR__.'/conexion_externa_farma.php';
    $dbh = new ConexionFarma();
    $dbh->setHost($ip);
    $dbh->start();
    $sqlDetalle="SELECT DCTO as EXISTE FROM $tabla WHERE DCTO1=$dcto AND TIPO='A' AND FECHA>='$fecha_salida'";
    $stmt = $dbh->prepare($sqlDetalle);
    $stmt->execute();
    $existeCon=0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $existeCon=$row['EXISTE'];
    } 
    $dbh=null;
    return $existeCon;
  }
  function obtenerNombreProductoObservacion($codprod){
    //TIPO A (INGRESO DESDE EL ALMACEN)
    require_once __DIR__.'/conexion_externa_farma.php';
    $dbh = new ConexionFarma();
    $sqlDetalle="SELECT p.DES FROM aproductos p where CPROD=$codprod";
    $stmt = $dbh->prepare($sqlDetalle);
    $stmt->execute();
    $desprod="";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $desprod=$row['DES'];
    } 
    $dbh=null;
    return $desprod;
  }
  function verificarIpDestinoAlmacen($age1){
    $estilosVenta=1;
    require_once __DIR__.'/conexion_externa_farma.php';

    $dbh = new ConexionFarma();
    $sqlDetalle="SELECT IP,DES FROM ALMACEN WHERE AGE1='$age1'";
    $stmt = $dbh->prepare($sqlDetalle);
    $stmt->execute();
    $ip=0;$sucursal="";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $ip=$row['IP'];
      $sucursal=$row['DES'];
    } 
    $dbh=null;
    return array($ip,$sucursal);
  }
  function obtenerNombrePersonalAbreviado($idper,$ip){
    require_once __DIR__.'/conexion_externa_farma.php';
    $dbh = new ConexionFarma();
    $dbh->setHost($ip);
    $dbh->setBase('General');
    $dbh->start();
    $sqlDetalle="SELECT DES FROM USUARIO WHERE PASO='$idper'";
    $stmt = $dbh->prepare($sqlDetalle);
    $stmt->execute();
    $nombre="";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombre=$row['DES'];
    } 
    $dbh=null;
    return $nombre;
  }

  function obtenerDetalleTraspasoDocumentos($tabla_detalle,$tabla,$dcto,$codigoUnico,$ip){
    require_once __DIR__.'/conexion_externa_farma.php';
    $dbh = new ConexionFarma();
    $dbh->setHost($ip);
    $dbh->start($ip);
    $sqlDetalle="SELECT CASE
                      WHEN REPLACE((CAST((SELECT count(*) FROM $tabla_detalle vd join $tabla v on vd.DCTO=v.DCTO and vd.TIPO=v.TIPO WHERE v.DCTO1=$dcto AND v.TIPO!='K') AS CHAR)+
                          CAST((SELECT SUM(APU) FROM $tabla_detalle vd join $tabla v on vd.DCTO=v.DCTO and vd.TIPO=v.TIPO WHERE v.DCTO1=$dcto AND v.TIPO!='K') AS CHAR)+
                          CAST((SELECT SUM(CPROD) FROM $tabla_detalle vd join $tabla v on vd.DCTO=v.DCTO and vd.TIPO=v.TIPO WHERE v.DCTO1=$dcto AND v.TIPO!='K')AS CHAR)+CAST((SELECT DCTO FROM $tabla WHERE DCTO1=$dcto AND TIPO!='K')AS CHAR)),' ','') = '$codigoUnico'
                        THEN 1
                        ELSE 0
                      END as EXISTE";
    $stmt = $dbh->prepare($sqlDetalle);
    $stmt->execute();
    $existeCon=0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $existeCon=$row['EXISTE'];
    } 
    $dbh=null;
    return $existeCon;
  }


function obtenerListadoEnvases(){
    $estilosVenta=1;
    $direccion=obtenerValorConfiguracion(8);//direccion del servicio web farmacias
    $sIde = "farma";
    $sKey = "89i6u32v7xda12jf96jgi30lh";
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoEmpaques");
    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion."ws_obtener_listado_empaques.php"); 
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    return json_decode($remote_server_output);
  }

 function obtenerPrecioVentaMaxProcesoAnteriorSistema($codigoProd){
   set_time_limit(0);
   error_reporting(0);
   require_once __DIR__.'/conexion_externa_farma.php';
   $listAlma=obtenerListadoAlmacenesEspecifico("A{");//web service
   $precio=0;$index=0;$pv=[];
   foreach ($listAlma->lista as $alma) {
      $pv[$index]=0;
      $age1=$alma->age1;
      $ip=$alma->ip;    
      //CONEXION TEST
      $dbh = ConexionFarma($ip,"Gestion");
      if($dbh!=false){
         $sql="SELECT TOP 1 P.CPROD,P.DES,S.TIPO,S.FECHAVEN VENCIMIENTO,S.LOTE,S.REGISTRO,S.PRECIOVENT,S.PRECIOCOMP,S.PRECIOCOSTO, S.PRECIOUNIT PRECIO,O.DES PROVEEDOR, P.DIV, P.SICO, P.CANENVASE, O.DESCTO,S.INGRESO- S.SALIDA AS SALDO 
      FROM VSALDOS S
      JOIN APRODUCTOS P ON P.CPROD=S.CPROD AND  P.CPROD='$codigoProd'
      JOIN PROVEEDORES O ON P.IDPROVEEDOR=O.IDPROVEEDOR
      WHERE AGE1='$age1' AND S.INGRESO<>S.SALIDA
      ORDER BY P.CPROD,S.FECHAVEN;";
         $stmt = $dbh->prepare($sql);
         $stmt->execute();
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pre=(float)$row['PRECIO'];
            $sico=$row['SICO'];
            $desc=(float)$row['DESCTO'];
            $pre=$pre-number_format($pre*($desc/100),2,'.',''); //PROCESO ANTERIOR
            if($sico=="N"){
                $pre=$pre-number_format($pre*(7/100),2,'.','');
            }            
            $pv[$index]=$pre;
         }    
      }
      $index++;
  } 
  if(count($pv)>0){
    $precio=max($pv);
  } 
  $dbh = null;
  return $precio;
}


function obtenerValoresVentasProducto($cod_prod,$ip,$fechaInicio,$fechaFinal){
  set_time_limit(0);
  require_once __DIR__.'/conexion_externa_farma.php';
  $dbh = ConexionFarma($ip,"Gestion");
  $cant=0;
  $monto=0;
  $saldo=0;
  if($dbh!=false){
    $sql="SELECT d.CPROD,P.DES,SUM(CAN+CAN1) AS CANTIDAD,SUM((CAN+CAN1)*((PREUNIT-((PREUNIT*DESCTO1)/100))-(((PREUNIT-((PREUNIT*DESCTO1)/100))*DESCTO2)/100))-((((PREUNIT-((PREUNIT*DESCTO1)/100))-(((PREUNIT-((PREUNIT*DESCTO1)/100))*DESCTO2)/100))*DESCTO3)/100)) AS MONTO_V
FROM VFICHAD d LEFT JOIN APRODUCTOS P ON P.CPROD=d.CPROD
JOIN PROVEESLINEA L ON L.IDSLINEA=P.IDSLINEA
WHERE d.STA in ('V','M') AND L.IDPROVEEDOR='$cod_prov' 
AND d.tipo in ('F') AND d.fecha BETWEEN '$fechaInicio 00:00:00' AND '$fechaFinal 23:59:59'
GROUP BY d.CPROD,P.DES;";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       $cant=(int)$row['CANTIDAD']; 
       $monto=(float)$row['MONTO_V'];           
    }
  }
  $dbh=null;
  return array($cant,$monto,$saldo);
}

function obtenerValoresSaldosProducto($cod_prod,$ip,$fechaFinal){
  set_time_limit(0);
  require_once __DIR__.'/conexion_externa_farma.php';
  $dbh = ConexionFarma($ip,"Gestion");
  $saldoCajas=0;
  $saldoUnidad=0;
  $fechaVen="";
  $lote="";
  if($dbh!=false){
    $sql="SELECT SUM(D.DCAN-D.HCAN) as CANT_CAJAS,SUM(D.DCAN1-D.HCAN1) as CANT_UNIDAD FROM VDETALLE D, APRODUCTOS P INNER JOIN PROVEEDORES E ON (P.IDPROVEEDOR = E.IDPROVEEDOR) LEFT JOIN PROVEESLINEA S ON (P.IDSLINEA = S.IDSLINEA) WHERE  D.CPROD = P.CPROD AND D.FECHA <= '$fechaFinal' AND D.CPROD = '$cod_prod'";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $saldoCajas=$row['CANT_CAJAS']; 
      $saldoUnidad=$row['CANT_UNIDAD'];          
    }

    $sql="SELECT TOP 1 FECHAVEN,LOTE FROM VSALDOS WHERE CPROD='$cod_prod' ORDER BY FECHAVEN DESC;";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $fechaVen=$row['FECHAVEN'];   
      $lote=$row['LOTE'];        
    }

  }
  $dbh=null;
  return array($saldoCajas,$saldoUnidad,$fechaVen,$lote);
}

