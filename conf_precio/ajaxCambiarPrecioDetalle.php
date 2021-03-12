<?php
require("../conexionmysqli.inc");
require("configModule.php");

$codigo=$_GET['codigo'];
$precio=$_GET['precio'];
$sucursal=$_GET['sucursal'];
//agregar el log de precios


$sql="SELECT precio from $table_precios where codigo_material=$codigo and cod_ciudad=$sucursal and cod_precio=1";
$resp=mysqli_query($enlaceCon,$sql);
$cantidad=0;				
while($detalle=mysqli_fetch_array($resp)){	
     $cantidad++;   		
}
if($cantidad>0){
	$sql="update $table_precios set precio='$precio' WHERE codigo_material='$codigo' and cod_ciudad='$sucursal' and cod_precio=1";
	$sql_upd=mysqli_query($enlaceCon,$sql);
}else{
	$sql="INSERT INTO $table_precios VALUES ('$codigo',1,'$precio','$sucursal')";
	$sql_upd=mysqli_query($enlaceCon,$sql);
}  
echo $sql;
if($sql_upd==1){
	echo "#####1";
}else{
	echo "#####0";
}
?>