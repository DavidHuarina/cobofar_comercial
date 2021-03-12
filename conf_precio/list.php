<?php
	require_once("../conexionmysqli.inc");
	require_once("../estilos2.inc");
	require_once("configModule.php");
	require_once("../funciones.php");


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
$(document).ready(function() {
   $('#tablaPrincipal').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "ordering": false,
            "pageLength": 100

        });
});
</script>
	<?php
	echo "<form method='post' action=''>";
	$sql="select m.codigo_material, m.descripcion_material, m.estado, 
		(select e.nombre_empaque from empaques e where e.cod_empaque=m.cod_empaque), 
		(select f.nombre_forma_far from formas_farmaceuticas f where f.cod_forma_far=m.cod_forma_far), 
		(select pl.nombre_linea_proveedor from proveedores p, proveedores_lineas pl where p.cod_proveedor=pl.cod_proveedor and pl.cod_linea_proveedor=m.cod_linea_proveedor),
		(select t.nombre_tipoventa from tipos_venta t where t.cod_tipoventa=m.cod_tipoventa), m.cantidad_presentacion, m.principio_activo,l.cod_proveedor 
		from $table m join proveedores_lineas l on l.cod_linea_proveedor=m.cod_linea_proveedor
		where m.estado='1' and m.codigo_barras>0 order by m.descripcion_material";
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<h1>Lista de $moduleNamePlural</h1>";
	
	echo "<div class=''>

	</div>";
	
	
	echo "<center><table class='table table-sm table-bordered' id='tablaPrincipal'><thead>";
	echo "<tr class='bg-principal text-white'>
	<th>N.</th>
	<th>Proveedor</th>
	<th>Linea</th>
	<th>Producto</th>
	<th>Precio</th>
	<th>Detalle</th>
	</tr></thead><tbody>";
	$index=0;
	while($dat=mysqli_fetch_array($resp))
	{ 
		$index++;
		$codigo=$dat[0];
		$nombre=$dat[1];
		$abreviatura=$dat[2];
		$linea=$dat[5];
		$proveedor=obtenerNombreProveedor($dat['cod_proveedor']);		
		$precioProducto=number_format(obtenerPrecioProductoSucursal($codigo),2,'.',' ');
		$enlace="<a class='btn btn-default btn-sm' href='$urlListDetalle?codigo=$codigo' onclick=''>Mod. Sucursal</a>";
		echo "<tr>
		<td>$index</td>
		<td>$proveedor</td>
		<td>$linea</td>
		<td>$nombre</td>
		<td><small>$precioProducto</small></td>
		<td>$enlace</td>
		</tr>";
	}
	echo "</tbody></table></center><br>";
	
	echo "<div class=''>
	</div>";
	
	echo "</form>";
?>