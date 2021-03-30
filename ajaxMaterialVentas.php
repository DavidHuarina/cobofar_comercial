<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="stilos.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php 
$estilosVenta=1;
require("conexionmysqli.inc");
	$num=$_GET['codigo'];
	$cod_precio=0;
	if(isset($_GET["cod_precio"])){
		$cod_precio=$_GET["cod_precio"];
	}

?>

<table border="0" align="center" width="100%"  class="texto" id="data<?php echo $num?>" >
<tr bgcolor="#FFFFFF">

<td width="10%" align="center">
	<div class="btn-group">
		<!--  shuffle  <a id="receta_boton<?php // echo $num;?>" href="javascript:registrarReceta(<?php //echo $num;?>)" class="btn btn-danger btn-sm btn-fab"><i class='material-icons float-left' title="Registrar Receta">medical_services</i></a>-->
		<a href="javascript:similaresMaterial(<?php echo $num;?>)" class="btn btn-success btn-sm btn-fab"><i class='material-icons float-left' title="Productos Similares">device_hub</i></a>
	    <a href="javascript:encontrarMaterial(<?php echo $num;?>)" class="btn btn-primary btn-sm btn-fab"><i class='material-icons float-left' title="Encontrar Producto">place</i></a>
	    <a href="javascript:buscarMaterial(form1, <?php echo $num;?>)" class="btn btn-info btn-sm btn-fab"><i class='material-icons float-left' title="Buscar Producto">search</i></a>
	</div>	
</td>

<td width="30%" align="left">
	<input type="hidden" name="materiales<?php echo $num;?>" id="materiales<?php echo $num;?>" value="0">
	<div id="cod_material<?php echo $num;?>" class='textomedianonegro'>-</div>
</td>

<td width="10%" align="center">
	<div id='idstock<?php echo $num;?>'>
		<input type='hidden' id='stock<?php echo $num;?>' name='stock<?php echo $num;?>' value=''>
	</div>
</td>

<td align="center" width="10%">
	<input class="inputnumber" type="number" min="1" id="cantidad_unitaria<?php echo $num;?>" onKeyUp='ajaxPrecioItem(<?php echo $num;?>);' name="cantidad_unitaria<?php echo $num;?>" onChange='ajaxPrecioItem(<?php echo $num;?>);' step="1" value="1" required> 
</td>


<td align="center" width="10%">
	<div id='idprecio<?php echo $num;?>'>
		<input class="inputnumber" type="number" min="1" value="0" id="precio_unitario<?php echo $num;?>" name="precio_unitario<?php echo $num;?>" onKeyUp='ajaxPrecioItem(<?php echo $num;?>);' onChange='ajaxPrecioItem(<?php echo $num;?>);' step="0.01" required>
	</div>
</td>

<td align="center" width="20%">
	<?php
	        $fecha=0;
	        if(isset($_GET["fecha"])){
	        	$fecha=explode("/",$_GET["fecha"]);
	        	$fechaCompleta=$fecha[2]."-".$fecha[1]."-".$fecha[0];	        	
	        }
	        $ciudad=$_COOKIE['global_agencia'];
			echo "<select name='tipoPrecio' class='texto".$num." ' id='tipoPrecio".$num."' style='width:55px !important;float:left;background:#85929E;color:white;height:30px;' onchange='ajaxPrecioItem(".$num.")'>";
             echo "<option value='-9999'>SIN PROMOCIONES</option>";	
			echo "</select>";
			//echo $sql1;
			?>
	<input class="inputnumber"type="number" value="0" id="descuentoProducto<?php echo $num;?>" name="descuentoProducto<?php echo $num;?>" onKeyUp='ajaxPrecioItem(<?php echo $num;?>);' onChange='ajaxPrecioItem(<?php echo $num;?>);'  value="0" step="0.01" readonly>
</td>

<td align="center" width="15%">
	<input class="inputnumber" type="number" value="0" id="montoMaterial<?php echo $num;?>" name="montoMaterial<?php echo $num;?>" value="0"  step="0.01"  required readonly> 
</td>

<td align="center"  width="10%" ><input class="boton2peque" type="button" value="-" onclick="menos(<?php echo $num;?>)" /></td>

</tr>
</table>
</head>
</html>