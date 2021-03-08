<?php
//header('Content-Type: text/html; charset=UTF-8'); 
date_default_timezone_set('America/La_Paz');

if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
	if(!isset($estilosVenta)){
	    include("librerias.php");// se debe cambiar a la parte posterior
        include("librerias2.php");
        include("librerias3.php");
        ?><style type="text/css">body{background: #fff;} .filter-option{padding-top: 5px !important;padding-left: 5px !important;padding-right: 5px !important;}.dropdown-toggle::after{margin-right: -20px !important;}</style><?php	
	}
}else{

}
//$enlaceCon=mysqli_connect("10.10.1.76","davidh","Dhuarina2021","farmacias1");
$enlaceCon=mysqli_connect("127.0.0.1","root","","farmacias1");
if (mysqli_connect_errno())
{
	echo "Error en la conexión: " . mysqli_connect_error();
}
mysqli_set_charset($enlaceCon,"utf8");


if (!function_exists('mysqli_result')) {
    function mysqli_result($result, $number, $field=0) {
        mysqli_data_seek($result, $number);
        $row = mysqli_fetch_array($result);
        return $row[$field];
    }
}

?>
