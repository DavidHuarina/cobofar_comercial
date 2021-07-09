<?php
	require_once("../conexionmysqli.inc");
	require_once("../estilos2.inc");
	require_once("configModule.php");
	require_once("../funciones.php");
	require_once("../funcion_nombres.php");


echo "<script language='Javascript'>
		function enviar_nav()
		{	location.href='$urlRegister';
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
			{	alert('Debe seleccionar al menos un registro para eliminar.');
			}
			else
			{
				if(confirm('Esta seguro de eliminar los datos.'))
				{
					location.href='$urlDelete?datos='+datos+'';
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
			{	alert('Debe seleccionar solamente un registro para editar.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para editar.');
				}
				else
				{
					location.href='$urlEdit?codigo_registro='+j_cod_registro+'';
				}
			}
		}
		</script>";
	?>
<script type="text/javascript">
	function editar_dias(f)
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
			{	alert('Debe seleccionar solamente un registro para editar los días.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para editar los días.');
				}
				else
				{
					location.href='<?=$urlEditDia?>?codigo_registro='+j_cod_registro+'';
				}
			}
		}
		function editar_ciudades(f)
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
			{	alert('Debe seleccionar solamente un registro para editar las sucursales.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para editar las sucursales.');
				}
				else
				{
					location.href='<?=$urlEditCiudad?>?codigo_registro='+j_cod_registro+'';
				}
			}
		}
		function editar_lineas(f)
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
			{	alert('Debe seleccionar solamente un registro para editar las líneas.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para editar las líneas.');
				}
				else
				{
					if(parseInt($("#por_linea"+j_cod_registro).val())==1){
                      location.href='<?=$urlEditLinea?>?codigo_registro='+j_cod_registro+'';
					}else{
					  alert('El descuento seleccionado es de nivel Productos.');
					}
				}
			}
		}
		function editar_productos(f)
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
			{	alert('Debe seleccionar solamente un registro para editar los productos.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para editar los productos.');
				}
				else
				{
					if(parseInt($("#por_linea"+j_cod_registro).val())==1){  
                      alert('El descuento seleccionado es de nivel Líneas.');
					}else{
					  location.href='<?=$urlEditProducto?>?codigo_registro='+j_cod_registro+'';
					} 
					
				}
			}
		}
</script>
	<?php
	$global_agencia=$_COOKIE['global_agencia'];
	echo "<form method='post' action='' onsubmit='return false;'>";
	$sql="SELECT e.codigo,e.cod_producto,p.descripcion_material,e.descripcion,s.descripcion as nombre_ciudad,e.cod_personal,(SELECT nombre_proveedor from proveedores where cod_proveedor=(SELECT cod_proveedor from proveedores_lineas where cod_linea_proveedor=p.cod_linea_proveedor))proveedor
	FROM productos_estrella_clavo e join material_apoyo p on p.codigo_material=e.cod_producto
	JOIN ciudades s on s.cod_ciudad=e.cod_ciudad
	where e.cod_estadoreferencial=1 and e.cod_tipoatributo=1 and e.cod_ciudad='$global_agencia';";
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<h1>Lista de $moduleNamePlural</h1>";
	
	echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
	<input type='button' value='Quitar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
	</div>";
	
	
	echo "<center><table class='table table-sm table-bordered'>";
	echo "<tr class='bg-principal text-white'>
	<th>&nbsp;</th>
	<th>Producto</th>
	<th>Proveedor</th>
	<th style='background:#999999 !important'>Observacion</th>
	<th style='background:#999999 !important'><i class='material-icons' style='font-size:14px'>business</i> Sucursal</th>
	<th style='background:#999999 !important'><i class='material-icons' style='font-size:14px'>people_alt</i> Personal</th>
	<th>Estado</th>
	</tr>";
	while($dat=mysqli_fetch_array($resp))
	{
		$codigo=$dat[0];
		$cod_producto=$dat[1];
		$nombre=$dat['descripcion_material'];
		$proveedor=$dat['proveedor'];
		$descripcion=$dat['descripcion'];
		$ciudad=$dat['nombre_ciudad'];
	    $nombreFun=nombreVisitador($dat['cod_personal']);
		$inputcheck="<input type='checkbox' name='codigo' value='$codigo'>";
		echo "<tr>
		<td>$inputcheck</td>
		<td>($cod_producto)$nombre</td>
		<td>$proveedor</td>
		<td>$descripcion</td>
		<td>$ciudad</td>
		<td>$nombreFun</td>
		<td><i class='material-icons'>star</i></td>
		</tr>";
	}
	echo "</table></center><br>";
	
	echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
	<input type='button' value='Anular' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
	</div>";
	
	echo "</form>";
?>