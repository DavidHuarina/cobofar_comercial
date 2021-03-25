<?php

require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");
?>
<script>
	function cambiarSubLinea(){
  var categoria=$("#rpt_categoria").val();
  var parametros={"categoria":categoria};
     $.ajax({
        type: "GET",
        dataType: 'html',
        url: "../ajaxCambiarComboLinea.php",
        data: parametros,   
        success:  function (resp) { 
        	//alert(resp);
          $("#rpt_subcategoria").html(resp);
          $(".selectpicker").selectpicker("refresh");
        }
    });
 }
 function monstrarLoad(){
    $("#boton_envio").attr("disabled",true);
    $("#boton_envio").val("Enviando...",true);
 }
</script>
<?php
$fecha_rptinidefault=date("Y")."-".date("m")."-01";
$hora_rptinidefault=date("H:i");
$fecha_rptdefault=date("Y-m-d");
echo "<form action='$urlSave' method='post' onsubmit='monstrarLoad()'>";

echo "<h1>Registrar $moduleNameSingular</h1>";

echo "<center><table class='table table-sm' width='60%'>";

echo "<tr><td align='left' class='bg-info text-white'>Nombre</td>";
echo "<td align='left' colspan='3'>
	<input type='text' class='form-control' name='nombre' size='40' onKeyUp='javascript:this.value=this.value.toUpperCase();' required>
</td></tr>";
echo "<tr><td align='left' class='bg-info text-white'>A Fecha</td>";
echo "<td align='left'>
	<INPUT  type='date' class='form-control' value='$fecha_rptdefault' id='fecha_fin' size='10' name='fecha_fin'>
</td>";
echo "</tr>";
echo "<tr><td align='left' class='bg-info text-white'>Proveedor</td>";
echo "<td align='left'>
	<select name='rpt_categoria'  id='rpt_categoria' class='selectpicker form-control' data-style='btn btn-primary' onchange='cambiarSubLinea()' data-live-search='true'>
	<option value='' disabled selected>--Seleccione--</option>";
	$sql="select cod_proveedor, nombre_proveedor from proveedores order by 2";
	$resp=mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_cat=$dat[0];
		$nombre_cat=$dat[1];
		echo "<option value='$codigo_cat'>$nombre_cat</option>";
	}
	echo "</select>
</td>";
echo "</tr>";
echo "<tr><td align='left' class='bg-info text-white'>Línea</td>";
echo "<td align='left'>
	<select name='rpt_subcategoria[]' id='rpt_subcategoria' class='selectpicker form-control' multiple data-style='btn btn-primary' data-actions-box='true' data-live-search='true'>";
	echo "</select>
</td>";
echo "</tr>";
echo "<tr><td align='left' class='bg-info text-white'>Observación</td>";
echo "<td align='left' colspan='3'>
	<input type='text' class='form-control' name='glosa_inventario' size='40'>
</td></tr>";
echo "</table></center>";

echo "<div class=''>
<input type='submit' class='btn btn-primary' value='Guardar' id='boton_envio'>
<input type='button' class='btn btn-danger' value='Cancelar' onClick='location.href=\"$urlList2\"'>
";

echo "</form>";
?>