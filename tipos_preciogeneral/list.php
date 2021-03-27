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
	$sql="select e.codigo, e.nombre, e.abreviatura, e.estado,e.desde,e.hasta,e.cod_estadodescuento,(SELECT nombre from estados_descuentos where codigo=e.cod_estadodescuento) as nombre_estado,e.observacion_descuento,e.glosa_factura,e.glosa_estado,e.monto_inicio,e.monto_final from $table e where e.estado=1 order by 2";
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<h1>Lista de $moduleNamePlural</h1>";
	
	echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
	<input type='button' value='Editar' name='Editar' class='btn btn-warning' onclick='editar_nav(this.form)'>
	<button title='Modificar Sucursales' name='Ciudades' class='btn btn-default' onclick='editar_ciudades(this.form)'><i class='material-icons'>business</i>&nbsp;</button>
	<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
	</div>";
	
	
	echo "<center><table class='table table-sm table-bordered'>";
	echo "<tr class='bg-principal text-white'>
	<th colspan='3'></th>
	<th colspan='2' align='center'>Periodo del Descuento</th>
	<th colspan='2' align='center'>$ Rango Precios $</th>
	<th colspan='5'></th>
	</tr>";
	echo "<tr class='bg-principal text-white'>
	<th>&nbsp;</th>
	<th>Nombre</th>
	<th>Descuento</th>
	<th>Del</th>
	<th>Al</th>
	<th>Desde</th>
	<th>Hasta</th>
	<th style='background:#999999 !important'><i class='material-icons' style='font-size:14px'>business</i> Sucursales</th>
	<th width='18%'>Glosa</th>
	<th>Estado</th>
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
		if($dat["glosa_estado"]==1){
			$glosa_estado="<b class='text-success'>(Activado)</b>";
		}else{
			$glosa_estado="<b class='text-danger'>(Desactivado)</b>";
		}
		$glosa=$glosa_estado." ".$dat["glosa_factura"];
		
		$ciudades=obtenerNombreDesCiudadesRegistradosGeneral($codigo);
		$tamanioGlosa=50; 
        if(strlen($ciudades)>$tamanioGlosa){
           $ciudades=substr($ciudades, 0, $tamanioGlosa)."...";
        }

		$inputcheck="<input type='checkbox' name='codigo' value='$codigo'>";
		if($dat["cod_estadodescuento"]==3||$dat["cod_estadodescuento"]==2){
          $inputcheck="";
		}
		$est_estado="";
		$estado_descripcion=$dat['nombre_estado'];
		$observacion_descuento=$dat['observacion_descuento'];
        switch ($dat['cod_estadodescuento']) {
        	case 1: $est_estado="style='background:#3498DB;color:#fff;'"; break;
        	case 2: $est_estado="style='background:#C0392B;color:#fff;'";$inputcheck=""; break;
        	case 3: $est_estado="style='background:#2AC012;color:#fff;'";$icon="cloud_done"; break;
        	case 4: $est_estado="style='background:#F7DC6F;color:#636563;'"; break;
        	default: $est_estado=""; break;
        } 
        $estado="<a href='#' class='btn btn-default btn-sm' $est_estado> <i class='material-icons'>$icon</i> ".$dat['nombre_estado']."</a><br><small class='text-muted font-weight-bold'>$observacion_descuento</small><input type='hidden' id='nombre$codigo' value='$nombre'>";
		$monto_inicio=number_format($dat["monto_inicio"],2,'.',',');
		$monto_final=number_format($dat["monto_final"],2,'.',',');
		echo "<tr>
		<td>$inputcheck</td>
		<td>$nombre</td>
		<td>$abreviatura</td>
		<td>$desde</td>
		<td>$hasta</td>
		<td>$monto_inicio</td>
		<td>$monto_final</td>
		<td>$ciudades</td>
		<td><small><small>$glosa</small></small></td>
		<td>$estado</td>
		</tr>";
	}
	echo "</table></center><br>";
	
	echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
	<input type='button' value='Editar' name='Editar' class='btn btn-warning' onclick='editar_nav(this.form)'>
	<button title='Modificar Sucursales' name='Ciudades' class='btn btn-default' onclick='editar_ciudades(this.form)'><i class='material-icons'>business</i>&nbsp;</button>
	<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
	</div>";
	
	echo "</form>";
?>