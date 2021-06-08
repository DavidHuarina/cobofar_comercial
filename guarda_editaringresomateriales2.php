<?php

require("conexionmysqli.inc");
require("estilos_almacenes.inc");
require("funcionRecalculoCostos.php");
require("funciones.php");


$codIngreso=$_POST["codIngreso"];
//$tipo_ingreso=$_POST['tipo_ingreso'];
$observaciones=$_POST['observaciones'];
$fecha_real=date("Y-m-d");

$consulta="update ingreso_almacenes set cod_tipoingreso='$tipo_ingreso', 
		observaciones='$observaciones' where cod_ingreso_almacen='$codIngreso'";
$sql_inserta = mysqli_query($enlaceCon,$consulta);


echo "<script language='Javascript'>
    alert('Los datos fueron modificados correctamente.');
    location.href='navegador_ingresomateriales.php';
    </script>";

?>