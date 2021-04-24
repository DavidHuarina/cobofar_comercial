<?php
require("../funciones.php");
    //$direccion="http://127.0.0.1:8888/cobofar_comercial/wsfarm/";
$direccion=obtenerValorConfiguracion(8);
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
    //return json_decode($remote_server_output);
    header('Content-type: application/json');   
    print_r($remote_server_output);