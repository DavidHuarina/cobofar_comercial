<?php
require("conexion.inc");
require("estilos.inc");

echo "<form action='savePrincipioAct.php' method='post'>";
echo "<h1>Registrar Principio Activo</h1>";

echo "<center><table class='texto'>";
echo "<tr><th>Nombre</th></tr>";

echo "<tr>
<td align='center'>
	<input type='text' class='texto' name='nombre' size='40' onKeyUp='javascript:this.value=this.value.toUpperCase();'>
</td>";
echo "<tr><th>Abreviatura</th></tr>";

echo "<tr>
<td align='center'>
	<input type='text' class='texto' name='abreviatura' size='40' onKeyUp='javascript:this.value=this.value.toUpperCase();'>
</td>";
echo "</table></center>";

echo "<div class='divBotones'><input type='submit' class='boton' value='Guardar'>
<input type='button' class='boton2' value='Cancelar' onClick='javascript:location.href=\"navegador_principiosact.php\"'>
</div>";

echo "</form>";
?>