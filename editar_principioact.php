<?php

require("conexionmysqli.inc");
require("estilos.inc");

$codigo_registro=$_GET["codigo_registro"];

$sql=mysqli_query($enlaceCon,"select codigo, nombre,abreviatura from principios_activos where codigo=$codigo_registro");
$dat=mysqli_fetch_array($sql);
$nombre=$dat[1];
$abrev=$dat[2];
echo "<form action='saveEditPrincipiosActivos.php' method='post'>";

echo "<h1>Editar Principios Activos</h1>";

echo "<center><table class='texto'>";

echo "<tr><th>Nombre</th></tr>";
echo "<tr>
<td align='center'>
	<input type='hidden' name='codigo' value='$codigo_registro'>
	<input type='text' class='texto' name='nombre' value='$nombre' size='40' onKeyUp='javascript:this.value=this.value.toUpperCase();'>
</td>";

echo "<tr><th>Descripción</th></tr>";
echo "<tr>
<td align='center'>
	<input type='text' class='texto' name='abreviatura' value='$abrev' size='40' onKeyUp='javascript:this.value=this.value.toUpperCase();'>
</td>";


echo "</table></center>";

echo "<div class='divBotones'><input type='submit' class='boton' value='Guardar'>
<input type='button' class='boton2' value='Cancelar' onClick='javascript:location.href=\"navegador_principiosact.php\"'>
</div>";

echo "</form>";
?>