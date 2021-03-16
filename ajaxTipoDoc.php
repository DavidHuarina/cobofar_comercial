<?php
require("conexionmysqli.inc");
$codTipoSalida=$_GET['codTipoSalida'];

if($codTipoSalida==1001){
	$sql="select codigo, nombre, abreviatura from tipos_docs where codigo in (1,2) order by 2 desc";
}else{
	$sql="select codigo, nombre, abreviatura from tipos_docs where codigo in (3) order by 2 desc";
}
$resp=mysqli_query($enlaceCon,$sql);

echo "<select name='tipoDoc' id='tipoDoc' class='selectpicker form-control' data-style='btn btn-primary' onChange='ajaxNroDoc(form1)'>";
echo "<option value='0'>---</option>";
while($dat=mysqli_fetch_array($resp)){
	$codigo=$dat[0];
	$nombre=$dat[1];

	echo "<option value='$codigo'>$nombre</option>";
}
echo "</select>";

?>
