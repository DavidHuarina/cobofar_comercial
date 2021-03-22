<?php
set_time_limit(0);
error_reporting(0);
//header('Content-Type: text/html; charset=UTF-8'); 
date_default_timezone_set('America/La_Paz');

if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
	if(!isset($estilosVenta)){
	    include("librerias.php");// se debe cambiar a la parte posterior
        include("librerias2.php");
        include("librerias3.php");
        if(!isset($indexGerencia)){
            ?>
          <div class="cargar">
            <p style='padding-top: 35px; font-size: 14px;text-align: center;' class="text-warning font-weight-bold">Procesando Datos</p>
         </div>
            <?php
        }
        ?>
        
         <div class="cargar-ajax d-none">
           <div class="div-loading text-center">
              <h4 class="text-warning font-weight-bold" id="texto_ajax_titulo">Procesando Datos</h4>
              <p class="text-muted">Aguard&aacute; un momento por favor</p>  
           </div>
         </div>
        <?php	
	}
}else{

}

//$enlaceCon=mysqli_connect("10.10.1.76","davidh","123456","farmacias2");
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
