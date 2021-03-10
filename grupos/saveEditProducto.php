<?php
require("../conexionmysqli.inc");
error_reporting(0);
require("../estilos2.inc");
require("configModule.php");

$codigo=$_POST['codigo'];
$cod_sub=$_POST['tipo'];
$padreGrupo=$_POST['padre_grupo'];
$sql_upd=mysqli_query($enlaceCon,"DELETE FROM subgrupos_material WHERE cod_subgrupo=$cod_sub");
for ($i=0; $i < count($codigo); $i++) { 
	if($codigo[$i]>0){
	   $producto=$codigo[$i];
       $sql_upd=mysqli_query($enlaceCon,"INSERT INTO subgrupos_material values($cod_sub,$producto)");
	}
}

echo "<script language='Javascript'>
			alert('Los datos fueron modificados correctamente.');
			location.href='$urlListDetalle2?codigo=$padreGrupo';
			</script>";
?>