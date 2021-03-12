<?php
ini_set('post_max_size','100M');
?>

<script language='Javascript'>
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

function modifPrecioB(){
   var main=document.getElementById('main');
   var numFilas=main.rows.length;
   var subtotal=0;
   var datoModif=parseFloat(document.getElementById('valorPrecioB').value);
   datoModif=datoModif/100;
	for(var i=1; i<=numFilas-1; i++){
		var dato=parseFloat(main.rows[i].cells[1].firstChild.value);
		var datoNuevo=dato+(datoModif*dato);
		main.rows[i].cells[2].firstChild.value=datoNuevo;
	}

}

function modifPrecioC(){
   var main=document.getElementById('main');
   var numFilas=main.rows.length;
   var subtotal=0;
   var datoModif=parseFloat(document.getElementById('valorPrecioC').value);
   datoModif=datoModif/100;
	for(var i=1; i<=numFilas-1; i++){
		var dato=parseFloat(main.rows[i].cells[1].firstChild.value);
		var datoNuevo=dato+(datoModif*dato);
		main.rows[i].cells[3].firstChild.value=datoNuevo;
	}

}

function modifPrecioF(){
   var main=document.getElementById('main');
   var numFilas=main.rows.length;
   var subtotal=0;
   var datoModif=parseFloat(document.getElementById('valorPrecioF').value);
   datoModif=datoModif/100;
	for(var i=1; i<=numFilas-1; i++){
		var dato=parseFloat(main.rows[i].cells[1].firstChild.value);
		var datoNuevo=dato+(datoModif*dato);
		main.rows[i].cells[4].firstChild.value=datoNuevo;
	}

}

function modifPrecios(indice){
	var main=document.getElementById("main");

	var datoModif=parseFloat(document.getElementById('valorPrecioB').value);
	datoModif=datoModif/100;
	var dato=parseFloat(main.rows[indice].cells[2].firstChild.value);
	var datoNuevo=dato+(datoModif*dato);
	main.rows[indice].cells[2].firstChild.value=datoNuevo;

	datoModif=parseFloat(document.getElementById('valorPrecioC').value);
	datoModif=datoModif/100;
	dato=parseFloat(main.rows[indice].cells[3].firstChild.value);
	datoNuevo=dato+(datoModif*dato);
	main.rows[indice].cells[3].firstChild.value=datoNuevo;

	datoModif=parseFloat(document.getElementById('valorPrecioF').value);
	datoModif=datoModif/100;
	dato=parseFloat(main.rows[indice].cells[4].firstChild.value);
	datoNuevo=dato+(datoModif*dato);
	main.rows[indice].cells[4].firstChild.value=datoNuevo;



}

function modifPreciosAjax(indice){
	var item=document.getElementById('item_'+indice).value;
	var precio1=document.getElementById('precio1_'+indice).value;
	var precio2=document.getElementById('precio2_'+indice).value;
	var precio3=document.getElementById('precio3_'+indice).value;
	var precio4=document.getElementById('precio4_'+indice).value;
	contenedor = document.getElementById('contenedor_'+indice);
	ajax=nuevoAjax();
	ajax.open("GET", "ajaxGuardarPrecios.php?item="+item+"&precio1="+precio1+"&precio2="+precio2+"&precio3="+precio3+"&precio4="+precio4,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText
		}else{
			contenedor.innerHTML="Guardando...";
		}
	}
	ajax.send(null)
	
}

function cambiarPrecioIndividual(indice){
	var item=document.getElementById('item_'+indice).value;
	var precio1=document.getElementById('precio1_'+indice).value;
	precio1=parseFloat(precio1);
	
	var porcentajeCambiar=parseFloat(document.getElementById('valorPrecioB').value);
	porcentajeCambiar=porcentajeCambiar/100;
	var datoNuevo=precio1+(porcentajeCambiar*precio1);
	main.rows[indice].cells[2].firstChild.value=datoNuevo;
	
	var porcentajeCambiar=parseFloat(document.getElementById('valorPrecioC').value);
	porcentajeCambiar=porcentajeCambiar/100;
	var datoNuevo=precio1+(porcentajeCambiar*precio1);
	main.rows[indice].cells[3].firstChild.value=datoNuevo;
	
	var porcentajeCambiar=parseFloat(document.getElementById('valorPrecioF').value);
	porcentajeCambiar=porcentajeCambiar/100;
	var datoNuevo=precio1+(porcentajeCambiar*precio1);
	main.rows[indice].cells[4].firstChild.value=datoNuevo;
	
		
}

function copiarPrecio(){
  var precio=$("#precio_general").val();
  for (var i = 0; i < parseInt($("#cantidad_items").val()); i++) {
  	$("#precio"+(i+1)).val(precio);
  }
}
function regresarPrecio(){  
 for (var i = 0; i < parseInt($("#cantidad_items").val()); i++) {
 	var precio=$("#precio_origen"+(i+1)).val();
  	$("#precio"+(i+1)).val(precio);
  }
}
function guardarFilaPrecioTodos(){
	var solo=0;
	for (var i = 0; i < parseInt($("#cantidad_items").val()); i++) {
		if((i+1)==parseInt($("#cantidad_items").val())){
			solo=1;
		}
		guardarFilaPrecio((i+1),solo);
     }
}
function guardarFilaPrecio(indice,solo){
	var codigo =$("#codigo_material").val();
	var precio =$("#precio"+indice).val();
	var sucursal =$("#item_"+indice).val();
  var parametros={"codigo":codigo,"precio":precio,"sucursal":sucursal};
     $.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajaxCambiarPrecioDetalle.php",
        data: parametros,
        beforeSend: function () {
        $("#texto_ajax_titulo").html(); 
          iniciarCargaAjax("Estamos actualizando el precio");
        },        
        success:  function (resp) {
          detectarCargaAjax();
          //Swal.fire("Correcto!", resp, "success");
          if(resp.split("#####")[1]==1){
           if(solo>0){
             location.href='list.php';	
           }
          }else{
          	if(solo>0){
              Swal.fire("Error!", "Ocurrio un error al guardar el precio", "error");
            }
          }
        }
      });
}
function salir(){
	location.href="list.php";
}
function enviar(f){
	f.submit();
}
</script>
<?php

	require("../conexionmysqli.inc");
	require("../estilos2.inc");
	require("../funciones.php");

	$globalAlmacen=$_COOKIE['global_almacen'];
	$codigoMaterial=$_GET['codigo'];
	
	echo "<form method='POST' action='guardarPrecios.php' name='form1'>";
	
	$sql="select cod_ciudad,descripcion from ciudades order by 1;";

	//echo $sql;
	
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<h1>Registro y Edición de Precios</h1>";
	echo "<div class=''>
	<input type='button' value='Guardar Todo' name='adicionar' class='btn btn-primary' onclick='guardarFilaPrecioTodos()'>
	<input type='button' value='Cancelar' name='adicionar' class='btn btn-danger' onclick='salir()'>	
	<a href='#' onclick='regresarPrecio()' class='btn btn-danger btn-sm btn-fab float-right'><i class='material-icons'>replay</i>&nbsp;</a>
	<a href='#' onclick='copiarPrecio()' class='btn btn-warning btn-sm btn-fab float-right'><i class='material-icons'>assignment_returned</i>&nbsp;</a>	
	<input type='number' class='form-control col-sm-2 float-right' style='background:#E3DDDF;' step='any' value='0' id='precio_general' name='precio_general' placeholder='Precio General'>
	</div>";
	echo "<center><div class='col-sm-8'><table class='table table-sm table-bordered' id='main'>";
   
	echo "<tr class='bg-principal text-white'><th>#</th><th width='60%'>Sucusal</th>
	<th>Precio</th>
	<th>-</th>
	</tr>";
	$indice=1;
	while($dat=mysqli_fetch_array($resp))
	{
		$codigo=$dat[0];
		$nombreMaterial=$dat[1];

		$sqlPrecio="SELECT p.`precio` from `precios` p where p.`cod_precio`=1 and p.`cod_ciudad`=$codigo and p.`codigo_material`=$codigoMaterial";
		$respPrecio=mysqli_query($enlaceCon,$sqlPrecio);
		$numFilas=mysqli_num_rows($respPrecio);
		if($numFilas==1){
			$precio1=mysqli_result($respPrecio,0,0);
			$precio1=redondear2($precio1);
		}else{
			$precio1=0;
			$precio1=redondear2($precio1);
		}


		echo "<tr><td>$indice</td><td>$nombreMaterial
		</td>";
		echo "<input type='hidden' name='item_$indice' id='item_$indice' value='$codigo'>";
		echo "<td align='center'><input type='hidden' value='$precio1' id='precio_origen$indice'><input type='number' class='form-control' style='background:#E3DDDF;text-align:right;' step='any' value='$precio1' id='precio$indice' name='$codigo'></td>";
		echo "<td><a href='#' onclick='guardarFilaPrecio($indice,1)' class='btn btn-success btn-sm btn-fab'><i class='material-icons'>save</i>&nbsp;</a><div id='contenedor_$indice'></div></td>";
		echo "</tr>";
		
		$indice++;

	}
	echo "</table></div><input type='hidden' name='cantidad_items' id='cantidad_items' value='$indice'><input type='hidden' name='codigo_material' id='codigo_material' value='$codigoMaterial'></center>";

    echo "<div class=''>
	<input type='button' value='Guardar Todo' name='adicionar' class='btn btn-primary' onclick='enviar(form1)'>
	</div>";
	echo "</form>";
?>