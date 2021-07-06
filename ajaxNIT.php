<?php
$estilosVenta=1;
require("conexionmysqli2.inc");
$codCliente=$_GET['codCliente'];

$sql="select c.`nit_cliente` from `clientes` c where c.`cod_cliente`='$codCliente'";
$resp=mysqli_query($enlaceCon,$sql);

$nombre="";
while($dat=mysqli_fetch_array($resp)){
	$nombre=$dat[0];
}

echo "<input type='text' value='$nombre' name='nitCliente' id='nitCliente'>";

?>
