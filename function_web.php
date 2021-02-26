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
