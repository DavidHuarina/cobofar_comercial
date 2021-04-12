<?php

echo "<script language='Javascript'>
		function enviar_nav()
		{	location.href='registrar_material_apoyo.php';
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
			{	alert('Debe seleccionar al menos un material de apoyo para proceder a su eliminación.');
			}
			else
			{
				if(confirm('Esta seguro de eliminar los datos.'))
				{
					location.href='eliminar_material_apoyo.php?datos='+datos+'';
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
			var j_ciclo;
			for(i=0;i<=f.length-1;i++)
			{
				if(f.elements[i].type=='checkbox')
				{	if(f.elements[i].checked==true)
					{	j_ciclo=f.elements[i].value;
						j=j+1;
					}
				}
			}
			if(j>1)
			{	alert('Debe seleccionar solamente un material de apoyo para editar sus datos.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un material de apoyo para editar sus datos.');
				}
				else
				{
					location.href='editar_material_apoyo.php?cod_material='+j_ciclo+'';
				}
			}
		}
		function cambiar_vista(sel_vista, f)
		{
			var modo_vista;
			modo_vista=sel_vista.value;
			location.href='navegador_material.php?vista='+modo_vista+'';
		}
		</script>";
	?>
        
	<?php
	require('estilos.inc');
	require("function_web.php");
	require("funcion_nombres.php");
	?>
        <link rel="stylesheet" type="text/css" href="dist/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="dist/bootstrap/dataTables.bootstrap4.min.css"/>
        <script type="text/javascript" src="dist/bootstrap/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="dist/bootstrap/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="dist/bootstrap/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="lib/js/xlibPrototipo-v0.1.js"></script>
        <link rel="stylesheet" type="text/css" href="dist/css/micss.css"/>
	<?php

	echo "<h3 class='text-muted'><center>Registro de Producto</center></h3>";

	echo "<form method='post' action=''>";		
	if(isset($vista)){	
		if($vista==1){
          $listProd=obtenerListadoProductosWeb("A");
		}else if($vista==0){
          $listProd=obtenerListadoProductosWeb("B");
		}else{
		  $listProd=obtenerListadoProductosWeb("");
		}
	}else{
		$listProd=obtenerListadoProductosWeb("");
	}

	
	
	echo "<table align='center' class='table table-bordered'><tr class=''><th>Ver Productos:</th>
	<th><select name='vista' class='texto' onChange='cambiar_vista(this, this.form)'>";
	if($vista==0)	echo "<option value='0' selected>A</option><option value='1'>B</option><option value='2'>Todo</option>";
	if($vista==1)	echo "<option value='0'>A</option><option value='1' selected>B</option><option value='2'>Todo</option>";
	if($vista==2)	echo "<option value='0'>A</option><option value='1'>B</option><option value='2' selected>Todo</option>";
	echo "</select>";
	echo "</th></tr></table><br>";
	
	echo "<center><table border='0' class='textomini'><tr><th>Leyenda:</th><th>Productos Retirados</th><td bgcolor='#ff6666' width='30%'></td></tr></table></center><br>";
	
	
	echo "<div class=''>
		<input type='button' value='Adicionar' name='adicionar' class='btn btn-warning text-white' onclick='enviar_nav()'>
		<input type='button' value='Editar' name='Editar' class='btn btn-warning text-white' onclick='editar_nav(this.form)'>
		<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
		</div>";
	
	echo "<center><table class='table table-bordered' id='tablaPrincipal'><thead>";
	echo "<tr class='bg-principal'><th>Indice</th><th>&nbsp;</th><th>Nombre Producto</th><th>Empaque</th>
		<th>Cant.Presentacion</th><th>Forma Farmaceutica</th><th>Linea Distribuidor</th><th>Principio Activo</th><th>Tipo Venta</th>
		<th>Accion Terapeutica</th></tr></thead><tbody>";
	
	$indice_tabla=1;
	foreach ($listProd->lista as $productos) {
        $codigo=$productos->cprod;
        $codProd=$productos->proveedor;
		$nombreProd=$productos->des;
		$estado=$productos->sta;
		$empaque="";
		$formaFar=$productos->tip;
		$nombreLinea=nombreProveedorExt($codProd);
		$tipoVenta=$productos->descaj;
		$cantPresentacion=$productos->cant;
		$principioActivo=$productos->destam;
		
		$txtAccionTerapeutica="";
		$sqlAccion="select a.nombre_accionterapeutica from acciones_terapeuticas a, material_accionterapeutica m
			where m.cod_accionterapeutica=a.cod_accionterapeutica and 
			m.codigo_material='$codigo'";
		$txtAccionTerapeutica="";
		//$respAccion=mysqli_query($enlaceCon,$sqlAccion);
		/*while($datAccion=mysqli_fetch_array($respAccion)){
			$nombreAccionTerX=$datAccion[0];
			$txtAccionTerapeutica=$txtAccionTerapeutica." - ".$nombreAccionTerX;
		}*/
		
		echo "<tr><td align='center'>$indice_tabla</td><td align='center'>
		<input type='checkbox' name='codigo' value='$codigo'></td>
		<td>$nombreProd</td><td>$empaque</td>
		<td>$cantPresentacion</td><td>$formaFar</td>
		<td>$nombreLinea</td><td>$principioActivo</td><td>$tipoVenta</td><td>$txtAccionTerapeutica</td></tr>";
		$indice_tabla++;
    }
	echo "</tbody></table></center><br>";
	
		echo "<div class='divBotones'>
		<input type='button' value='Adicionar' name='adicionar' class='btn btn-warning text-white' onclick='enviar_nav()'>
		<input type='button' value='Editar' name='Editar' class='btn btn-warning text-white' onclick='editar_nav(this.form)'>
		<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
		</div>";
		
	echo "</form>";
?>
 <script type="text/javascript" src="dist/js/functionsGeneral.js"></script>