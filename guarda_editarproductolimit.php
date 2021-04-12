<?php
require("conexion.inc");
require("estilos.inc");

//recogemos variables
$codProducto=$_POST['codProducto'];
$codForma=$_POST['codForma'];
$productoControlado=$_POST['producto_controlado'];
$codigoBarras=$_POST['codigo_barras'];

$arrayAccionTerapeutica=$_POST['arrayAccionTerapeutica'];
$arrayPrincipioActivo=$_POST['arrayPrincipioActivo'];


$sql_inserta="update material_apoyo set 
cod_forma_far='$codForma', producto_controlado='$productoControlado',codigo_barras='$codigoBarras' where codigo_material='$codProducto'";
//echo $sql_inserta;
$resp_inserta=mysqli_query($enlaceCon,$sql_inserta);

$sqlDel="delete from material_accionterapeutica where codigo_material='$codProducto'";
$respDel=mysqli_query($enlaceCon,$sqlDel);
$vectorAccionTer=explode(",",$arrayAccionTerapeutica);
$n=sizeof($vectorAccionTer);
for($i=0;$i<$n;$i++){
	$sql="insert into material_accionterapeutica (codigo_material, cod_accionterapeutica) values('$codProducto','$vectorAccionTer[$i]')";
	$resp=mysqli_query($enlaceCon,$sql);
}

$sqlDel="delete from principios_activosproductos where cod_material='$codProducto'";
$respDel=mysqli_query($enlaceCon,$sqlDel);
$vectorPrinAct=explode(",",$arrayPrincipioActivo);
$n=sizeof($vectorPrinAct);
for($i=0;$i<$n;$i++){
	$orden=$_POST["orden".$vectorPrinAct[$i]];
	$sql="insert into principios_activosproductos (cod_material, cod_principioactivo,orden) values('$codProducto','$vectorPrinAct[$i]',$orden)";
	$resp=mysqli_query($enlaceCon,$sql);
}

if($resp_inserta){
		echo "<script language='Javascript'>
			alert('Los datos fueron guardados correctamente.');
			location.href='navegador_material.php';
			</script>";
}else{
	echo "<script language='Javascript'>
			alert('ERROR EN LA TRANSACCION. COMUNIQUESE CON EL ADMIN.');
			history.back();
			</script>";
}	

?>