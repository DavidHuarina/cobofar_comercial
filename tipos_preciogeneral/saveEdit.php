<?php
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");

$codigo=$_POST['codigo'];
$nombre=$_POST['nombre'];
$abreviatura=$_POST['abreviatura'];
$fecha_ini=$_POST["fecha_ini"];
$fecha_fin=$_POST["fecha_fin"];
$hora_ini=$_POST["hora_ini"];
$hora_fin=$_POST["hora_fin"];
$fecha_hora_ini=$fecha_ini." ".$hora_ini;
$fecha_hora_fin=$fecha_fin." ".$hora_fin;

$monto_ini=$_POST["monto_ini"];
$monto_fin=$_POST["monto_fin"];

$glosa_estado=$_POST["glosa_estado"];
$glosa_factura=$_POST["glosa_factura"];
$user=0;
if(isset($_COOKIE['global_usuario'])){
  $user=$_COOKIE['global_usuario'];
}
$sql_upd=mysqli_query($enlaceCon,"update $table set nombre='$nombre', abreviatura='$abreviatura', desde='$fecha_hora_ini', hasta='$fecha_hora_fin',glosa_estado='$glosa_estado',glosa_factura='$glosa_factura',cod_funcionario='$user',monto_inicio='$monto_ini',monto_final='$monto_fin' where codigo='$codigo'");

echo "<script language='Javascript'>
			alert('Los datos fueron modificados correctamente.');
			location.href='$urlList2';
			</script>";
?>