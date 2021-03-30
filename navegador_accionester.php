<?php

echo "<script language='Javascript'>
		function enviar_nav()
		{	location.href='registrar_accionter.php';
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
			{	alert('Debe seleccionar al menos un registro para proceder a su eliminación.');
			}
			else
			{
				if(confirm('Esta seguro de eliminar los datos.'))
				{
					location.href='deleteAccionesTer.php?datos='+datos+'';
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
			{	alert('Debe seleccionar solamente un registro para editar sus datos.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para editar sus datos.');
				}
				else
				{
					location.href='editar_accionter.php?codigo_registro='+j_cod_registro+'';
				}
			}
		}
		</script>";
	require("conexionmysqli.inc");
	require("estilos_almacenes.inc");

	echo "<form method='post' action=''><br>";
	$sql="select e.cod_accionterapeutica, e.nombre_accionterapeutica from acciones_terapeuticas e where e.estado=1 order by 2";
	$resp=mysqli_query($enlaceCon, $sql);
	echo "<h1>Acciones Terapeuticas</h1>";
    echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
	<input type='button' value='Editar' name='Editar' class='btn btn-primary' onclick='editar_nav(this.form)'>
	<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
	</div>";
	echo "<center><table class='texto'>";
	echo "<tr><th>&nbsp;</th><th>Nombre</th></tr>";
	while($dat=mysqli_fetch_array($resp))
	{
		$codigo=$dat[0];
		$nombre=$dat[1];
		echo "<tr>
		<td><input type='checkbox' name='codigo' value='$codigo'></td>
		<td>$nombre</td>
		</tr>";
	}
	echo "</table></center><br>";
	
	echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
	<input type='button' value='Editar' name='Editar' class='btn btn-primary' onclick='editar_nav(this.form)'>
	<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
	</div>";
	echo "</form>";
?>