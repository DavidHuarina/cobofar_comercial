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
	echo "<form method='post' action='' onsubmit='return false;'>";
	$sql="select codigo, nombre, abreviatura, estado,desde,hasta,por_linea from $table where estado=1 order by 2";
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<h1>Lista de $moduleNamePlural</h1>";
	
	echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
	<input type='button' value='Editar' name='Editar' class='btn btn-warning' onclick='editar_nav(this.form)'>
	<button title='Modificar Días' name='Dias' class='btn btn-default' onclick='editar_dias(this.form)'><i class='material-icons'>today</i>&nbsp;</button>
	<button title='Modificar Sucursales' name='Ciudades' class='btn btn-default' onclick='editar_ciudades(this.form)'><i class='material-icons'>business</i>&nbsp;</button>
	<button title='Modificar Lineas' name='Lineas' class='btn btn-default' onclick='editar_lineas(this.form)'><i class='material-icons'>people_alt</i>&nbsp;</button>
	<button title='Modificar Productos' name='Productos' class='btn btn-default' onclick='editar_productos(this.form)'><i class='material-icons'>watch</i>&nbsp;</button>
	<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
	</div>";
	
	
	echo "<center><table class='table table-sm table-bordered'>";
	echo "<tr class='bg-principal text-white'>
	<th colspan='3'></th>
	<th colspan='2' align='center'>Periodo del Descuento</th>
	<th colspan='4'></th>
	</tr>";
	echo "<tr class='bg-principal text-white'>
	<th>&nbsp;</th>
	<th>Nombre</th>
	<th>Descuento</th>
	<th>Desde</th>
	<th>Hasta</th>
	<th style='background:#999999 !important'><i class='material-icons' style='font-size:14px'>today</i> Días</th>
	<th style='background:#999999 !important'><i class='material-icons' style='font-size:14px'>business</i> Sucursales</th>
	<th style='background:#999999 !important'><i class='material-icons' style='font-size:14px'>people_alt</i> Líneas</th>
	<th width='15%' style='background:#999999 !important'><i class='material-icons' style='font-size:14px'>watch</i> Productos</th>
	</tr>";
	while($dat=mysqli_fetch_array($resp))
	{
		$codigo=$dat[0];
		$nombre=$dat[1];
		$abreviatura=$dat[2];
		
		if($dat[4]==""){
			$desde="";
		}else{
			$desde=strftime('%d/%m/%Y %H:%M',strtotime($dat[4]));
		}
		if($dat[5]==""){
			$hasta="";
		}else{
			$hasta=strftime('%d/%m/%Y %H:%M',strtotime($dat[5]));
		}
		
		$dias=obtenerNombreDesDiasRegistrados($codigo);
		$ciudades=obtenerNombreDesCiudadesRegistrados($codigo);
		$tamanioGlosa=50; 
        if(strlen($ciudades)>$tamanioGlosa){
           $ciudades=substr($ciudades, 0, $tamanioGlosa)."...";
        }
		if($dat['por_linea']==1){
			$lineas=obtenerNombreDesLineasRegistrados($codigo);
		    $tamanioGlosa=50; 
            if(strlen($lineas)>$tamanioGlosa){
               $lineas=substr($lineas, 0, $tamanioGlosa)."...";
            }
            $productos="";
		}else{
			$productos=obtenerNombreDesProdRegistrados($codigo);
		    $tamanioGlosa=50; 
            if(strlen($productos)>$tamanioGlosa){
               $productos=substr($productos, 0, $tamanioGlosa)."...";
            }
            $lineas="";
		}
		$por_linea=$dat['por_linea'];
		echo "<tr>
		<td><input type='checkbox' name='codigo' value='$codigo'><input type='hidden' id='por_linea$codigo' value='$por_linea'></td>
		<td>$nombre</td>
		<td>$abreviatura</td>
		<td>$desde</td>
		<td>$hasta</td>
		<td>$dias</td>
		<td>$ciudades</td>
		<td>$lineas</td>
		<td>$productos</td>
		</tr>";
	}
	echo "</table></center><br>";
	
	echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
	<input type='button' value='Editar' name='Editar' class='btn btn-warning' onclick='editar_nav(this.form)'>
	<button title='Modificar Días' name='Dias' class='btn btn-default' onclick='editar_dias(this.form)'><i class='material-icons'>today</i>&nbsp;</button>
	<button title='Modificar Sucursales' name='Ciudades' class='btn btn-default' onclick='editar_ciudades(this.form)'><i class='material-icons'>business</i>&nbsp;</button>
	<button title='Modificar Lineas' name='Lineas' class='btn btn-default' onclick='editar_lineas(this.form)'><i class='material-icons'>people_alt</i>&nbsp;</button>
	<button title='Modificar Productos' name='Productos' class='btn btn-default' onclick='editar_productos(this.form)'><i class='material-icons'>watch</i>&nbsp;</button>
	<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
	</div>";
	
	echo "</form>";
?>