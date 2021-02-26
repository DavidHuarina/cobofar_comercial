<script language='Javascript'>
		function enviar_nav(codProveedor)
		{	location.href='registrarLineaDistribuidor.php?codProveedor='+codProveedor;
		}
		
		function editar_nav(f, codProveedor)
		{
			var i;
			var j=0;
			var j_cod_registro;
			for(i=0;i<=f.length-1;i++)
			{
				if(f.elements[i].type=='checkbox')
				{	if(f.elements[i].checked==true)
					{	j_cod_registro=f.elements[i].value;
						j=j+1;
					}
				}
			}
			if(j>1)
			{	alert('Debe seleccionar solamente un registro.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro.');
				}
				else
				{
					location.href='editarLineaDistribuidor.php?codigo_registro='+j_cod_registro+'&codProveedor='+codProveedor;
				}
			}
		}
		
		function eliminar_nav(f, codProveedor)
		{
			var i;
			var j=0;
			datos=new Array();
			for(i=0;i<=f.length-1;i++)
			{
				if(f.elements[i].type=='checkbox')
				{	if(f.elements[i].checked==true)
					{	datos[j]=f.elements[i].value;
						j=j+1;
					}
				}
			}
			if(j==0)
			{	alert('Debe seleccionar al menos una Linea para eliminar.');
			}
			else
			{
				if(confirm('Esta seguro de eliminar los datos.'))
				{
					location.href='eliminarLineaDistribuidor.php?codProveedor='+codProveedor+'&datos='+datos+'';
				}
				else
				{
					return(false);
				}
			}
		}
		</script>
<form>
<?php

require("../../conexionmysqli.inc");
require("../../estilos_almacenes.inc");
require("../../funcion_nombres.php");
require("../../function_web.php");

echo "<link rel='stylesheet' type='text/css' href='../../stilos.css'/>";
?>
        <link rel="stylesheet" type="text/css" href="../../dist/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../../dist/bootstrap/dataTables.bootstrap4.min.css"/>
        <script type="text/javascript" src="../../dist/bootstrap/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="../../dist/bootstrap/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../../dist/bootstrap/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="../../lib/js/xlibPrototipo-v0.1.js"></script>
        <link rel="stylesheet" type="text/css" href="../../dist/css/micss.css"/>
<?php
$codProveedor=$_GET['codProveedor'];
$nombreProveedor=nombreProveedorExt($codProveedor);

echo "<center>";
echo "<h3 class='text-muted'>Lineas de Distribuidor <br> $nombreProveedor</h3>";
echo "<table class='table table-bordered' id='tablaPrincipal'><thead>";
echo "<tr class='bg-principal'>";
echo "<th>&nbsp;</th><th>Linea</th><th>Abreviatura</th><th>Procedencia</th><th>Margen de precio</th><th>Contacto 1</th><th>Contacto 2</th>";
echo "</tr></thead><tbody>";


$cont=0;
$listLineas=obtenerListadoLineasProveedoresWeb($codProveedor);
foreach ($listLineas->lista as $lineas) {
  $cont++;
    $codLinea = $lineas->idslinea;
    $nombreLinea = $lineas->des;
    $contacto1 = "";
    $contacto2 = "";
    $abreviatura = "";
	$procedencia="";
	$margenPrecio=0;
    echo "<tr>";
    echo "<td><input type='checkbox' id='$codLinea' value='$codLinea' ></td><td>$nombreLinea</td><td>$abreviatura</td>
	<td>$procedencia</td><td>$margenPrecio</td>
	<td>$contacto1</td><td>$contacto2</td>";
    echo "</tr>";
}

echo "</tbody></table>";
echo "</center>";

echo "<div class='divBotones'><input class='btn btn-warning text-white' type='button' value='Adicionar' onClick='enviar_nav($codProveedor);'>
<input class='btn btn-warning text-white' type='button' value='Editar' onClick='editar_nav(this.form, $codProveedor);'>
<input class='btn btn-danger' type='button' value='Eliminar' onClick='eliminar_nav(this.form, $codProveedor)'>
<input class='btn btn-danger' type='button' value='Cancelar' onClick='location.href=(\"inicioProveedores.php\");'>
</div>";


?>
 <script type="text/javascript" src="../../dist/js/functionsGeneral.js"></script>
</form>