<?php
require("conexionmysqli.inc");
$codVehiculo=$_GET['codVehiculo'];
if($codVehiculo!=0){
	$sql="select peso_maximo from vehiculos where codigo in ('$codVehiculo')";
	$resp=mysqli_query($enlaceCon,$sql);
	$pesoMaximo=mysqli_result($resp,0,0);

	echo "<input type='hidden' name='pesoMaximoVehiculo' id='pesoMaximoVehiculo' value='$pesoMaximo'>";
	echo "Peso Maximo: $pesoMaximo";
}else{
	echo "<input type='hidden' name='pesoMaximoVehiculo' id='pesoMaximoVehiculo' value='0'>";
	echo "Peso Maximo: 0";
}


?>
