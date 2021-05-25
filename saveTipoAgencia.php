<?php
$estilosVenta=1; //para no ejecutar las librerias js css
require("conexionmysqli.inc");
$tipo = $_POST["tipo_almacen"];
$global_agencia=$_COOKIE['global_agencia'];
$sql="SELECT cod_almacen FROM almacenes where cod_tipoalmacen='$tipo' and cod_ciudad='$global_agencia'";
$resp=mysqli_query($enlaceCon,$sql);
while($dat=mysqli_fetch_array($resp)){
   $codigo=$dat[0];
}
if($tipo>0){
	setcookie("global_tipo_almacen", $tipo,time()+3600*24*30, '/');
	setcookie("global_almacen",$codigo,time()+3600*24*30, '/');
}
?>
<script type="text/javascript">parent.window.location.href=window.parent.location;</script>
