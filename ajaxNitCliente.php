<?php
$estilosVenta=1;
require("conexionmysqli2.inc");
$rsCliente=$_GET['rsCliente'];

$sql="select f.nit from facturas_venta f 
	where f.razon_social='$rsCliente' order by f.fecha desc limit 0,1";
$resp=mysqli_query($enlaceCon,$sql);

$nombre="";
while($dat=mysqli_fetch_array($resp)){
	$nombre=$dat[0];
}
echo "<input type='number' value='$nombre' name='nitCliente' id='nitCliente' required onChange='ajaxRazonSocial(this.form);' class='form-control' required placeholder='Ingrese el NIT'>";

?>
