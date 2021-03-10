<?php
require("conexionmysqli.inc");
echo "<script language='JavaScript'>
		function envia_formulario(f)
		{	
			var periodo, filtro,fecha_ini, fecha_fin;
            var rpt_territorio = [];
            $('#rpt_territorio :selected').each(function(i, selected) {
                rpt_territorio[i] = $(selected).val();
            });

			/*rpt_territorio=$('#rpt_territorio').val();*/
			filtro=f.filtro.value;
			fecha_ini=f.exafinicial.value;
			fecha_fin=f.exaffinal.value;
            periodo=f.periodo_ingreso.value;
			window.open('rpt_inv_ingresos_periodo.php?rpt_territorio='+JSON.stringify(rpt_territorio)+'&filtro='+filtro+'&periodo='+periodo+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'','','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,width=1000,height=800');
			return(true);
		}
		function envia_select(form){
			form.submit();
			return(true);
		}
		</script>";
if(isset($global_tipoalmacen)&&$global_tipoalmacen==1)
{	require("estilos_almacenes_central.inc");
}
else
{	require("estilos_almacenes.inc");
}
$fecha_rptdefault=date("Y-m-d");
echo "<h1>Verificación de Tiempos en Traspasos</h1>";
echo"<form method='post' action=''>";
	echo"\n<table class='texto' align='center'>\n";
	echo "<tr><th align='left'>Sucursal</th><td><select id='rpt_territorio' name='rpt_territorio[]' class='selectpicker form-control' data-style='btn btn-primary' multiple data-live-search='true' data-actions-box='true'>";
	$sql="select a.cod_almacen, c.descripcion from ciudades c join almacenes a on a.cod_ciudad=c.cod_ciudad order by c.descripcion;";
	$resp=mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_ciudad=$dat[0];
		$nombre_ciudad=$dat[1];
		if($rpt_territorio==$codigo_ciudad)
		{	echo "<option value='$codigo_ciudad' selected>$nombre_ciudad</option>";
		}
		else
		{	echo "<option value='$codigo_ciudad'>$nombre_ciudad</option>";
		}
	}
	echo "</select></td></tr>";

    echo "<tr><th align='left'>Tiempo en tránsito</th>";
	echo "<td><select name='periodo_ingreso' class='selectpicker form-control' data-style='btn btn-primary'>";
	echo "<option value='1'>24 Hrs</option>";
	echo "<option value='2'>48 Hrs</option>";
	echo "</select></td>";
	echo "<tr><th align='left'>Filtro</th>";
	echo "<td><select name='filtro' class='selectpicker form-control' data-style='btn btn-default'>";
	echo "<option value='1'>Ver Ingresos Puntuales</option>";
	echo "<option value='2'>Ver Todo</option>";
	echo "</select></td>";
	echo "<tr><th align='left'>Fecha inicio:</th>";
			echo" <TD bgcolor='#ffffff'><INPUT  type='date' class='form-control' value='$fecha_rptdefault' id='exafinicial' size='10' name='exafinicial'>";
    		echo" <DLCALENDAR tool_tip='Seleccione la Fecha' ";
    		echo" daybar_style='background-color: DBE1E7; font-family: verdana; color:000000;' ";
    		echo" navbar_style='background-color: 7992B7; color:ffffff;' ";
    		echo" input_element_id='exafinicial' ";
    		echo" click_element_id='imagenFecha'></DLCALENDAR>";
    		echo"  </TD>";
	echo "</tr>";
	echo "<tr><th align='left'>Fecha final:</th>";
			echo" <TD bgcolor='#ffffff'><INPUT  type='date' class='form-control' value='$fecha_rptdefault' id='exaffinal' size='10' name='exaffinal'>";
    		echo" <DLCALENDAR tool_tip='Seleccione la Fecha' ";
    		echo" daybar_style='background-color: DBE1E7; font-family: verdana; color:000000;' ";
    		echo" navbar_style='background-color: 7992B7; color:ffffff;' ";
    		echo" input_element_id='exaffinal' ";
    		echo" click_element_id='imagenFecha1'></DLCALENDAR>";
    		echo"  </TD>";
	echo "</tr>";
    
	echo"\n </table><br>";
	require('home_almacen.php');
	echo "<center><input type='button' name='reporte' value='Ver Reporte' onClick='envia_formulario(this.form)' class='btn btn-primary'>
	</center><br>";
	echo"</form>";
	echo "</div>";
	echo"<script type='text/javascript' language='javascript'  src='dlcalendar.js'></script>";

?>