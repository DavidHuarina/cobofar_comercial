<?php
$estilosVenta=1; //para no ejecutar las librerias js css
require("conexionmysqli2.inc");
$cod_ciudad=$_POST['cod_ciudad'];
$sql="SELECT cod_almacen FROM almacenes where cod_tipoalmacen='1' and cod_ciudad='$cod_ciudad'";
$resp=mysqli_query($enlaceCon,$sql);

$codigo_funcionario=$_COOKIE["global_usuario"];
//$sqlFun="UPDATE funcionarios SET cod_ciudad='$cod_ciudad' where codigo_funcionario='$codigo_funcionario'";
//mysqli_query($enlaceCon,$sqlFun);
while($dat=mysqli_fetch_array($resp)){
   $codigo=$dat[0];
}
setcookie("global_tipo_almacen",1,time()+3600*24*30, '/');
setcookie("global_agencia",$cod_ciudad,time()+3600*24*30, '/');
setcookie("global_almacen",$codigo,time()+3600*24*30, '/');
if(isset($_POST["url"])){
	$url=$_POST["url"];
 ?>
<script type="text/javascript">window.location.href='<?=$url?>';</script>
<?php
}else{
?>
<script type="text/javascript">parent.window.location.href=window.parent.location;</script>
<?php	
}
