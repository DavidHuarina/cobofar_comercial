<?php
$estilosVenta=1;
require("conexionmysqli2.inc");
$nitCliente=$_GET['nitCliente'];

$sql="select f.razon_social from facturas_venta f 
	where f.nit='$nitCliente' order by f.fecha desc limit 0,1";
$resp=mysqli_query($enlaceCon,$sql);

$nombre="";
while($dat=mysqli_fetch_array($resp)){
	$nombre=$dat[0];
}
echo "<input type='text' value='$nombre' class='form-control' name='razonSocial' id='razonSocial'>";

?>
