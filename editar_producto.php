<?php
require("conexionmysqli.inc");
require('estilos.inc');
require('funciones.php');
//UTF8
$sqlX="SET NAMES 'utf8'";
mysqli_query($enlaceCon,$sqlX);

?>
<script language='Javascript'>
	function validar(f)
	{
		if(f.codForma.value=='')
		{	alert('Debe seleccionar Forma Farmaceutica.');
			f.codForma.focus();
			return(false);
		}
		
		
		var codPrincipioActivo=new Array();
		var j=0;
		var nohayorden=0;
		$("#codPrincipioActivo option:selected").each(function(){
   	 	   var valor=$(this).val().split("#####");
   	 	   codPrincipioActivo[j]=valor[0];
   	 	   if($("#orden"+valor[0]).val()==""){
                	nohayorden++;
           }
           j++;
        });
        if(nohayorden>0)
		{	alert('Debe registrar el orden de cada Principio Activo.');
			return(false);
		}
		f.arrayPrincipioActivo.value=codPrincipioActivo;
		var codAccionTerapeutica=new Array();
		var j=0;
		for(i=0;i<=f.codAccionTerapeutica.options.length-1;i++)
		{	if(f.codAccionTerapeutica.options[i].selected)
			{	codAccionTerapeutica[j]=f.codAccionTerapeutica.options[i].value;
				j++;
			}
		}
		f.arrayAccionTerapeutica.value=codAccionTerapeutica;
		
		f.submit();
	}
   function modificarOrden(){
   	 $("#tabla_principios").html("");
   	 var html="";
   	 $("#codPrincipioActivo option:selected").each(function(){
   	 	var valor=$(this).val().split("#####");
        if (valor[0] != ""){     
          html+='<tr>';   
          html+='<td>'+$(this).text()+'</td>';
          html+='<td><input type="number" class="form-control" style="text-align:center" placeholder="Ingrese el orden" value="'+valor[1]+'" id="orden'+valor[0]+'" name="orden'+valor[0]+'"></td>';
          html+='<tr>';   
        }
     });
     $("#tabla_principios").html(html);
   }
</script>

<?php
$codProducto=$_GET['cod_material'];

$sqlEdit="select m.codigo_material, m.descripcion_material, m.estado, m.cod_linea_proveedor, m.cod_forma_far, m.cod_empaque, 
	m.cantidad_presentacion, m.principio_activo, m.cod_tipoventa, m.producto_controlado,m.codigo_barras from material_apoyo m where m.codigo_material='$codProducto'";
$respEdit=mysqli_query($enlaceCon,$sqlEdit);
while($datEdit=mysqli_fetch_array($respEdit)){
	$nombreProductoX=$datEdit[1];
	$codLineaX=$datEdit[3];
	$codFormaX=$datEdit[4];
	$codEmpaqueX=$datEdit[5];
	$cantidadPresentacionX=$datEdit[6];
	$principioActivoX=$datEdit[7];
	$codTipoVentaX=$datEdit[8];
	$productoControlado=$datEdit[9];
	$codigoBarras=$datEdit['codigo_barras'];
}
$sqlPrecio="select p.`precio` from `precios` p where p.`cod_precio`=1 and p.`codigo_material`='$codProducto'";
$respPrecio=mysqli_query($enlaceCon,$sqlPrecio);
$numFilas=mysqli_num_rows($respPrecio);
if($numFilas>=1){
	$precio1=mysqli_result($respPrecio,0,0);
	$precio1=redondear2($precio1);
}else{
	$precio1=0;
	$precio1=redondear2($precio1);
}

echo "<form action='guarda_editarproductolimit.php' method='post' name='form1'>";

echo "<h1>Editar Producto</h1>";


echo "<input type='hidden' name='codProducto' id='codProducto' value='$codProducto'>";

echo "<center><table class='texto'>";
echo "<tr><th align='left'>Nombre</th>";
echo "<td align='left'>
	<input type='text' class='form-control' name='material' size='40' style='text-transform:uppercase;' value='$nombreProductoX' readonly>
	</td>";
	
echo "<tr><th align='left'>Linea</th><td>";
$nombreLineaX=obtenerNombreProveedorLinea($codLineaX);
echo "<input type='text' class='form-control' name='linea' size='40' style='text-transform:uppercase;' value='$nombreLineaX' readonly></td>";
echo "</tr>";

echo "<tr><th>Forma Farmaceutica</th>";
$sql1="select f.cod_forma_far, f.nombre_forma_far from formas_farmaceuticas f 
where f.estado=1 order by 2;";
$resp1=mysqli_query($enlaceCon,$sql1);
echo "<td><select name='codForma' id='codForma' data-live-search='true' data-style='btn btn-info' class='form-control selectpicker'>";
  while($dat1=mysqli_fetch_array($resp1))
  {	$codForma=$dat1[0];
	$nombreForma=$dat1[1];
	if($codForma==$codFormaX){
		echo "<option value='$codForma' selected>$nombreForma</option>";
	}else{
		echo "<option value='$codForma'>$nombreForma</option>";
	}
  }
echo "</select>
</td>";
echo "</tr>";


echo "<tr><th>Principio Activo</th>";
$sql1="select l.codigo as value, l.nombre as texto from principios_activos l where l.estado=1;";
$resp1=mysqli_query($enlaceCon,$sql1);
echo "<td>
			<select name='codPrincipioActivo' id='codPrincipioActivo' class='selectpicker form-control' multiple data-style='btn btn-info' data-live-search='true' data-actions-box='true' onchange='modificarOrden()'>";
			while($dat1=mysqli_fetch_array($resp1))
			{	$codigo=$dat1[0];
				$nombre=$dat1[1];
				$sqlRevisa="select count(*) from principios_activosproductos m where m.cod_principioactivo='$codigo' and 
				m.cod_material='$codProducto'";
				$respRevisa=mysqli_query($enlaceCon,$sqlRevisa);
				$numRevisa=mysqli_result($respRevisa,0,0);
				if($numRevisa>0){
					$sqlOrden="select m.orden from principios_activosproductos m where m.cod_principioactivo='$codigo' and m.cod_material='$codProducto'";
				    $respOrden=mysqli_query($enlaceCon,$sqlOrden);
				    $orden=mysqli_result($respOrden,0,0);
					echo "<option value='$codigo#####$orden' selected>$nombre</option>";
				}else{
					echo "<option value='$codigo#####'>$nombre</option>";
				}
			}
echo "</select>
<center><br><table class='table table-condensed table-bordered table-sm' style='width:400px !important'><thead><tr><th style='background:#3498DB;color:#fff; font-size:14px;' width='70%'>Principio Activo</th><th style='background:#3498DB;color:#fff; font-size:14px;'>N. Orden</th></tr></thead><tbody id='tabla_principios'></tbody></table></center>
</td>";
echo "</tr>";

echo "<tr><th>Accion Terapeutica</th>";
$sql1="select l.cod_accionterapeutica as value, l.nombre_accionterapeutica as texto from acciones_terapeuticas l;";
$resp1=mysqli_query($enlaceCon,$sql1);
echo "<td>
			<select name='codAccionTerapeutica' id='codAccionTerapeutica' class='selectpicker form-control' multiple data-style='btn btn-info' data-live-search='true' data-actions-box='true'>";
			while($dat1=mysqli_fetch_array($resp1))
			{	$codigo=$dat1[0];
				$nombre=$dat1[1];
				$sqlRevisa="select count(*) from material_accionterapeutica m where m.cod_accionterapeutica='$codigo' and 
				m.codigo_material='$codProducto'";
				$respRevisa=mysqli_query($enlaceCon,$sqlRevisa);
				$numRevisa=mysqli_result($respRevisa,0,0);
				if($numRevisa>0){
					echo "<option value='$codigo' selected>$nombre</option>";
				}else{
					echo "<option value='$codigo'>$nombre</option>";
				}
			}
echo "</select>
</td>";
echo "</tr>";

echo "<tr><th>Producto Controlado</th>";
if($productoControlado==0){
	echo "<td>
			<input type='radio' name='producto_controlado' value='0' checked>&nbsp;NO
			<input type='radio' name='producto_controlado' value='1'>&nbsp;SI
	</td>";	
}else{
	echo "<td>
			<input type='radio' name='producto_controlado' value='0' checked>&nbsp;NO
			<input type='radio' name='producto_controlado' value='1' checked>&nbsp;SI
	</td>";
}
echo "</tr>";

echo "<tr><th align='left'>Codigo de Barras</th>";
echo "<td align='left'>
	<input type='number' class='form-control' name='codigo_barras' id='codigo_barras' value='$codigoBarras'>
	</td></tr>";
echo "</td></tr>";
echo "</table></center><br>";
echo "<input type='hidden' name='arrayAccionTerapeutica' id='arrayAccionTerapeutica'><input type='hidden' name='arrayPrincipioActivo' id='arrayPrincipioActivo'>";
echo "<div class=''>
<input type='button' class='btn btn-primary' value='Guardar' onClick='validar(this.form)'>
<input type='button' class='btn btn-danger' value='Cancelar' onClick='location.href=\"navegador_material.php\"'>
</div>";
echo "</form>";
?>
<script>
	modificarOrden();
</script>