<?php
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");

$user=0;
if(isset($_COOKIE['global_usuario'])){
  $user=$_COOKIE['global_usuario'];
}
$global_agencia=0;
if(isset($_COOKIE['global_agencia'])){
  $global_agencia=$_COOKIE['global_agencia'];
}

$sqlProd="SELECT cod_producto FROM $table where cod_personal='$user' and cod_ciudad='$global_agencia' and cod_producto='$rpt_item' and cod_estadoreferencial=1 and cod_tipoatributo=1 ";
$respProd=mysqli_query($enlaceCon,$sqlProd);
$codProd=mysqli_result($respProd,0,0);

if($codProd>0){

}else{
  $sql="SELECT IFNULL(max(codigo)+1,1) FROM $table";
  $resp=mysqli_query($enlaceCon,$sql);
  $codigo=mysqli_result($resp,0,0);
  $sql="insert into $table (codigo,cod_producto, cod_personal,descripcion,cod_ciudad, cod_tipoatributo,cod_estadoreferencial) values($codigo,'$rpt_item','$user','$nombre','$global_agencia','1','1')";
  $sql_inserta=mysqli_query($enlaceCon,$sql);
}




echo "<script language='Javascript'>
			alert('Los datos fueron insertados correctamente.');
			location.href='$urlList2';
			</script>";

?>