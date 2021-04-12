<?php
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");

$fecha_ini=$fecha_ini;
$fecha_fin=$fecha_fin;
$hora_ini=$hora_ini;
$hora_fin=$hora_fin;
$fecha_hora_ini=$fecha_ini." ".$hora_ini;
$fecha_hora_fin=$fecha_fin." ".$hora_fin;

$monto_ini=$monto_ini;
$monto_fin=$monto_fin;

$sql="SELECT IFNULL(max(codigo)+1,1) FROM $table";
$resp=mysqli_query($enlaceCon,$sql);
$codigo=mysqli_result($resp,0,0);

$user=0;
if(isset($_COOKIE['global_usuario'])){
  $user=$_COOKIE['global_usuario'];
}

$sql="insert into $table (codigo,nombre, abreviatura,desde,hasta, estado,glosa_factura,glosa_estado,cod_funcionario,monto_inicio,monto_final) values($codigo,'$nombre','$abreviatura','$fecha_hora_ini','$fecha_hora_fin','1','$glosa_factura','$glosa_estado','$user','$monto_ini','$monto_fin')";
//echo $sql;
$sql_inserta=mysqli_query($enlaceCon,$sql);

echo "<script language='Javascript'>
			alert('Los datos fueron insertados correctamente.');
			location.href='$urlList2';
			</script>";

?>