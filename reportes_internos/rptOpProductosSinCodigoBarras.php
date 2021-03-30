

<script language='JavaScript'>
function envia_formulario(f)
{	var fecha_ini, fecha_fin, rpt_formato;
	

	var codSubGrupo=new Array();
	var j=0;
	for(var i=0;i<=f.rpt_subcategoria.options.length-1;i++)
	{	if(f.rpt_subcategoria.options[i].selected)
		{	codSubGrupo[j]=f.rpt_subcategoria.options[i].value;
			j++;
		}
	}

	var codTipoTerritorio=new Array();
	var j=0;
	for(var i=0;i<=f.rpt_territorio.options.length-1;i++)
	{	if(f.rpt_territorio.options[i].selected)
		{	codTipoTerritorio[j]=f.rpt_territorio.options[i].value;
			j++;
		}
	}
	
	window.open('rptProductosSinBarras.php?codTipoTerritorio='+codTipoTerritorio+''+'&codSubGrupo='+codSubGrupo+'','','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,height=800');			
	return(true);
}
function cambiarSubLinea(f){
  var categoria=new Array();
	var j=0;
	for(var i=0;i<=f.rpt_categoria.options.length-1;i++)
	{	if(f.rpt_categoria.options[i].selected)
		{	categoria[j]=f.rpt_categoria.options[i].value;
			j++;
		}
	}
  var parametros={"categoria":JSON.stringify(categoria)};
     $.ajax({
        type: "GET",
        dataType: 'html',
        url: "../ajaxCambiarComboLineaVarios.php",
        data: parametros,   
        success:  function (resp) { 
          $("#rpt_subcategoria").html(resp);
          $(".selectpicker").selectpicker("refresh");
        }
    });
}
</script>
<?php

require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");

$fecha_rptdefault=date("Y-m-d");
echo "<center><h3>Productos sin Codigo de Barras</h3></center><br>";
echo"<form method='post' action='rptProductosSinBarras.php'>";

	echo"\n<table class='' align='center' cellSpacing='0' width='50%'>\n";

	echo "<tr><th align='left' class='text-muted' width='20%' >Proveedor:</th>
	<td><select name='rpt_categoria'  id='rpt_categoria' class='selectpicker form-control' data-style='btn btn-primary' data-style='btn btn-primary' onchange='cambiarSubLinea(this.form)' multiple data-live-search='true' data-actions-box='true'>
	";
	$sql="select cod_proveedor, nombre_proveedor from proveedores order by 2";
	$resp=mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_cat=$dat[0];
		$nombre_cat=$dat[1];
		echo "<option value='$codigo_cat'>$nombre_cat</option>";
	}
	echo "</select></td></tr>";
	echo "<tr><th align='left' class='text-muted' width='20%' >Linea:</th>
	<td><select name='rpt_subcategoria[]' id='rpt_subcategoria' class='selectpicker form-control' multiple data-style='btn btn-primary' data-actions-box='true' data-live-search='true'>";
	echo "</select></td></tr>";
	
	echo"\n </table><br>";
	echo "<center><input type='submit' name='reporte' value='Ver Reporte' class='btn btn-primary'>
	</center><br>";
	echo"</form>";
	echo "</div>";
	echo"<script type='text/javascript' language='javascript'  src='dlcalendar.js'></script>";

?>