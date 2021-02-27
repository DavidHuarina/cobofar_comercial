<?php
require("conexionmysqli.inc");
$nitCliente=$_GET['nitCliente'];

$sql="select f.cod_cliente from clientes f 
	where f.nit_cliente='$nitCliente' order by f.nombre_cliente desc limit 0,1";
$resp=mysqli_query($enlaceCon,$sql);

$cod_cliente=146;// varios
while($dat=mysqli_fetch_array($resp)){
	$cod_cliente=$dat[0];
}
echo "0####".$cod_cliente;