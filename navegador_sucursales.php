<?php

echo "<script language='Javascript'>
		function enviar_nav()
		{	location.href='registrar_almacenes.php';
		}
		function eliminar_nav(f)
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
			{	alert('Debe seleccionar al menos un Almacen para proceder a su eliminación.');
			}
			else
			{
				if(confirm('Esta seguro de eliminar los datos.'))
				{
					location.href='eliminar_almacenes.php?datos='+datos+'';
				}
				else
				{
					return(false);
				}
			}
		}

		function editar_nav(f)
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
			{	alert('Debe seleccionar solamente un Almacen para editar sus datos.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un Almacen para editar sus datos.');
				}
				else
				{
					location.href='editar_almacenes.php?codigo_registro='+j_cod_registro+'';
				}
			}
		}
		</script>";
	require("conexionmysqli.inc");
	require("estilos_almacenes.inc");
?>
        <link rel="stylesheet" type="text/css" href="dist/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="dist/bootstrap/dataTables.bootstrap4.min.css"/>
        <script type="text/javascript" src="dist/bootstrap/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="dist/bootstrap/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="dist/bootstrap/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="lib/js/xlibPrototipo-v0.1.js"></script>
        <link rel="stylesheet" href="dist/selectpicker/dist/css/bootstrap-select.css">
        <link rel="stylesheet" type="text/css" href="dist/css/micss.css"/>
	<?php
	echo "<form method='post' action=''>";
	$sql="select c.cod_ciudad, c.descripcion, c.direccion
	from ciudades c
	order by c.descripcion";
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<h3 class='text-muted'><center>Registro de Sucursales</center></h3>";

	echo "<center><table class='table table-bordered' id='tablaPrincipal'><thead>";
	echo "<tr  class='bg-principal'><th>&nbsp;</th><th>Sucursal</th><th>Direccion</th></tr></thead><tbody>";
	while($dat=mysqli_fetch_array($resp))
	{
		$codigo=$dat[0];
		$nombre_ciudad=$dat[1];
		$direccion_ciudad=$dat[2];
		echo "<tr><td><input type='checkbox' name='codigo' value='$codigo'></td><td>$nombre_ciudad</td><td>$direccion_ciudad</td></tr>";
	}
	echo "</tbody></table></center><br>";
	
	/*echo "<div class='divBotones'>
	<input type='button' value='Adicionar' name='adicionar' class='boton' onclick='enviar_nav()'>
	<input type='button' value='Editar' name='Editar' class='boton' onclick='editar_nav(this.form)'>
	<input type='button' value='Eliminar' name='eliminar' class='boton2' onclick='eliminar_nav(this.form)'>
	</div>";*/
	echo "</form>";
?>
<script src="dist/selectpicker/dist/js/bootstrap-select.js"></script>
 <script type="text/javascript" src="dist/js/functionsGeneral.js"></script>