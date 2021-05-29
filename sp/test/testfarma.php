<?php

    $direccion="http://farmaciasbolivia.tk:8888/cobofar_comercial/wsfarmp/";
    $sIde = "cobofar2021";
    $sKey = "34r567y3k8dsu3izx98l1re3oiu";


    //PARAMETROS PARA LA OBTENCION DEL SERVICIO CIUDADES
    $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoLocalidades");
    $file="ws_obtener_listado_localidad.php";

    //PARAMETROS PARA LA OBTENCION DEL SERVICIO SUCURSALES
    //$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoSucursales");    
    //$file="ws_obtener_listado_sucursal.php";

    
    //PARAMETROS PARA LA OBTENCION DEL SERVICIO PRODUCTOS
    //$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ObtenerListadoProductos");
    //$file="ws_obtener_listado_productos.php";

    $parametros=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$direccion.$file); 
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