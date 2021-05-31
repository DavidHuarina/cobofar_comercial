<?php
$estilosVenta=1;
require('conexionmysqli2.inc');
$codigo=$_GET['codigo'];
$descripcion=$_GET['descripcion'];

$sql_item="select codigo_material, descripcion_material from material_apoyo where codigo_material<>0 ";

if($codigo>0){
   $sql_item.=" and codigo_material='$codigo' ";
}else{
	if($descripcion!=""){
	  $sql_item.=" and descripcion_material like '%$descripcion%' ";		
	}else{
 	  $sql_item.=" and codigo_material<-45465 ";			//para que no liste nada
	}   
}
$sql_item.=" order by descripcion_material";
//echo $sql_item;
	$resp=mysqli_query($enlaceCon,$sql_item);
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_item=$dat[0];
		$nombre_item=$dat[1];
		echo "<option value='$codigo_item' selected>$nombre_item</option>";
	}