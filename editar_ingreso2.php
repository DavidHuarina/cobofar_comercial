<html>
    <head>
        
<script type="text/javascript" src="lib/externos/jquery/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="dlcalendar.js"></script>
<?php

	require("conexionmysqli.inc");
	
	$codIngresoEditar=$_GET["codIngreso"];
	$sql=" select count(*) from ingreso_detalle_almacenes where cod_ingreso_almacen=".$codIngresoEditar;	
	$num_materiales=0;
	$resp= mysqli_query($enlaceCon,$sql);				
	while($dat=mysqli_fetch_array($resp)){	
		$num_materiales=$dat[0];
	}
?>
<script type='text/javascript' language='javascript'>
num=<?php echo $num_materiales;?>;
function nuevoAjax()
{	var xmlhttp=false;
	try {
			xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
	} catch (e) {
	try {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	} catch (E) {
		xmlhttp = false;
	}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 	xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
function ajaxNroSalida(){
	var contenedor;
	var nroSalida = parseInt(document.getElementById('nro_salida').value);
	if(isNaN(nroSalida)){
		nroSalida=0;
	}
	contenedor = document.getElementById('divNroSalida');
	ajax=nuevoAjax();

	ajax.open("GET", "ajaxNroSalida.php?nroSalida="+nroSalida,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText;
		}
	}
	ajax.send(null)
}

function listaMateriales(f){
	var contenedor;
	var codTipo=f.itemTipoMaterial.value;
	var nombreItem=f.itemNombreMaterial.value;
	contenedor = document.getElementById('divListaMateriales');
	ajax=nuevoAjax();
	ajax.open("GET", "ajaxListaMaterialesIngreso.php?codTipo="+codTipo+"&nombreItem="+nombreItem,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText;
		}
	}
	ajax.send(null)
}

function buscarMaterial(f, numMaterial){
	f.materialActivo.value=numMaterial;
	document.getElementById('divRecuadroExt').style.visibility='visible';
	document.getElementById('divProfileData').style.visibility='visible';
	document.getElementById('divProfileDetail').style.visibility='visible';
	document.getElementById('divListaMateriales').innerHTML='';
	document.getElementById('itemNombreMaterial').value='';	
	document.getElementById('itemNombreMaterial').focus();	
	
}
function setMateriales(f, cod, nombreMat){
	var numRegistro=f.materialActivo.value;
	
	document.getElementById('material'+numRegistro).value=cod;
	document.getElementById('cod_material'+numRegistro).innerHTML=nombreMat;
	
	document.getElementById('divRecuadroExt').style.visibility='hidden';
	document.getElementById('divProfileData').style.visibility='hidden';
	document.getElementById('divProfileDetail').style.visibility='hidden';
	
	document.getElementById("cantidad_unitaria"+numRegistro).focus();
	
}

		

function enviar_form(f)
{   f.submit();
}
	//num=0;

	function mas(obj) {

			num++;
			fi = document.getElementById('fiel');
			contenedor = document.createElement('div');
			contenedor.id = 'div'+num;  
			fi.type="style";
			fi.appendChild(contenedor);
			var div_material;
			div_material=document.getElementById("div"+num);			
			ajax=nuevoAjax();
			ajax.open("GET","ajaxMaterial.php?codigo="+num,true);
			ajax.onreadystatechange=function(){
				if (ajax.readyState==4) {
					div_material.innerHTML=ajax.responseText;
					buscarMaterial(form1, num);
				}
			}		
			ajax.send(null);
		
	}	
		
	function menos(numero) {
		if(numero==num){
			num=parseInt(num)-1;
		}
		//num=parseInt(num)-1;
		fi = document.getElementById('fiel');
		fi.removeChild(document.getElementById('div'+numero));		
	}

function validar(f){   
	return true;
}


	</script>
<?php


require("estilos_almacenes.inc");

if($fecha=="")
{   $fecha=date("d/m/Y");
}

?>
<form action='guarda_editaringresomateriales2.php' method='post' name='form1'>
<input type="hidden" name="codIngreso" value="<?php echo $codIngresoEditar;?>" id="codIngreso">
<table border='0' class='textotit' align='center'><tr><th>Editar Ingreso de Productos</th></tr></table><br>

<?php

$sqlIngreso="select i.`nro_correlativo`, i.`fecha`, i.`cod_tipoingreso`, i.`nota_entrega`, i.`nro_factura_proveedor`, 
		i.`observaciones` from `ingreso_almacenes` i where i.`cod_ingreso_almacen` = $codIngresoEditar" ;
$respIngreso=mysqli_query($enlaceCon,$sqlIngreso);
while($datIngreso=mysqli_fetch_array($respIngreso)){
	$nroCorrelativo=$datIngreso[0];
	$fechaIngreso=$datIngreso[1];
	$codTipoIngreso=$datIngreso[2];
	$notaEntrega=$datIngreso[3];
	$nroFacturaProv=$datIngreso[4];
	$obsIngreso=$datIngreso[5];
}

?>
<table border='0' class='texto' cellspacing='0' align='center' width='90%' style='border:#ccc 1px solid;'>
<tr><th>Numero de Ingreso</th><th>Fecha</th><th>Tipo de Ingreso</th><th>Factura</th></tr>
<tr>
	<td align='center'><?php echo $nroCorrelativo?></td>
	<td align='center'>
	<input type="text" disabled="true" class="texto" value="<?php echo $fechaIngreso;?>" id="fecha" size="10" name="fecha">
	<img id='imagenFecha' src='imagenes/fecha.bmp'>
	</td>
	
<?php
$sql1="select cod_tipoingreso, nombre_tipoingreso from tipos_ingreso where cod_tipoingreso='$codTipoIngreso' order by nombre_tipoingreso";
$resp1=mysqli_query($enlaceCon,$sql1);
?>

<td align='center'><select name='tipo_ingreso' id='tipo_ingreso' class='selectpicker'>

<?php

while($dat1=mysqli_fetch_array($resp1))
{   $cod_tipoingr=$dat1[0];
    $nombre_tipoingreso=$dat1[1];
?>
    <option value="<?php echo $cod_tipoingr; ?>" <?php if($cod_tipoingr==$codTipoIngreso){echo "selected";}?>"><?php echo $nombre_tipoingreso;?></option>
<?php
}
?>
</select></td>
<td align="center"></td></tr>
<tr><th colspan="4">Observaciones</th></tr>
<tr>
<td colspan="4" align="center"><input type="text" class="texto" name="observaciones" value="<?php echo $obsIngreso; ?>" size="100"></td></tr>
</table><br>



<?php

echo "<div class='divBotones'>
<input type='submit' class='boton' value='Guardar' onClick='return validar(this.form);'></center>
<input type='button' class='boton2' value='Cancelar' onClick='location.href=\"navegador_ingresomateriales.php\"'></center>
</div>";
?>


<div id="divRecuadroExt" style="background-color:#666; position:absolute; width:800px; height: 500px; top:30px; left:150px; visibility: hidden; opacity: .70; -moz-opacity: .70; filter:alpha(opacity=70); -webkit-border-radius: 20px; -moz-border-radius: 20px; z-index:2;">
</div>

<div id="divProfileData" style="background-color:#FFF; width:750px; height:450px; position:absolute; top:50px; left:170px; -webkit-border-radius: 20px; 	-moz-border-radius: 20px; visibility: hidden; z-index:2;">
  	<div id="divProfileDetail" style="visibility:hidden; text-align:center; height:445px; overflow-y: scroll;">
		<table align='center' class="texto">
			<tr><th>Linea</th><th>Material</th><th>&nbsp;</th></tr>
			<tr>
			<td><select name='itemTipoMaterial' id="itemTipoMaterial" class="textogranderojo" style="width:300px">
			<?php
			$sqlTipo="select pl.cod_linea_proveedor, CONCAT(p.nombre_proveedor,' - ',pl.nombre_linea_proveedor) from proveedores p, proveedores_lineas pl 
			where p.cod_proveedor=pl.cod_proveedor and pl.estado=1 order by 2;";
			$respTipo=mysqli_query($enlaceCon,$sqlTipo);
			echo "<option value='0'>--</option>";
			while($datTipo=mysqli_fetch_array($respTipo)){
				$codTipoMat=$datTipo[0];
				$nombreTipoMat=$datTipo[1];
				echo "<option value=$codTipoMat>$nombreTipoMat</option>";
			}
			?>
			</select>
			</td>
			<td>
				<input type='text' name='itemNombreMaterial' id="itemNombreMaterial" class="textogranderojo">
			</td>
			<td>
				<input type='button' class='boton' value='Buscar' onClick="listaMateriales(this.form)">
			</td>
			</tr>
			
		</table>
		<div id="divListaMateriales">
		</div>
	
	</div>
</div>
<input type='hidden' name='materialActivo' value="0">
<input type='hidden' name='cantidad_material' value="0">

</form>
</body>