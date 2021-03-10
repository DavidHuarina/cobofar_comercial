<?php
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");
require("../funciones.php");
$sql="(SELECT s.cod_material,d.codigo_material,d.descripcion_material from subgrupos_material s join material_apoyo d on d.codigo_material=s.cod_material where s.cod_subgrupo=$codigo_registro and d.estado=1 order by 1)
   UNION (select d.codigo_material,0 as codigo_material,d.descripcion_material from material_apoyo d where d.estado=1 and d.codigo_material not in (SELECT s.cod_material from subgrupos_material s join material_apoyo d on d.codigo_material=s.cod_material where s.cod_subgrupo=$codigo_registro and d.estado=1) order by 1 limit 50)";
   //echo $sql;

$resp=mysqli_query($enlaceCon,$sql); 
?>
<script type="text/javascript">
  function generarProductosLinea(){
    alert("ok");
  }
  function seleccionar_todo(){
   for (i=0;i<document.f1.elements.length;i++)
      if(document.f1.elements[i].type == "checkbox")
         document.f1.elements[i].checked=1
   }
  function deseleccionar_todo(){
   for (i=0;i<document.f1.elements.length;i++)
      if(document.f1.elements[i].type == "checkbox")
         document.f1.elements[i].checked=0
   } 
</script>
<?php
$cadComboLinea="";
$consult="select t.`cod_linea_proveedor`, t.`nombre_linea_proveedor`,p.nombre_proveedor from `proveedores_lineas` t join proveedores p on p.cod_proveedor=t.cod_proveedor where estado=1";
$rs1=mysqli_query($enlaceCon,$consult);
while($reg1=mysqli_fetch_array($rs1))
   {$codTipo = $reg1["cod_linea_proveedor"];
    $nomTipo = $reg1["nombre_linea_proveedor"];
    $nomProv = $reg1["nombre_proveedor"];
    $cadComboLinea.="<option value='$codTipo' data-subtext='$nomProv'>$nomTipo</option>";
   }


echo "<form action='$urlSaveEditProducto' method='post' name='f1'>";
echo "<input type='hidden' name='padre_grupo' id='padre_grupo' value='$cod_padre'>";
echo "<h1>Modificar Producto del Clasificador</h1>";
echo "<input type='hidden' value='$codigo_registro' name='tipo' id='tipo'>";
echo "<div class=''>
<input type='submit' class='btn btn-primary' value='Guardar'>
<input type='button' class='btn btn-danger' value='Cancelar' onClick='location.href=\"$urlListDetalle2?codigo=$cod_padre\"'>
  <div class='float-right col-sm-4'>
   <table class='table table-condensed'>
   <tr><td width='15%'><label class=''>Líneas</label></td><td width='70%'><select id='linea' name='linea[]'class='selectpicker form-control' multiple data-actions-box='true' data-style='btn btn-warning' data-live-search='true'>$cadComboLinea</select></td><td width='5%' class='td-actions text-right'><a href='#' class='btn btn-default' onClick='generarProductosLinea()'>&nbsp;<i class='material-icons'>search</i>&nbsp;</a></td></tr>
   </table>  
  </div>
</div>";
	echo "<center><table class='table table-sm table-bordered'>";
	echo "<tr class='bg-info text-white font-weight-bold'>
	<th width='10%'><div class='btn-group'><a href='#' class='btn btn-sm btn-warning' onClick='seleccionar_todo()'>T</a><a href='#' onClick='deseleccionar_todo()' class='btn btn-sm btn-default'>N</a></div></th>
	<th>Días</th>
	</tr>";
	$index=0;
	while($dat=mysqli_fetch_array($resp))
	{
		$index++;		 
		$dias=$dat[2];
		$checked="";
		if($dat[1]>0){
         $checked="checked";
		}
		echo "<tr>
		<td><input type='checkbox' name='codigo[]' value='$dat[0]' $checked></td>
		<td>$dias</td>
		</tr>";
	}
	echo "</table></center><br>";




echo "<div class=''>
<input type='submit' class='btn btn-primary' value='Guardar'>
<input type='button' class='btn btn-danger' value='Cancelar' onClick='location.href=\"$urlListDetalle2?codigo=$cod_padre\"'>
</div>";

echo "</form>";
?>