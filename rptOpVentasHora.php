<script language='JavaScript'>
function envia_formulario(f)
{	var fecha_ini, fecha_fin;
	
	var codTipoTerritorio=new Array();
	var j=0;
	for(var i=0;i<=f.rpt_territorio.options.length-1;i++)
	{	if(f.rpt_territorio.options[i].selected)
		{	codTipoTerritorio[j]=f.rpt_territorio.options[i].value;
			j++;
		}
	}
	
	fecha_ini=f.exafinicial.value;
	fecha_fin=f.exaffinal.value;
	window.open('rptVentasHora.php?codTipoTerritorio='+codTipoTerritorio+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'','','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,height=800');			
	return(true);
}
function envia_formulario_detalle(f)
{	var fecha_ini, fecha_fin;
	
	var codTipoPago=new Array();
	var j=0;
	for(var i=0;i<=f.rpt_tipopago.options.length-1;i++)
	{	if(f.rpt_tipopago.options[i].selected)
		{	codTipoPago[j]=f.rpt_tipopago.options[i].value;
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
	
	fecha_ini=f.exafinicial.value;
	fecha_fin=f.exaffinal.value;
	window.open('rptVentasSucursal_detalle.php?codTipoTerritorio='+codTipoTerritorio+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'&codTipoPago='+codTipoPago+'','','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,height=800');			
	return(true);
}
function envia_formulario_resumido(f)
{	var fecha_ini, fecha_fin;
	var codTipoPago=new Array();
	var j=0;
	for(var i=0;i<=f.rpt_tipopago.options.length-1;i++)
	{	if(f.rpt_tipopago.options[i].selected)
		{	codTipoPago[j]=f.rpt_tipopago.options[i].value;
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
	fecha_ini=f.exafinicial.value;
	fecha_fin=f.exaffinal.value;
	window.open('rptVentasSucursal_resumido.php?codTipoTerritorio='+codTipoTerritorio+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'&codTipoPago='+codTipoPago+'','','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,height=800');			
	return(true);
}
</script>
<?php

require("conexionmysqli.inc");
require("estilos_almacenes.inc");

$fecha_rptdefault=date("Y-m-d");
echo "<h1>Reporte Ventas x Hora</h1><br>";
echo"<form method='post' action='rptOpKardexCostos.php'>";

	echo"\n<table class='' align='center' cellSpacing='0' width='50%'>\n";
	echo "<tr><th align='left' class='text-muted'>Sucursal</th><td><select name='rpt_territorio' data-live-search='true' title='-- Elija una sucursal --'  id='rpt_territorio' multiple data-actions-box='true' data-style='select-with-transition' data-actions-box='true' data-size='10' class='selectpicker form-control' required>";
$globalAgencia=$_COOKIE["global_agencia"];
	if($_COOKIE["admin_central"]==1){
       $sql="select cod_ciudad, descripcion from ciudades where cod_ciudad>0 order by descripcion";    
	}else{
	   
       $sql="select cod_ciudad, descripcion from ciudades where cod_ciudad>0 and cod_ciudad='$globalAgencia' order by descripcion";
	}
	
	$resp=mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_ciudad=$dat[0];
		$nombre_ciudad=$dat[1];
		if($codigo_ciudad==$globalAgencia){
           echo "<option value='$codigo_ciudad' selected>$nombre_ciudad</option>";
		}else{
		   echo "<option value='$codigo_ciudad'>$nombre_ciudad</option>";	
		}		
	}
	echo "</select></td></tr>";
	
	
	echo "<tr><th align='left' class='text-muted'>Fecha inicio:</th>";
			echo" <TD bgcolor='#ffffff'><INPUT  type='date' class='form-control' value='$fecha_rptdefault' id='exafinicial' size='10' name='exafinicial' required >";
    		echo" <DLCALENDAR tool_tip='Seleccione la Fecha' ";
    		echo" daybar_style='background-color: DBE1E7; font-family: verdana; color:000000;' ";
    		echo" navbar_style='background-color: 7992B7; color:ffffff;' ";
    		echo" input_element_id='exafinicial' ";
    		echo" click_element_id='imagenFecha'></DLCALENDAR>";
    		echo"  </TD>";
	echo "</tr>";
	echo "<tr><th align='left' class='text-muted'>Fecha final:</th>";
			echo" <TD bgcolor='#ffffff'><INPUT  type='date' class='form-control' value='$fecha_rptdefault' id='exaffinal' size='10' name='exaffinal' required>";
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