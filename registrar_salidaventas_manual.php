<html>
    <head>
        <title>Venta</title>
        <link rel="shortcut icon" href="imagenes/icon_farma.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="lib/externos/jquery/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="lib/js/xlibPrototipoSimple-v0.1.js"></script>
		<script type="text/javascript" src="functionsGeneral.js"></script>
		
        <link rel="stylesheet" type="text/css" href="dist/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="dist/bootstrap/dataTables.bootstrap4.min.css"/>
        <script type="text/javascript" src="dist/bootstrap/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="dist/bootstrap/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="dist/bootstrap/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="lib/js/xlibPrototipo-v0.1.js"></script>
        <link rel="stylesheet" href="dist/selectpicker/dist/css/bootstrap-select.css">
        <link rel="stylesheet" type="text/css" href="dist/css/micss.css"/>
        <link rel="stylesheet" type="text/css" href="dist/demo.css"/>
        <style type="text/css">
        	body{
              zoom: 86%;
            }
        </style>
	
<script type='text/javascript' language='javascript'>
function mueveReloj(){
    momentoActual = new Date()
    hora = momentoActual.getHours()
    minuto = momentoActual.getMinutes()
    segundo = momentoActual.getSeconds()

    horaImprimible = hora + " : " + minuto
    $("#hora_sistema").html(horaImprimible);
    setTimeout("mueveReloj()",1000)
}
function funcionInicio(){
	//document.getElementById('nitCliente').focus();
}

function number_format(amount, decimals) {
    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.-]/g, '')); // elimino cualquier cosa que no sea numero o punto
    decimals = decimals || 0; // por si la variable no fue fue pasada
    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);
    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);
    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;
    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
    return amount_parts.join('.');
}
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

function listaMateriales(f){
	var contenedor;
	var codTipo=f.itemTipoMaterial.value;
	var codForma=f.itemFormaMaterial.value;
	var codAccion=f.itemAccionMaterial.value;
	var codPrincipio=f.itemPrincipioMaterial.value;
	var nombreItem=f.itemNombreMaterial.value;
	var tipoSalida=(f.tipoSalida.value);
	var codigoMat=(f.itemCodigoMaterial.value);
	contenedor = document.getElementById('divListaMateriales');

	var arrayItemsUtilizados=new Array();	
	var i=0;
	for(var j=1; j<=num; j++){
		if(document.getElementById('materiales'+j)!=null){
			console.log("codmaterial: "+document.getElementById('materiales'+j).value);
			arrayItemsUtilizados[i]=document.getElementById('materiales'+j).value;
			i++;
		}
	}
	
	ajax=nuevoAjax();
	ajax.open("GET", "ajaxListaMateriales.php?codigoMat="+codigoMat+"&codTipo="+codTipo+"&nombreItem="+nombreItem+"&arrayItemsUtilizados="+arrayItemsUtilizados+"&tipoSalida="+tipoSalida+"&codForma="+codForma+"&codAccion="+codAccion+"&codPrincipio="+codPrincipio,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			$("#divListaMateriales").html(ajax.responseText);
			//contenedor.innerHTML = ajax.responseText;
			document.getElementById('itemCodigoMaterial').focus();	
		}		
	}
	ajax.send(null)
}

function ajaxTipoDoc(f){
	var contenedor;
	contenedor=document.getElementById("divTipoDoc");
	ajax=nuevoAjax();
	var codTipoSalida=(f.tipoSalida.value);
	ajax.open("GET", "ajaxTipoDoc.php?codTipoSalida="+codTipoSalida,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText
		}
	}
	ajax.send(null);
}


function ajaxNroDoc(f){
	var contenedor;
	contenedor=document.getElementById("divNroDoc");
	ajax=nuevoAjax();
	var codTipoDoc=(f.tipoDoc.value);
	ajax.open("GET", "ajaxNroDoc.php?codTipoDoc="+codTipoDoc,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText
		}
	}
	ajax.send(null);
}

function actStock(indice){
	var contenedor;
	contenedor=document.getElementById("idstock"+indice);
	var codmat=document.getElementById("materiales"+indice).value;
    var codalm=document.getElementById("global_almacen").value;
	ajax=nuevoAjax();
	ajax.open("GET", "ajaxStockSalidaMateriales.php?codmat="+codmat+"&codalm="+codalm+"&indice="+indice,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText;
			ajaxCargarSelectDescuentos(indice);
		}
	}
	//verificarReceta(codmat,indice);
	totales();
	ajax.send(null);
}
function ajaxCargarSelectDescuentos(indice){
	var contenedor;
	contenedor=document.getElementById("idprecio"+indice);
	var codmat=document.getElementById("materiales"+indice).value;
	var tipoPrecio=document.getElementById("tipoPrecio"+indice).value;
	var cantidadUnitaria=document.getElementById("cantidad_unitaria"+indice).value;
	var fecha=document.getElementById("fecha").value;	
	ajax=nuevoAjax();
	ajax.open("GET", "ajaxLoadDescuento.php?codmat="+codmat+"&indice="+indice+"&tipoPrecio="+tipoPrecio+"&fecha="+fecha,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			var respuesta=ajax.responseText.split("#####");			
            $("#tipoPrecio"+indice).html(respuesta[2]);
			ajaxPrecioItem(indice);		
		}
	}
	ajax.send(null);	
}

/*function ajaxPrecioItem(indice){
	var contenedor;
	contenedor=document.getElementById("idprecio"+indice);
	var codmat=document.getElementById("materiales"+indice).value;
	var tipoPrecio=document.getElementById("tipoPrecio").value;
	ajax=nuevoAjax();
	ajax.open("GET", "ajaxPrecioItem.php?codmat="+codmat+"&indice="+indice+"&tipoPrecio="+tipoPrecio,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText;
			calculaMontoMaterial(indice);
		}
	}
	ajax.send(null);
}*/

function ajaxRazonSocial(f){
	var contenedor;
	contenedor=document.getElementById("divRazonSocial");
	var nitCliente=document.getElementById("nitCliente").value;
	ajax=nuevoAjax();
	ajax.open("GET", "ajaxRazonSocial.php?nitCliente="+nitCliente,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText;
			document.getElementById('razonSocial').focus();
			ajaxClienteBuscar();
		}
	}
	ajax.send(null);
}

function ajaxClienteBuscar(f){
	var contenedor;
	contenedor=document.getElementById("divCliente");
	var nitCliente=document.getElementById("nitCliente").value;
	ajax=nuevoAjax();
	ajax.open("GET", "ajaxClientes.php?nitCliente="+nitCliente,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			var datos_resp=ajax.responseText.split("####");
			//alert(datos_resp[1])
			$("#cliente").val(datos_resp[1]);
			$("#cliente").selectpicker('refresh');
		}
	}
	ajax.send(null);
}

function calculaMontoMaterial(indice){

	var cantidadUnitaria=document.getElementById("cantidad_unitaria"+indice).value;
	var precioUnitario=document.getElementById("precio_unitario"+indice).value;
	var descuentoUnitario=document.getElementById("descuentoProducto"+indice).value;
	
	/*var montoUnitario=(parseFloat(cantidadUnitaria)*parseFloat(precioUnitario)) -(parseFloat(cantidadUnitaria)*parseFloat(descuentoUnitario));*/
	var montoUnitario=(parseFloat(cantidadUnitaria)*parseFloat(precioUnitario))-(descuentoUnitario);
	montoUnitario=Math.round(montoUnitario*100)/100
		
	document.getElementById("montoMaterial"+indice).value=montoUnitario;
	
	totales();
}

function totales(){	
	var subtotal=0;
    for(var ii=1;ii<=num;ii++){
	 	if(document.getElementById('materiales'+ii)!=null){
			var monto=document.getElementById("montoMaterial"+ii).value;
			subtotal=subtotal+parseFloat(monto);
		}
    }
    var subtotalPrecio=0;
    for(var ii=1;ii<=num;ii++){
	 	if(document.getElementById('materiales'+ii)!=null){
			var precio=document.getElementById("precio_unitario"+ii).value;
			var cantidad=document.getElementById("cantidad_unitaria"+ii).value;
			subtotalPrecio=subtotalPrecio+parseFloat(precio*cantidad);
		}
    }
    document.getElementById("total_precio_sin_descuento").innerHTML=subtotalPrecio;

    subtotalPrecio=Math.round(subtotalPrecio*100)/100;

	subtotal=Math.round(subtotal*100)/100;
	
	var tipo_cambio=$("#tipo_cambio_dolar").val();

    document.getElementById("totalVenta").value=subtotal;
	document.getElementById("totalFinal").value=subtotal;

	document.getElementById("totalVentaUSD").value=Math.round((subtotal/tipo_cambio)*100)/100;
	document.getElementById("totalFinalUSD").value=Math.round((subtotal/tipo_cambio)*100)/100;

    //setear descuento o aplicar la suma total final con el descuento
	document.getElementById("descuentoVenta").value=0;
	document.getElementById("descuentoVentaUSD").value=0;
	aplicarCambioEfectivo();
	minimoEfectivo();
	cargarDescuentoTotalVenta(subtotal);
	
}
function cargarDescuentoTotalVenta(total){
	var parametros={"monto_total":total};
	$.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajaxDescuentoGeneralVenta.php",
        data: parametros,
        success:  function (resp) { 
           var r=resp.split("#####");
           $("#codigoDescuentoGeneral").val(r[1]); 
           $("#descuentoVenta").val(r[2]); 
           $("#porcentajeDescuentoRealNombre").html(r[3]); 
           $("#porcentajeDescuentoRealNombre2").html("<small>"+r[3]+"</small> %"); 
           aplicarDescuento();       	   
        }
    });	
}
function aplicarDescuento(f){
	var tipo_cambio=$("#tipo_cambio_dolar").val();
	var total=document.getElementById("totalVenta").value;
	var descuento=document.getElementById("descuentoVenta").value;
	
	descuento=Math.round(descuento*100)/100;
	
	document.getElementById("totalFinal").value=Math.round((parseFloat(total)-parseFloat(descuento))*100)/100;
	var descuentoUSD=(parseFloat(total)-parseFloat(descuento))/tipo_cambio;
	document.getElementById("descuentoVentaUSD").value=Math.round((descuento/tipo_cambio)*100)/100;
	document.getElementById("totalFinalUSD").value=Math.round((descuentoUSD)*100)/100;

	document.getElementById("descuentoVentaPorcentaje").value=Math.round((parseFloat(descuento)*100)/(parseFloat(total)));
	document.getElementById("descuentoVentaUSDPorcentaje").value=Math.round((parseFloat(descuento)*100)/(parseFloat(total)));
	aplicarCambioEfectivo();
	minimoEfectivo();
	//totales();
	
}
function aplicarDescuentoUSD(f){
	var tipo_cambio=$("#tipo_cambio_dolar").val();
	var total=document.getElementById("totalVentaUSD").value;
	var descuento=document.getElementById("descuentoVentaUSD").value;
	
	descuento=Math.round(descuento*100)/100;
	
	document.getElementById("totalFinalUSD").value=Math.round((parseFloat(total)-parseFloat(descuento))*100)/100;
	var descuentoBOB=(parseFloat(total)-parseFloat(descuento))*tipo_cambio;
	document.getElementById("descuentoVenta").value=Math.round((descuento*tipo_cambio)*100)/100;
	document.getElementById("totalFinal").value=Math.round((descuentoBOB)*100)/100;
	document.getElementById("descuentoVentaPorcentaje").value=Math.round((parseFloat(descuento)*100)/(parseFloat(total)));
	document.getElementById("descuentoVentaUSDPorcentaje").value=Math.round((parseFloat(descuento)*100)/(parseFloat(total)));
	aplicarCambioEfectivoUSD();
	minimoEfectivo();
	//totales();
}

function aplicarDescuentoPorcentaje(f){
	var tipo_cambio=$("#tipo_cambio_dolar").val();
	var total=document.getElementById("totalVenta").value;
    
    var descuentoPorcentaje=document.getElementById("descuentoVentaPorcentaje").value;
    document.getElementById("descuentoVentaUSDPorcentaje").value=descuentoPorcentaje;

	var descuento=document.getElementById("descuentoVenta").value;
	
	descuento=Math.round(parseFloat(descuentoPorcentaje)*parseFloat(total)/100);
	
	document.getElementById("totalFinal").value=Math.round((parseFloat(total)-parseFloat(descuento))*100)/100;
	var descuentoUSD=(parseFloat(total)-parseFloat(descuento))/tipo_cambio;
	document.getElementById("descuentoVenta").value=Math.round((descuento)*100)/100;
	document.getElementById("descuentoVentaUSD").value=Math.round((descuento/tipo_cambio)*100)/100;
	document.getElementById("totalFinalUSD").value=Math.round((descuentoUSD)*100)/100;
	
	aplicarCambioEfectivo();
	minimoEfectivo();
	//totales();
}


function aplicarDescuentoUSDPorcentaje(f){
	var tipo_cambio=$("#tipo_cambio_dolar").val();
	var total=document.getElementById("totalVenta").value;
    
    var descuentoPorcentaje=document.getElementById("descuentoVentaUSDPorcentaje").value;
    document.getElementById("descuentoVentaPorcentaje").value=descuentoPorcentaje;

	var descuento=document.getElementById("descuentoVenta").value;
	
	descuento=Math.round(parseFloat(descuentoPorcentaje)*parseFloat(total))/100;
	
	document.getElementById("totalFinal").value=Math.round((parseFloat(total)-parseFloat(descuento))*100)/100;
	var descuentoUSD=(parseFloat(total)-parseFloat(descuento))/tipo_cambio;
	document.getElementById("descuentoVenta").value=Math.round((descuento)*100)/100;
	document.getElementById("descuentoVentaUSD").value=Math.round((descuento/tipo_cambio)*100)/100;
	document.getElementById("totalFinalUSD").value=Math.round((descuentoUSD)*100)/100;
	
	aplicarCambioEfectivo();
	minimoEfectivo();
	//totales();
}
function minimoEfectivo(){
  //obtener el minimo a pagar
	var minimoEfectivo=$("#totalFinal").val();
	var minimoEfectivoUSD=$("#totalFinalUSD").val();
	//asignar el minimo al atributo min
	//$("#efectivoRecibidoUnido").attr("min",minimoEfectivo);
	//$("#efectivoRecibidoUnidoUSD").attr("min",minimoEfectivoUSD);		
}
function aplicarCambioEfectivo(f){
	var tipo_cambio=$("#tipo_cambio_dolar").val();
	var recibido=document.getElementById("efectivoRecibido").value;
	var total=document.getElementById("totalFinal").value;

	var cambio=Math.round((parseFloat(recibido)-parseFloat(total))*100)/100;
	document.getElementById("cambioEfectivo").value=parseFloat(cambio);
	document.getElementById("efectivoRecibidoUSD").value=Math.round((recibido/tipo_cambio)*100)/100;
	document.getElementById("cambioEfectivoUSD").value=Math.round((cambio/tipo_cambio)*100)/100;	
	minimoEfectivo();
}
function aplicarCambioEfectivoUSD(f){
	var tipo_cambio=$("#tipo_cambio_dolar").val();
	var recibido=document.getElementById("efectivoRecibidoUSD").value;
	var total=document.getElementById("totalFinalUSD").value;

	var cambio=Math.round((parseFloat(recibido)-parseFloat(total))*100)/100;
	document.getElementById("cambioEfectivoUSD").value=parseFloat(cambio);
	document.getElementById("efectivoRecibido").value=Math.round((recibido*tipo_cambio)*100)/100;
	document.getElementById("cambioEfectivo").value=Math.round((cambio*tipo_cambio)*100)/100;	
	minimoEfectivo();
}
function aplicarMontoCombinadoEfectivo(f){
   var efectivo=$("#efectivoRecibidoUnido").val();	
   var efectivoUSD=$("#efectivoRecibidoUnidoUSD").val();	
  if(efectivo==""){
   efectivo=0;
  }
  if(efectivoUSD==""){
   efectivoUSD=0;
  }	

  var tipo_cambio=$("#tipo_cambio_dolar").val();
  var monto_dolares_bolivianos=parseFloat(efectivoUSD)*parseFloat(tipo_cambio);
  var monto_total_bolivianos=monto_dolares_bolivianos+parseFloat(efectivo);
  document.getElementById("efectivoRecibido").value=Math.round((monto_total_bolivianos)*100)/100;
  document.getElementById("efectivoRecibidoUSD").value=Math.round((monto_total_bolivianos/tipo_cambio)*100)/100;
  aplicarCambioEfectivo(f);
}

function verCambio(f){
	var totalFinal=document.getElementById("totalFinal").value;
	var totalEfectivo=document.getElementById("totalEfectivo").value;
	var totalCambio=totalEfectivo-totalFinal;
	totalCambio=number_format(totalCambio,2);
	
	document.getElementById("totalCambio").value=totalCambio;
	
}
function buscarMaterial(f, numMaterial){
	f.materialActivo.value=numMaterial;
	document.getElementById('divRecuadroExt').style.visibility='visible';
	document.getElementById('divProfileData').style.visibility='visible';
	document.getElementById('divProfileDetail').style.visibility='visible';
	document.getElementById('divboton').style.visibility='visible';
	
	document.getElementById('divListaMateriales').innerHTML='';
	document.getElementById('itemNombreMaterial').value='';	
	//document.getElementById('itemNombreMaterial').focus();
	document.getElementById('itemCodigoMaterial').value='';	
	document.getElementById('itemCodigoMaterial').focus();		
	
}
function encontrarMaterial(numMaterial){
	var cod_material = $("#materiales"+numMaterial).val();
	var parametros={"cod_material":cod_material};
	$.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajax_encontrar_productos.php",
        data: parametros,
        success:  function (resp) { 
           // alert(resp);           
        	$("#modalProductosCercanos").modal("show");
        	//RefreshTable('tablaPrincipalGeneral', 'ajax_encontrar_productos.php');
        	$("#tabla_datos").html(resp); 
        	//tablaPrincipalGeneral.ajax.reload();        	   
        }
    });	
}

function similaresMaterial(numMaterial){
	$("#materialActivo").val(numMaterial);
	var cod_material = $("#materiales"+numMaterial).val();
	var parametros={"cod_material":cod_material};
	$.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajax_encontrar_productos_similares.php",
        data: parametros,
        success:  function (resp) {          
        	$("#modalProductosSimilares").modal("show");
        	$("#tabla_datos_similares").html(resp);    	   
        }
    });	
}

function Hidden(){
	document.getElementById('divRecuadroExt').style.visibility='hidden';
	document.getElementById('divProfileData').style.visibility='hidden';
	document.getElementById('divProfileDetail').style.visibility='hidden';
	document.getElementById('divboton').style.visibility='hidden';

}
function setMaterialesSimilar(f, cod, nombreMat,cantPre='1',divi='1'){	
	var numRegistro=f.materialActivo.value;
	$("#cantidad_presentacionboton"+numRegistro).css("color","#EC341B");
	if(divi==1){
      $("#cantidad_presentacionboton"+numRegistro).css("color","#969393");
	}
	document.getElementById('materiales'+numRegistro).value=cod;
	document.getElementById('cod_material'+numRegistro).innerHTML=nombreMat;
	document.getElementById('cantidad_presentacion'+numRegistro).value=cantPre;
	document.getElementById('divi'+numRegistro).value=divi;
	document.getElementById('cantidad_presentacionboton'+numRegistro).innerHTML=cantPre;
	document.getElementById("cantidad_unitaria"+numRegistro).focus();
	document.getElementById("cantidad_unitaria"+numRegistro).select();
    $("#modalProductosSimilares").modal("hide");
	actStock(numRegistro);	
}

function setMateriales(f, cod, nombreMat,cantPre='1',divi='1'){
	var numRegistro=f.materialActivo.value;
	$("#cantidad_presentacionboton"+numRegistro).css("color","#EC341B");
	if(divi==1){
      $("#cantidad_presentacionboton"+numRegistro).css("color","#969393");
	}	
	document.getElementById('materiales'+numRegistro).value=cod;
	document.getElementById('cod_material'+numRegistro).innerHTML=nombreMat;
	document.getElementById('cantidad_presentacion'+numRegistro).value=cantPre;
	document.getElementById('divi'+numRegistro).value=divi;
	document.getElementById('cantidad_presentacionboton'+numRegistro).innerHTML=cantPre;
	document.getElementById('divRecuadroExt').style.visibility='hidden';
	document.getElementById('divProfileData').style.visibility='hidden';
	document.getElementById('divProfileDetail').style.visibility='hidden';
	document.getElementById('divboton').style.visibility='hidden';
	
	document.getElementById("cantidad_unitaria"+numRegistro).focus();
	document.getElementById("cantidad_unitaria"+numRegistro).select();

	actStock(numRegistro);	
}
function verificarReceta(cod,numRegistro){
	ajax=nuevoAjax();
	ajax.open("GET","ajaxMaterialReceta.php?fila="+numRegistro+"&codigo="+cod,true);

	ajax.onreadystatechange=function(){
	   if (ajax.readyState==4) {
	   //	alert(ajax.responseText);
	   	if(parseInt(ajax.responseText)==0){
          if(!$("#receta_boton"+numRegistro).hasClass("d-none")){
            $("#receta_boton"+numRegistro).addClass("d-none");
          }
	   	}else{
	   	   if($("#receta_boton"+numRegistro).hasClass("d-none")){
            $("#receta_boton"+numRegistro).removeClass("d-none");
          }	
	   	}	   	
	   }
   }		
   ajax.send(null);
}
		
function precioNeto(fila){

	var precioCompra=document.getElementById('precio'+fila).value;
		
	var importeNeto=parseFloat(precioCompra)- (parseFloat(precioCompra)*0.13);

	if(importeNeto=="NaN"){
		importeNeto.value=0;
	}
	document.getElementById('neto'+fila).value=importeNeto;
}
function fun13(cadIdOrg,cadIdDes)
{   var num=document.getElementById(cadIdOrg).value;
    num=(100-13)*num/100;
    document.getElementById(cadIdDes).value=num;
}

num=0;
cantidad_items=0;
function ajaxPrecioItem(indice){
	var contenedor;
	contenedor=document.getElementById("idprecio"+indice);
	var codmat=document.getElementById("materiales"+indice).value;
	var tipoPrecio=document.getElementById("tipoPrecio"+indice).value;
	var cantidadUnitaria=document.getElementById("cantidad_unitaria"+indice).value;
	var fecha=document.getElementById("fecha").value;	
	ajax=nuevoAjax();
	ajax.open("GET", "ajaxPrecioItem.php?codmat="+codmat+"&indice="+indice+"&tipoPrecio="+tipoPrecio+"&fecha="+fecha+"&cantidad_unitaria="+cantidadUnitaria,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			var respuesta=ajax.responseText.split("#####");
			contenedor.innerHTML = respuesta[0];
            document.getElementById("descuentoProducto"+indice).value=respuesta[1];
            if($("#descuentoProducto"+indice).val()>0){
              $("#tipoPrecio"+indice).css("background","#C0392B");
            }else{
              $("#tipoPrecio"+indice).css("background","#85929E");
            }             
			calculaMontoMaterial(indice);			
		}
	}
	ajax.send(null);
}
function mas(obj) {
	if(num>=1000){
		alert("No puede registrar mas de 15 items en una nota.");
	}else{
		//aca validamos que el item este seleccionado antes de adicionar nueva fila de datos
		var banderaItems0=0;
		for(var j=1; j<=num; j++){
			if(document.getElementById('materiales'+j)!=null){
				if(document.getElementById('materiales'+j).value==0){
					banderaItems0=1;
				}
			}
		}
		//fin validacion
		console.log("bandera: "+banderaItems0);

		if(banderaItems0==0){
			num++;
			cantidad_items++;
			console.log("num: "+num);
			console.log("cantidadItems: "+cantidad_items);
			fi = document.getElementById('fiel');
			contenedor = document.createElement('div');
			contenedor.id = 'div'+num;  
			fi.type="style";
			fi.appendChild(contenedor);
			var div_material;
			div_material=document.getElementById("div"+num);	
			var cod_precio=document.getElementById("tipoPrecio").value;
			var fecha=document.getElementById("fecha").value;				
			ajax=nuevoAjax();
			ajax.open("GET","ajaxMaterialVentas.php?codigo="+num+"&cod_precio="+cod_precio+"&fecha="+fecha,true);

			ajax.onreadystatechange=function(){
				if (ajax.readyState==4) {
					div_material.innerHTML=ajax.responseText;
					$('.selectpicker').selectpicker('refresh');
					buscarMaterial(form1, num);
				}
			}		
			ajax.send(null);
		}

	}
	
}
		
function menos(numero) {
	cantidad_items--;
	console.log("TOTAL ITEMS: "+num);
	console.log("NUMERO A DISMINUIR: "+numero);
	if(numero==num){
		num=parseInt(num)-1;
 	}
	fi = document.getElementById('fiel');
	fi.removeChild(document.getElementById('div'+numero));
	totales();
}

function pressEnter(e, f){
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==13){
		document.getElementById('itemCodigoMaterial').focus();	
		listaMateriales(f);
		return false;
	}
}


	
	
function checkSubmit() {
    document.getElementById("btsubmit").value = "Enviando...";
    document.getElementById("btsubmit").disabled = true;
    document.getElementById("btsubmitPedido").value = "Enviando...";
    document.getElementById("btsubmitPedido").disabled = true;
    return true;
}

$(document).ready(function() {
  $("#guardarSalidaVenta").submit(function(e) {
      var mensaje="";
      if(parseFloat($("#efectivoRecibido").val())<parseFloat($("#totalFinal").val())){
        mensaje+="<p></p>";
        alert("El monto en efectivo NO debe ser menor al monto total");
        return false;
      }else{
      	document.getElementById("btsubmit").value = "Enviando...";
        document.getElementById("btsubmit").disabled = true;
        document.getElementById("btsubmitPedido").value = "Enviando...";
        document.getElementById("btsubmitPedido").disabled = true;
      }     
    });
});	
</script>
<?php
echo "</head><body onLoad='funcionInicio();'>";
require("conexionmysqli.inc");
require("estilos_almacenes.inc");
require("funciones.php");
?>
<script>
function validar(f, ventaDebajoCosto,pedido){
    if(pedido==1){
	  $("#pedido_realizado").val(pedido);
    }	
    var pedidoFormu=parseInt($("#pedido_realizado").val());
	//alert(ventaDebajoCosto);
	f.cantidad_material.value=num;
	var cantidadItems=num;
	var itemsStock0=0;
	for(var i=1; i<=cantidadItems; i++){
			if(document.getElementById("materiales"+i)!=null){
				if(document.getElementById("stock"+i).value==0){
					itemsStock0++;
				}		
			}
    }
    if(pedidoFormu==2){ 
    	//VALIDA SI SOLO SE AGREGAN STOCK EN 0 PARA YA NO FACTURAR (OPCION GUARDAR Y PEDIR)
    	cantidadItems=cantidadItems-itemsStock0;
    }
	console.log("numero de items: "+cantidadItems);
	var errores=0;
	if(cantidadItems>0){
		var validacionClientes=0;
		if(parseInt($("#validacion_clientes").val())!=0){
          if($("#cliente").val()==146||$("#cliente").val()==""){  //146 clientes varios
            validacionClientes=1;
          }
		}	
		if(validacionClientes==0){
          var item="";
		  var cantidad="";
		  var cantidadPres="";
		  var divi=0;
		  var stock="";
		  var descuento="";					
		 for(var i=1; i<=cantidadItems; i++){
			console.log("valor i: "+i);
			console.log("objeto materiales: "+document.getElementById("materiales"+i));
			if(document.getElementById("materiales"+i)!=null){
				item=parseFloat(document.getElementById("materiales"+i).value);
				cantidad=parseFloat(document.getElementById("cantidad_unitaria"+i).value);
				cantidadPres=parseFloat(document.getElementById("cantidad_presentacion"+i).value);
				divi=parseInt(document.getElementById("divi"+i).value);
				
				//VALIDACION DE VARIABLE DE STOCK QUE NO SE VALIDA
				stock=document.getElementById("stock"+i).value;
				if(stock=="-"){
					stock=10000;
				}else{
					stock=parseFloat(document.getElementById("stock"+i).value);
				}
				
				descuento=parseFloat(document.getElementById("descuentoProducto"+i).value);
				precioUnit=parseFloat(document.getElementById("precio_unitario"+i).value);				
				var costoUnit=parseFloat(document.getElementById("costoUnit"+i).value);
		
				console.log("materiales"+i+" valor: "+item);
				console.log("stock: "+stock+" cantidad: "+cantidad+ "precio: "+precioUnit);
                
                if(item==0){
					errores++;
					alert("Debe escoger un item en la fila "+i);
					$("#pedido_realizado").val(0);
					return(false);
				}
				if($("#efectivoRecibidoUnido").val()==0||$("#efectivoRecibidoUnido").val()==""){
					errores++;
					document.getElementById("efectivoRecibidoUnido").focus();
					document.getElementById("efectivoRecibidoUnido").select();
					alert("Debe registrar el monto recibido");

					$("#pedido_realizado").val(0);
					return(false);
				}
				//alert(costoUnit+" "+precioUnit);
				if(costoUnit>precioUnit && ventaDebajoCosto==0){
					errores++;
					alert('No puede registrar una venta a perdida!!!!');
					$("#pedido_realizado").val(0);
					return(false);
				}
				if(stock<cantidad&&pedidoFormu==0){
					errores++;
					document.getElementById("cantidad_unitaria"+i).focus();
					document.getElementById("cantidad_unitaria"+i).select();
					alert("No puede sacar cantidades mayores a las existencias. Fila "+i);					
					$("#pedido_realizado").val(0);
					return(false);
				}		
				if((cantidad<=0 || precioUnit<=0) || (Number.isNaN(cantidad)) || Number.isNaN(precioUnit)){
					errores++;
					alert("La cantidad y/o Precio no pueden estar vacios o ser <= 0.");
					$("#pedido_realizado").val(0);
					return(false);
				}

				if(divi==0&&cantidadPres>0&&(cantidad%cantidadPres)!=0){
					errores++;
					document.getElementById("cantidad_unitaria"+i).focus();
					document.getElementById("cantidad_unitaria"+i).select();
					alert("El item de la fila "+i+" no es divisible!, la cantidad unitaria debe ser multiple a la cantidad de presentación");					
					$("#pedido_realizado").val(0);
					return(false);
				}
			}
		  }
		  if(errores==0&&pedidoFormu==1){
		  	  guardarPedido(1);
              //guardarPedidoDesdeFacturacion(1);
              return false;
		  }else{
		  	if($("#tipoVenta").val()==2){
		  	  if($("#nro_tarjeta").val()!=""){
                if(!($("#monto_tarjeta").val()>0)){
                   alert("Debe Ingresar el monto de la Tarjeta");
					$("#pedido_realizado").val(0);
				   return(false);
                }
		  	  }else{
		  	  	alert("Debe Registrar los datos de la tarjeta");
					$("#pedido_realizado").val(0);
				   return(false);
		  	  }// fin nro de tarjeta		  	
		  	}
		  }
		}else{
		  alert("Debe registrar el Cliente.");
		  $("#pedido_realizado").val(0);
		  return(false);
		}		
	}else{
		if(pedidoFormu==2){
			location.href='navegadorPedidos.php';
		    return(false);
		}else{
			alert("El ingreso debe tener al menos 1 item.");
		}		
		$("#pedido_realizado").val(0);
		return(false);
	}
}
var tipoVentaGlobal=1;
function cambiarTipoVenta2(){
	if(tipoVentaGlobal==1){
      $("#tipo_venta2").val(2);
      $("#boton_tipoventa2").html("<i class='material-icons'>corporate_fare</i>");
      $("#boton_tipoventa2").attr("title","TIPO DE VENTA INSTITUCIONAL");
      $("#boton_tipoventa2").attr("class","btn btn-danger btn-sm btn-fab float-right");
      tipoVentaGlobal=2;
	}else{
      $("#tipo_venta2").val(1);
      tipoVentaGlobal=1;
      $("#boton_tipoventa2").html("<i class='material-icons'>point_of_sale</i>");
      $("#boton_tipoventa2").attr("title","TIPO DE VENTA CORRIENTE");
      $("#boton_tipoventa2").attr("class","btn btn-info btn-sm btn-fab float-right");
	}
  
}


function registrarNuevoCliente(){
	$("#nit").val($("#nitCliente").val());
	$("#nomcli").val($("#razonSocial").val());
	$("#modalNuevoCliente").modal("show");
}
function adicionarCliente() {
    var nomcli = $("#nomcli").val();
    var apcli = $("#apcli").val();
    var ci = $("#ci").val();
    var nit = $("#nit").val();
    var dir = $("#dir").val();
    var tel1 = $("#tel1").val();
    var mail = $("#mail").val();
    var area = $("#area").val();
    var fact = $("#fact").val();
    var edad = $("#edad").val();
    var genero = $("#genero").val();

  if(nomcli==""||ci==""){
    Swal.fire("Informativo!", "Debe llenar los campos obligatorios", "warning");
  }else{
    var parametros={"nomcli":nomcli,"nit":nit,"ci":ci,"dir":dir,"tel1":tel1,"mail":mail,"area":area,"fact":fact,"edad":edad,"apcli":apcli,"genero":genero,"dv":1};
    $.ajax({
        type: "GET",
        dataType: 'html',
        url: "programas/clientes/prgClienteAdicionar.php",
        data: parametros,
        success:  function (resp) { 
           var r=resp.split("#####");
           if(parseInt(r[1])>0){
           	  refrescarComboCliente(r[1]);                         
           }else{
           	  $("#modalNuevoCliente").modal("hide"); 
           	  Swal.fire("Error!", "Error al crear cliente", "error");
           }            
                            	   
        }
    });	
  }
}
function guardarRecetaVenta(){
	$("#nom_doctor").val("");
	$("#ape_doctor").val("");
	$("#dir_doctor").val("");
	$("#mat_doctor").val("");
	$("#n_ins_doctor").val("");
	$("#nomcli").val($("#razonSocial").val());
	actualizarTablaMedicos("apellidos");
	$("#modalRecetaVenta").modal("show");
}

function nuevaInstitucion(){
  var institucion=$("#ins_doctor").val();
  if(institucion==-2){
  	if($("#div_ins_doctor").hasClass("d-none")){
  		$("#div_ins_doctor").removeClass("d-none")
  	}
  }else{
  	if(!$("#div_ins_doctor").hasClass("d-none")){
  		$("#div_ins_doctor").addClass("d-none")
  	}
  }
}

function guardarMedicoReceta(){
	var nom_doctor=$("#nom_doctor").val();
	var ape_doctor=$("#ape_doctor").val();
	var dir_doctor=$("#dir_doctor").val();
	var mat_doctor=$("#mat_doctor").val();
	var n_ins_doctor=$("#n_ins_doctor").val();
	var ins_doctor=$("#ins_doctor").val();
	var esp_doctor=$("#esp_doctor").val();
	var esp_doctor2=$("#esp_doctor2").val();
	if(nom_doctor==""||ape_doctor==""){
       //alerta
	}else{
		if(ins_doctor==-2&&n_ins_doctor==""){
          //alerta
		}else{
			guardarMedicoRecetaAjax(nom_doctor,ape_doctor,dir_doctor,mat_doctor,n_ins_doctor,ins_doctor,esp_doctor,esp_doctor2);
		}
	}
}

function guardarMedicoRecetaAjax(nom_doctor,ape_doctor,dir_doctor,mat_doctor,n_ins_doctor,ins_doctor,esp_doctor,esp_doctor2){
	var parametros={nom_doctor:nom_doctor,ape_doctor:ape_doctor,dir_doctor:dir_doctor,mat_doctor:mat_doctor,n_ins_doctor:n_ins_doctor,ins_doctor:ins_doctor,esp_doctor:esp_doctor,esp_doctor2:esp_doctor2};
	$.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajaxNuevoMedico.php",
        data: parametros,
        success:  function (resp) {
        	$("#nom_doctor").val("");
	        $("#ape_doctor").val("");
	        $("#dir_doctor").val("");
	        $("#mat_doctor").val("");
	        $("#n_ins_doctor").val("");
        	if(parseInt(resp)==1){
               Swal.fire("Correcto!", "Se guardó el médico con éxito", "success");   
               actualizarTablaMedicos("apellidos");                 	   
        	}else{
               Swal.fire("Error!", "Contactar con el administrador", "error");   
        	}            
        }
    });	
}

function actualizarTablaMedicos(orden){
	var codigo=$("#cod_medico").val();
   var parametros={order_by:orden,cod_medico:codigo};
   $.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajaxListaMedicos.php",
        data: parametros,
        success:  function (resp) {
        	actualizarListaInstitucion();
        	$("#datos_medicos").html(resp);                 	   
        }
    });	
}
function actualizarListaInstitucion(){
   var parametros={cod:""};
   $.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajaxListaInstitucion.php",
        data: parametros,
        success:  function (resp) {
        	$("#ins_doctor").html(resp);   
        	$("#ins_doctor").selecpicker("refresh");                 	   
        }
    });	
}

function asignarMedicoVenta(codigo){
   $("#cod_medico").val(codigo);
   if(codigo>0){
  	 $("#boton_receta").attr("style","background:green");
   }else{
   	 $("#boton_receta").attr("style","background:#652BE9");
   }

   $("#modalRecetaVenta").modal("hide");
}
function refrescarComboCliente(cliente){
	var parametros={"cliente":cliente};
	$.ajax({
        type: "GET",
        dataType: 'html',
        url: "listaClientesActual.php",
        data: parametros,
        success:  function (resp) {
        	Swal.fire("Correcto!", "Se guardó el cliente con éxito", "success");   
           $("#cliente").html(resp);  
           $("#cliente").selectpicker("refresh");          
           $("#modalNuevoCliente").modal("hide");                  	   
        }
    });	
}

function mostrarRegistroConTarjeta(){
	$("#titulo_tarjeta").html("");
	if($("#nro_tarjeta").val()>0){
      $("#titulo_tarjeta").html("(REGISTRADO)");
	}
	$("#modalPagoTarjeta").modal("show");	
}
function verificarPagoTargeta(){
  var nro_tarjeta=$("#nro_tarjeta").val();
  if(nro_tarjeta!=""){
  	$("#boton_tarjeta").attr("style","background:green");
  }else{
  	$("#boton_tarjeta").attr("style","background:#96079D");
  }
}
</script>
<?php
if(!isset($fecha)||$fecha==""){   
	$fecha=date("d/m/Y");
}
$sqlCambioUsd="select valor from cotizaciondolar order by 1 desc limit 1";
$respUsd=mysqli_query($enlaceCon,$sqlCambioUsd);
$tipoCambio=1;
while($filaUSD=mysqli_fetch_array($respUsd)){
		$tipoCambio=$filaUSD[0];	
}
?><input type="hidden" id="tipo_cambio_dolar" value="<?=$tipoCambio?>"><?php
$usuarioVentas=$_COOKIE['global_usuario'];
$globalAgencia=$_COOKIE['global_agencia'];
$globalAlmacen=$_COOKIE['global_almacen'];
$cuidadDefecto=$globalAgencia;
//SACAMOS LA CONFIGURACION PARA EL DOCUMENTO POR DEFECTO
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=1";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$tipoDocDefault=mysqli_result($respConf,0,0);

//SACAMOS LA CONFIGURACION PARA EL CLIENTE POR DEFECTO
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=2";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$clienteDefault=mysqli_result($respConf,0,0);

//SACAMOS LA CONFIGURACION PARA CONOCER SI LA FACTURACION ESTA ACTIVADA
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=3";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$facturacionActivada=mysqli_result($respConf,0,0);

//SACAMOS LA CONFIGURACION PARA LA ANULACION
$anulacionCodigo=1;
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=6";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$anulacionCodigo=mysqli_result($respConf,0,0);

//SACAMOS LA CONFIGURACION PARA CONOCER SI PERMITIMOS VENDER POR DEBAJO DEL COSTO
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=5";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$ventaDebajoCosto=mysqli_result($respConf,0,0);
$ciudad=$_COOKIE['global_agencia'];
$codigoDescuentoGeneral=0;
$porcentajeDescuentoReal=0;
$porcentajeDescuentoRealNombre="Descuento";

include("datosUsuario.php");

$cadComboBancos = "";
$consulta="SELECT c.codigo, c.nombre FROM bancos AS c WHERE estado = 1 ORDER BY c.nombre ASC";
$rs=mysqli_query($enlaceCon,$consulta);
while($reg=mysqli_fetch_array($rs))
   {$codBanco = $reg["codigo"];
    $nomBanco = $reg["nombre"];
    $cadComboBancos=$cadComboBancos."<option value='$codBanco'>$nomBanco</option>";
   }



$cadComboCiudad = "";
$consulta="SELECT c.cod_ciudad, c.descripcion FROM ciudades AS c WHERE 1 = 1 ORDER BY c.descripcion ASC";
$rs=mysqli_query($enlaceCon,$consulta);
while($reg=mysqli_fetch_array($rs))
   {$codCiudad = $reg["cod_ciudad"];
    $nomCiudad = $reg["descripcion"];
    $cadComboCiudad=$cadComboCiudad."<option value='$codCiudad'>$nomCiudad</option>";
   }

   $cadComboEdad = "";
$consultaEdad="SELECT c.codigo,c.nombre, c.abreviatura FROM tipos_edades AS c WHERE c.estado = 1 ORDER BY 1";
$rs=mysqli_query($enlaceCon,$consultaEdad);
while($reg=mysqli_fetch_array($rs))
   {$codigoEdad = $reg["codigo"];
    $nomEdad = $reg["abreviatura"];
    $desEdad = $reg["nombre"];
    $cadComboEdad=$cadComboEdad."<option value='$codigoEdad'>$nomEdad ($desEdad)</option>";
   }

$cadTipoPrecio="";
$consulta1="select t.`codigo`, t.`nombre` from `tipos_precio` t";
$rs1=mysqli_query($enlaceCon,$consulta1);
while($reg1=mysqli_fetch_array($rs1))
   {$codTipo = $reg1["codigo"];
    $nomTipo = $reg1["nombre"];
    $cadTipoPrecio=$cadTipoPrecio."<option value='$codTipo'>$nomTipo</option>";
   }

$cadComboGenero="";
$consult="select t.`cod_genero`, t.`descripcion` from `generos` t where cod_estadoreferencial=1";
$rs1=mysqli_query($enlaceCon,$consult);
while($reg1=mysqli_fetch_array($rs1))
   {$codTipo = $reg1["cod_genero"];
    $nomTipo = $reg1["descripcion"];
    $cadComboGenero=$cadComboGenero."<option value='$codTipo'>$nomTipo</option>";
   }


$cadComboInstitucion = "";
$consulta="SELECT c.codigo, c.nombre FROM instituciones c WHERE estado = 1 ORDER BY c.codigo ASC";
$rs=mysqli_query($enlaceCon,$consulta);
while($reg=mysqli_fetch_array($rs))
   {$codInstitucion = $reg["codigo"];
    $nomInstitucion = $reg["nombre"];
    $cadComboInstitucion=$cadComboInstitucion."<option value='$codInstitucion'>$nomInstitucion</option>";
   }
$cadComboEspecialidades = "";
$consulta="SELECT c.codigo, c.nombre FROM especialidades c WHERE estado = 1 ORDER BY c.codigo ASC";
$rs=mysqli_query($enlaceCon,$consulta);
while($reg=mysqli_fetch_array($rs))
   {$codEsp = $reg["codigo"];
    $nomEsp = $reg["nombre"];
    $cadComboEspecialidades=$cadComboEspecialidades."<option value='$codEsp'>$nomEsp</option>";
   }

?>
<form action='guardarSalidaMaterial.php' method='POST' name='form1' id="guardarSalidaVenta">
	<input type="hidden" id="pedido_realizado" value="0">
	<input type="hidden" id="cod_medico" name="cod_medico" value="0">
	<input type="hidden" id="validacion_clientes" name="validacion_clientes" value="<?=obtenerValorConfiguracion(11)?>">
<table class='' width='100%' style='width:100%'>
<tr align='center' class="text-white header" style="color:#fff;background:#581845; font-size: 16px;">
	<th colspan="9"><img src="imagenes/farmacias_bolivia1.gif" height="30px"></img></th>
</tr>
<tr align='left' class="text-white header">
	<th colspan="2" style="color:#fff;background:#581845; font-size: 16px;">[<?php echo $fechaSistemaSesion?>][<b id="hora_sistema"><?php echo $horaSistemaSesion;?></b>]</th>
	<th colspan="4" style="color:#fff;background:#581845; font-size: 16px;"><label class="text-white"><b>REGISTRO DE VENTAS MANUAL</b></label></th>
	<th colspan="4" style="color:#fff;background:#581845; font-size: 16px;">[<?php echo $nombreUsuarioSesion?>][<?php echo $nombreAlmacenSesion;?>]</th>
</tr>
<tr class="bg-info text-white" align='center' style="color:#fff;background:#16B490 !important; font-size: 16px;">
<th>Tipo de Doc.</th>
<th>Nro.Factura</th>
<th>Fecha</th>
<th class='d-none'>Precio</th>
<th>Tipo Pago</th>
<th>NIT</th>
<th>Nombre/RazonSocial</th>
<th>Observaciones</th>
<th>Cliente</th>
<th>-</th>
</tr>
<tr>
<input type="hidden" name="tipoSalida" id="tipoSalida" value="1001">
<td>
	<?php
		
		if($facturacionActivada==1){
			$sql="select codigo, nombre, abreviatura from tipos_docs where codigo in (4) order by 2 desc";
		}else{
			$sql="select codigo, nombre, abreviatura from tipos_docs where codigo in (2) order by 2 desc";
		}
		$resp=mysqli_query($enlaceCon,$sql);

		echo "<select class='selectpicker form-control' data-style='btn-info' name='tipoDoc' id='tipoDoc' required>";
		while($dat=mysqli_fetch_array($resp)){
			$codigo=$dat[0];
			$nombre=$dat[1];
			echo "<option value='$codigo'>$nombre</option>";
		}
		echo "</select>";
		?>
</td>
<td align='center'>
	<div id='divNroDoc'>
		<?php
		$vectorNroCorrelativo=numeroCorrelativo(4);
        $nroCorrelativo=$vectorNroCorrelativo[0];
        $banderaErrorFacturacion=$vectorNroCorrelativo[1];

		?>
		<?php
          if($banderaErrorFacturacion==1){
          	?><input type='number' class='form-control' value='<?php echo $nroCorrelativo?>' id='nro_correlativo' name='nro_correlativo' readonly><span class="text-danger"><?=$nroCorrelativo?></span><?php
          }else{
          	?><input type='number' class='form-control' value='<?php echo $nroCorrelativo?>' id='nro_correlativo' name='nro_correlativo'><?php
          }
		?>		
	</div>
</td>

<td align='center'>
	<input type='text' class='form-control' value='<?php echo $fecha?>' id='fecha' size='10' name='fecha' readonly>	
</td>


<td class='d-none'>
	<div id='divTipoPrecio'>	
<?php
			$sql1="select codigo, nombre from tipos_precio where estado=1 order by 1";
			$resp1=mysqli_query($enlaceCon,$sql1);
			echo "<select name='tipoPrecio' class='selectpicker form-control' data-style='btn-info' id='tipoPrecio'>";
			while($dat=mysqli_fetch_array($resp1)){
				$codigo=$dat[0];
				$nombre=$dat[1];
				echo "<option value='$codigo'>$nombre</option>";
			}
			echo "</select>";
			?>
	</div>
</td>

<td>
	<div id='divTipoVenta'>
		<?php
			$sql1="select cod_tipopago, nombre_tipopago from tipos_pago order by 1";
			$resp1=mysqli_query($enlaceCon,$sql1);
			echo "<select name='tipoVenta' class='selectpicker form-control' id='tipoVenta' data-style='btn-info'>";
			while($dat=mysqli_fetch_array($resp1)){
				$codigo=$dat[0];
				$nombre=$dat[1];
				echo "<option value='$codigo'>$nombre</option>";
			}
			echo "</select>";
			?>

	</div>
</td>


<?php
if($tipoDocDefault==2){
	$razonSocialDefault="-";
	$nitDefault="0";
}else{
	$razonSocialDefault="";
	$nitDefault="";
}

$tipoVentas2=1;
//$iconVentas2="corporate_fare";
$iconVentas2="point_of_sale";
?>

	
	<td>
		<div id='divNIT'>
			<input type='number' value='<?php echo $nitDefault; ?>' name='nitCliente' id='nitCliente'  onChange='ajaxRazonSocial(this.form);' class="form-control" required placeholder="Ingrese el NIT">
		</div>
	</td>
	
	<td>
		<div id='divRazonSocial'>
			<input type='text' name='razonSocial' id='razonSocial' value='<?php echo $razonSocialDefault; ?>' class="form-control" required placeholder="Ingrese la razón social">
		</div>
	</td>

	<td align='center'>
		<input type='text' class="form-control" id='observaciones' name='observaciones' value='' placeholder="Ingrese una observación">
	</td>
	<td align='center' id='divCliente'>			
	<select name='cliente' class='selectpicker form-control' data-live-search="true" id='cliente' onChange='ajaxTipoPrecio(form1);' required>
		<option value=''>----</option>
<?php
$sql2="select c.`cod_cliente`, c.nombre_cliente,c.paterno from clientes c order by 2";
$resp2=mysqli_query($enlaceCon,$sql2);

while($dat2=mysqli_fetch_array($resp2)){
   $codCliente=$dat2[0];
	$nombreCliente=$dat2[1]." ".$dat2[2];
	if($codCliente==$clienteDefault){
?>		
	<option value='<?php echo $codCliente?>' selected><?php echo $nombreCliente?></option>
<?php			
	}else{
?>		
	<option value='<?php echo $codCliente?>'><?php echo $nombreCliente?></option>
<?php			
	}

}
?>
	</select>
	<!--<input type="hidden" name="tipoPrecio" value="1">-->
</td>
<td><a href="#" title="Registrar Nuevo Cliente" onclick="registrarNuevoCliente(); return false;" class="btn btn-warning btn-round btn-sm text-white">+</a>
	<a href="#" onclick="guardarPedido(0)"
	class="btn btn-danger btn-sm btn-fab float-right" style="background:#900C3F;color:#fff;" title="GUARDAR VENTA PERDIDA"><i class="material-icons">search_off</i></a>
<a href="#" onclick="cambiarTipoVenta2()"
	class="btn btn-info btn-sm btn-fab float-right" title="TIPO DE VENTA CORRIENTE" id="boton_tipoventa2"><i class="material-icons"><?=$iconVentas2?></i></a>
	<a href="#" onclick="guardarRecetaVenta()"
	class="btn btn-info btn-sm btn-fab float-right" style="background: #652BE9;color:#fff;" title="REGISTRAR RECETA" id="boton_receta"><i class="material-icons">medical_services</i></a>
</td>
</tr>

</table>
<br>
<input type="hidden" id="tipo_venta2" name="tipo_venta2" value="<?=$tipoVentas2?>">
<input type="hidden" id="ventas_codigo"><!--para validar la funcion mas desde ventas-->
<div class="codigo-barras">
               <input class="btn btn-info" style="margin-top: 0px;" type="button" value="Adicionar Item (+)" onclick="mas(this)" accesskey="a"/><input type="text" class="form-codigo-barras" id="input_codigo_barras" placeholder="Ingrese el código de barras." autofocus autocomplete="off">
</div>
<fieldset id="fiel" style="width:100%;border:0;">
	<table id="data0" class='table table-sm' width='100%' style='width:100%'>
	<tr>
		<td align="center" colspan="8" class="text-muted">
			<b>Detalle de la Venta    </b>
		</td>
	</tr>
    <tr align="center" class="bg-info text-white" style='background:#16B490 !important;'>
		<td width="15%" align="left">Cant. Pres / Opciones</td>
		<td width="25%">Material</td>
		<td width="10%" align="center">Stock</td>
		<td width="10%" align="left">Cantidad</td>
		<td width="10%" align="left">Precio </td>
		<td width="15%" align="left">Desc.</td>
		<td width="10%" align="left">Monto</td>
		<td width="10%">&nbsp;</td>
	</tr>
	</table>
</fieldset>



<div id="divRecuadroExt" style="background-color:#666; position:absolute; width:1200px; height: 400px; top:30px; left:50px; visibility: hidden; opacity: .70; -moz-opacity: .70; filter:alpha(opacity=70); -webkit-border-radius: 20px; -moz-border-radius: 20px; z-index:2; overflow: auto;">
</div>

<div id="divboton" style="position: absolute; top:20px; left:1210px;visibility:hidden; text-align:center; z-index:3">
	<a href="javascript:Hidden();"><img src="imagenes/cerrar4.png" height="45px" width="45px"></a>
</div>

<div id="divProfileData" style="background-color:#FFF; width:1150px; height:350px; position:absolute; top:50px; left:70px; -webkit-border-radius: 20px; 	-moz-border-radius: 20px; visibility: hidden; z-index:2; overflow: auto;">
  	<div id="divProfileDetail" style="visibility:hidden; text-align:center">
		<table align='center'>
			<tr><th>Linea</th><th>Forma F.</th><th>Accion T.</th></tr>
			<tr>
			<td><select class="textogranderojo" name='itemTipoMaterial' style="width:300px">
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
			<td><select class="textogranderojo" name='itemFormaMaterial' style="width:300px">
			<?php
			$sqlTipo="select pl.cod_forma_far,pl.nombre_forma_far from formas_farmaceuticas pl 
			where pl.estado=1 order by 2;";
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
			<td><select class="textogranderojo" name='itemAccionMaterial' style="width:300px">
			<?php
			$sqlTipo="select pl.cod_accionterapeutica,pl.nombre_accionterapeutica from acciones_terapeuticas pl 
			where pl.estado=1 order by 2;";
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
			<tr><th>Principio Act.</th><th>Codigo / Producto</th><th>&nbsp;</th></tr>
	     <tr>		
			<td><select class="textogranderojo" name='itemPrincipioMaterial' style="width:300px">
			<?php
			$sqlTipo="select pl.codigo,pl.nombre from principios_activos pl 
			where pl.estado=1 order by 2;";
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
				<div class="row">
					<div class="col-sm-3"><input type='number' placeholder='--' name='itemCodigoMaterial' id='itemCodigoMaterial' class="textogranderojo" onkeypress="return pressEnter(event, this.form);"></div>
					<div class="col-sm-9"><input type='text' placeholder='Descripción' name='itemNombreMaterial' id='itemNombreMaterial' class="textogranderojo" onkeypress="return pressEnter(event, this.form);"></div>				   
				</div>
				
			</td>
			<td align="center">
				<input type='button' class='btn btn-info' value='Buscar' onClick="listaMateriales(this.form)">
			</td>
 			</tr>
			
		</table>
		<div id="divListaMateriales">
		</div>
	
	</div>
</div>
<div style="height:200px;"></div>

<div class="pie-div">
	<!--<div class='float-right' style="padding-right:15px;"><a href='#' class='boton-plomo' style="width:10px !important;height:10px !important;font-size:10px !important;" id="boton_nota_remision" onclick="cambiarNotaRemision()">NR</a></div>-->
	<table class="pie-montos">
      <tr>
        <td>
	      <table id='' width='100%' border="0">
	      	<tr>
			<td align='right' width='90%' style="color:#777B77;font-size:12px;"></td><td align='center'><b style="font-size:35px;color:#0691CD;">Bs.</b></td>
		</tr>
         
		<tr>
			<td align='right' width='90%' style="font-weight:bold;font-size:12px;color:red;">Monto Final</td><td><input type='number' name='totalFinal' id='totalFinal' readonly style="background:#0691CD;height:27px;font-size:22px;width:100%;color:#fff;"></td>
		</tr>
		<tr>
			<td align='right' width='90%' style="color:#777B77;font-size:12px;">Monto Recibido</td><td><input type='number' style="background:#B0B4B3" name='efectivoRecibido' id='efectivoRecibido' readonly step="any" onChange='aplicarCambioEfectivo(form1);' onkeyup='aplicarCambioEfectivo(form1);' onkeydown='aplicarCambioEfectivo(form1);'></td>
		</tr>
		<tr>
			<td align='right' width='90%' style="color:#777B77;font-size:12px;">Cambio</td><td><input type='number' name='cambioEfectivo' id='cambioEfectivo' readonly style="background:#7BCDF0;height:25px;font-size:18px;width:100%;"></td>
		</tr>
	</table>
      
        </td>
        <td>
        	<table id='' width='100%' border="0">
		<tr>
			<td align='right' width='90%' style="color:#777B77;font-size:12px;"></td><td align='center'><b style="font-size:35px;color:#0691CD;">-</b></td>
		</tr>

		<tr>
			<td align='right' width='90%' style="color:#777B77;font-size:12px;">Monto Venta</td><td><input type='number' name='totalVenta' id='totalVenta' readonly style="background:#B0B4B3"></td>
		</tr>
		<tr>
			<td align='right' width='90%' id='porcentajeDescuentoRealNombre' style="font-weight:bold;color:red;font-size:12px;"><?=$porcentajeDescuentoRealNombre?></td><td><input type='number' name='descuentoVenta' id='descuentoVenta' onChange='aplicarDescuento(form1);' style="height:27px;font-size:22px;width:100%;color:red;" onkeyup='aplicarDescuento(form1);' onkeydown='aplicarDescuento(form1);' value="0" readonly step='any' required></td>
		</tr>
		<tr>
			<td align='right' width='90%' id='porcentajeDescuentoRealNombre2' style="font-weight:bold;color:red;font-size:12px;"><?=$porcentajeDescuentoRealNombre?> %</td><td><input type='number' name='descuentoVentaPorcentaje' id='descuentoVentaPorcentaje' style="height:27px;font-size:22px;width:100%;color:red;" onChange='aplicarDescuentoPorcentaje(form1);' onkeyup='aplicarDescuentoPorcentaje(form1);' onkeydown='aplicarDescuentoPorcentaje(form1);' value="<?=$porcentajeDescuentoReal?>" readonly step='any'></td>
		</tr>

	</table>
       
	<table id='' width='100%' border="0" style="display:none">
		<tr>
			<td align='right' width='90%' style="color:#777B77;font-size:12px;"></td><td align='center'><b style="font-size:35px;color:#189B22;">$ USD</b></td>
		</tr>
		<tr>
			<td align='right' width='90%' style="color:#777B77;font-size:12px;">Monto Venta</td><td><input type='number' name='totalVentaUSD' id='totalVentaUSD' readonly style="background:#B0B4B3"></td>
		</tr>
		<tr>
			<td align='right' width='90%' style="font-weight:bold;color:red;font-size:12px;">Descuento</td><td><input type='number' name='descuentoVentaUSD' id='descuentoVentaUSD' style="height:27px;font-size:22px;width:100%;color:red;" onChange='aplicarDescuentoUSD(form1);' onkeyup='aplicarDescuentoUSD(form1);' onkeydown='aplicarDescuentoUSD(form1);' value="0" step='any' required></td>
		</tr>
		<tr>
			<td align='right' width='90%' style="font-weight:bold;color:red;font-size:12px;">Descuento %</td><td><input type='number' name='descuentoVentaUSDPorcentaje' id='descuentoVentaUSDPorcentaje' style="height:27px;font-size:22px;width:100%;color:red;" onChange='aplicarDescuentoUSDPorcentaje(form1);' onkeyup='aplicarDescuentoUSDPorcentaje(form1);' onkeydown='aplicarDescuentoUSDPorcentaje(form1);' value="0" step='any'></td>
		</tr>
		<tr>
			<td align='right' width='90%' style="font-weight:bold;color:red;font-size:12px;">Monto Final</td><td><input type='number' name='totalFinalUSD' id='totalFinalUSD' readonly style="background:#189B22;height:27px;font-size:22px;width:100%;color:#fff;"> </td>
		</tr>
		<tr>
			<td align='right' width='90%' style="color:#777B77;font-size:12px;">Monto Recibido</td><td><input type='number' name='efectivoRecibidoUSD' id='efectivoRecibidoUSD' style="background:#B0B4B3" step="any" readonly onChange='aplicarCambioEfectivoUSD(form1);' onkeyup='aplicarCambioEfectivoUSD(form1);' onkeydown='aplicarCambioEfectivoUSD(form1);'></td>
		</tr>
		<tr>
			<td align='right' width='90%' style="color:#777B77;font-size:12px;">Cambio</td><td><input type='number' name='cambioEfectivoUSD' id='cambioEfectivoUSD' readonly style="background:#4EC156;height:25px;font-size:18px;width:100%;"></td>
		</tr>
	</table>
        </td>
      </tr>
	</table>


<?php
//<button type='submit' onClick='return validar(this.form, $ventaDebajoCosto,1)' id='btsubmitPedido' name='btsubmitPedido' class='btn btn-default float-right'><i class='material-icons'>save</i> Guardar Venta y Pedido</button>
if($banderaErrorFacturacion==0){
	echo "<div class=''>
	        <div class='btn-group' role='group' aria-label='Grupo Venta' style='position:fixed;margin-top:0 !important;'>
               <button type='submit' class='btn btn-warning' id='btsubmit' name='btsubmit' onClick='return validar(this.form, $ventaDebajoCosto,0)'>Guardar Venta</button>
			   <button type='button' class='btn btn-danger' onClick='location.href=\"navegador_ingresomateriales.php\"';>Cancelar</button>
			   
            </div>	       
            <h2 style='font-size:11px;color:#9EA09E; display:none;'>TIPO DE CAMBIO $ : <b style='color:#189B22;'> ".$tipoCambio." Bs.</b></h2>
            
            <table style='width:330px;padding:0 !important;margin:0 !important;bottom:25px;position:fixed;left:100px;'>
            <tr>
               <td style='display:none;font-size:12px;color:#456860;' colspan='2'>Total precio sin descuento = <label id='total_precio_sin_descuento'>0.00</label> Bs.</td>
             </tr>
             <tr>
               <td style='display:none;font-size:12px;color:#0691CD;' colspan='2'><p>&nbsp;</p></td>
             </tr>
            <tr>
               <td style='font-size:12px;color:#0691CD; font-weight:bold;'>MONTO RECIBIDO Bs.</td>
               <td style='font-size:12px;color:#189B22; font-weight:bold; display:none;'>EFECTIVO $ USD</td>
             </tr>
             <tr>
               <td><input type='number' name='efectivoRecibidoUnido' onChange='aplicarMontoCombinadoEfectivo(form1);' onkeyup='aplicarMontoCombinadoEfectivo(form1);' onkeydown='aplicarMontoCombinadoEfectivo(form1);' id='efectivoRecibidoUnido' style='height:30px;font-size:18px;width:100%;background:#A5F9EA !important;'  class='form-control' step='any' value='0' required></td>
               <td><a href='#' class='btn btn-default btn-sm btn-fab' style='background:#96079D' onclick='mostrarRegistroConTarjeta(); return false;' id='boton_tarjeta'><i class='material-icons'>credit_card</i></a><input type='number' name='efectivoRecibidoUnidoUSD' onChange='aplicarMontoCombinadoEfectivo(form1);' onkeyup='aplicarMontoCombinadoEfectivo(form1);' onkeydown='aplicarMontoCombinadoEfectivo(form1);' id='efectivoRecibidoUnidoUSD' style='height:25px;font-size:18px;width:100%;display:none;' step='any'></td>
             </tr>
            </table>

			";
	echo "</div>";	
}else{
	echo "";
}


?>

</div>

<input type='hidden' name='materialActivo' id='materialActivo' value="0">
<input type='hidden' id="cantidad_material" name='cantidad_material' value="0">}
<input type='hidden' name='codigoDescuentoGeneral' id="codigoDescuentoGeneral" value="<?=$codigoDescuentoGeneral?>">




<!-- small modal -->
<div class="modal fade modal-primary" id="modalPagoTarjeta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content card">
               <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon" style="background: #96079D;color:#fff;">
                    <i class="material-icons">credit_card</i>
                  </div>
                  <h4 class="card-title text-dark font-weight-bold">Pago con Tarjeta <small id="titulo_tarjeta"></small></h4>
                  <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true" style="position:absolute;top:0px;right:0;">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <div class="card-body">
<div class="row">
	<div class="col-sm-12">
		         <div class="row">
                  <label class="col-sm-3 col-form-label">Banco</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <select class="selectpicker form-control" name="banco_tarjeta" id="banco_tarjeta" data-style="btn btn-success" data-live-search="true">                      	
                          <?php echo "$cadComboBancos"; ?>
                          <option value="0">Otro</option>
                       </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">Numero <br>Tarjeta</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" type="text" style="background: #D7B3D8;" id="nro_tarjeta" name="nro_tarjeta" value="" onkeydown="verificarPagoTargeta()" onkeyup="verificarPagoTargeta()" onkeypress="verificarPagoTargeta()" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">Monto <br>Tarjeta</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" type="number" style="background: #A5F9EA;" id="monto_tarjeta" name="monto_tarjeta" value=""/>
                    </div>
                  </div>
                </div>                
                <br><br>
       </div>
</div>                      
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->





</form>



<!-- small modal -->
<div class="modal fade modal-primary" id="modalObservacionPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content card">
               <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon" style="background:#900C3F;color:#fff;">
                    <i class="material-icons">search_off</i>
                  </div>
                  <h4 class="card-title text-dark font-weight-bold">Registrar Como Venta Perdida</h4>
                  <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true" style="position:absolute;top:0px;right:0;">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <div class="card-body">
                	<input type="hidden" name="modo_pedido" id="modo_pedido" value="0">
                      <div class="row">
                          <label class="col-sm-2 col-form-label">Motivo</label>
                           <div class="col-sm-10">                     
                             <div class="form-group">
                               <select class="selectpicker form-control" name="modal_motivo" id="modal_motivo" data-style="btn btn-warning">
                                    <option selected="selected" value="0">OBSERVACIÓN ESPECÍFICA</option>
                                    <?php 
                                     $sqlObs="SELECT codigo,descripcion FROM observaciones_clase where cod_objeto=1 and cod_estadoreferencial=1 order by 1 desc";
                                     $resp=mysqli_query($enlaceCon,$sqlObs);
                                     while($filaObs=mysqli_fetch_array($resp)){
                                     		$codigo=$filaObs[0];
                                     		$nombre=$filaObs[1];	
                                     		 ?><option value="<?=$codigo;?>"><?=$nombre?></option><?php 
                                     }
                                    ?>
                                  </select>
                             </div>
                           </div>        
                      </div>
                      <div class="row">
                          <label class="col-sm-2 col-form-label">Observacion</label>
                           <div class="col-sm-10">                     
                             <div class="form-group">
                               <textarea class="form-control" id="modal_observacion" name="modal_observacion"></textarea>
                             </div>
                           </div>        
                      </div>
                      <br><br>
                      <div class="float-right">
                        <button class="btn btn-default" onclick="alerts.showSwal('mensaje-guardar-pedido','')">Guardar Como Venta Perdida</button>
                      </div> 
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->


<!-- small modal -->
<div class="modal fade modal-primary" id="modalProductosCercanos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content card">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">place</i>
                  </div>
                  <h4 class="card-title text-primary font-weight-bold">Stock de Productos en Sucursales</h4>
                  <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true" style="position:absolute;top:0px;right:0;">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <div class="card-body">
                  <table class="table table-sm table-bordered" id='tablaPrincipalGeneralQUITAR'>
                    <thead>
                      <tr style='background: #ADADAD;color:#000;'>
                      <th>#</th>
                      <th>Producto</th>
                      <th>Sucursal</th>
                      <th width="45%">Dirección</th>
                      <th>Stock</th>
                      </tr>
                    </thead>
                    <tbody id="tabla_datos">
                      
                    </tbody>
                  </table>
                  <br><br>
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->

<!-- small modal -->
<div class="modal fade modal-primary" id="modalProductosSimilares" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content card">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">device_hub</i>
                  </div>
                  <h4 class="card-title text-success font-weight-bold">Productos Similares</h4>
                   <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true" style="position:absolute;top:0px;right:0;">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <div class="card-body">
                  <table class="table table-sm table-bordered">
                    <thead>
                      <tr style='background: #ADADAD;color:#000;'>
                      <th>#</th>
                      <th>Proveedor</th>
                      <th>Linea</th>
                      <th width="45%">Producto</th>
                      <th>Principio Activo</th>
                      <th>Stock</th>
                      <th>Precio</th>
                      <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody id="tabla_datos_similares">
                      
                    </tbody>
                  </table>
                  <br><br>
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->


<!-- small modal -->
<div class="modal fade modal-primary" id="modalNuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content card">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">add</i>
                  </div>
                  <h4 class="card-title text-dark font-weight-bold">Nuevo Cliente</h4>
                   <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true" style="position:absolute;top:0px;right:0;">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <div class="card-body">

                <div class="row">
                  <label class="col-sm-2 col-form-label">Nombre (*)</label>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <input class="form-control" type="text" id="nomcli" required value="<?php echo "$nomCliente"; ?>"/>
                    </div>
                  </div>
                  <label class="col-sm-1 col-form-label">Apellidos</label>
                  <div class="col-sm-5">
                    <div class="form-group">
                      <input class="form-control" type="text" id="apcli" value="<?php echo "$apCliente"; ?>" required/>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <label class="col-sm-2 col-form-label">CI (*)</label>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <input class="form-control" type="text" id="ci" value="<?php echo "$ciCliente"; ?>"required/>
                    </div>
                  </div>
                  <label class="col-sm-1 col-form-label">NIT</label>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <input class="form-control" type="text" id="nit" value="<?php echo "$nitCliente"; ?>" required/>
                    </div>
                  </div>
                  <label class="col-sm-1 col-form-label">Teléfono</label>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input class="form-control" type="text" id="tel1" value="<?php echo "$telefono1"; ?>" required/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Dirección</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" type="text" id="dir" value="<?php echo "$dirCliente"; ?>" required/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" type="email" id="mail" value="<?php echo "$email"; ?>" required/>
                    </div>
                  </div>
                  <label class="col-sm-1 col-form-label">Factura</label>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input class="form-control" type="text" id="fact" value="<?php echo "$nomFactura"; ?>" required/>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-sm-2 col-form-label">Género</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <select class="selectpicker form-control" name="genero"id="genero" data-style="btn btn-primary" data-live-search="true" required>
                           <?php echo "$cadComboGenero"; ?>
                       </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Edad</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <select class="selectpicker form-control" name="edad"id="edad" data-style="btn btn-warning" data-live-search="true" required>
                          <?php echo "$cadComboEdad"; ?>
                       </select>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="area" id="area" value="<?=$cuidadDefecto?>">           

                </div>
                <div  class="card-footer">
                   <div class="">
                      <input class="btn btn-success" type="button" value="Guardar" onclick="javascript:adicionarCliente();" />
                       <input class="btn btn-danger" type="button" value="Cancelar" data-dismiss="modal" aria-hidden="true" />
                   </div>
                 </div> 
    </div>
  </div>
</div>  
<!--    end small modal -->
<!-- small modal -->
<div class="modal fade modal-primary" id="modalRecetaVenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content card">
               <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon" style="background: #652BE9;color:#fff;">
                    <i class="material-icons">medical_services</i>
                  </div>
                  <h4 class="card-title text-dark font-weight-bold">Datos del Médico</h4>
                  <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true" style="position:absolute;top:0px;right:0;">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <div class="card-body">
<div class="row">
	<div class="col-sm-6">
                <div class="row">
                  <label class="col-sm-2 col-form-label">Nombre (*)</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <input class="form-control" type="text" style="background: #A5F9EA;" id="nom_doctor" required value=""/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Apellidos (*)</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <input class="form-control" type="text" style="background: #A5F9EA;" id="ape_doctor" value="" required/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Dirección</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <input class="form-control" type="text" style="background: #A5F9EA;" id="dir_doctor" value="" required/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Matricula</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <input class="form-control" type="text" style="background: #A5F9EA;" id="mat_doctor" value="" required/>
                    </div>
                  </div>
                </div>
                <div class="row d-none" id="div_ins_doctor">
                  <label class="col-sm-2 col-form-label">Nombre <br>Institución (*)</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <input class="form-control" type="text" style="background: #A5F9EA;" id="n_ins_doctor" id="n_ins_doctor" value="" required/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Institución</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <select class="selectpicker form-control" name="ins_doctor" id="ins_doctor" data-style="btn btn-primary" data-live-search="true" onchange="nuevaInstitucion();" required>
                           <?php echo "$cadComboInstitucion"; ?>
                       </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Especialidad</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <select class="selectpicker form-control" name="esp_doctor"id="esp_doctor" data-style="btn btn-info" data-live-search="true" required>
                           <?php echo "$cadComboEspecialidades"; ?>
                       </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">2da Esp.</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <select class="selectpicker form-control" name="esp_doctor2"id="esp_doctor2" data-style="btn btn-info" data-live-search="true" required>
                      	<option value="0">Ninguna</option>
                          <?php echo "$cadComboEspecialidades"; ?>
                       </select>
                    </div>
                  </div>
                </div>
                <br>
                <div class="float-left">
                        <button class="btn btn-default" onclick="guardarMedicoReceta();">Guardar Nuevo</button>
                </div>                 
                <br><br>
       </div>
	   <div class="col-sm-6">       
                   <table class="table table-bordered table-condensed">
                   	  <thead>
                   	  	<tr class="" style="background: #652BE9;color:#fff;"><th width="60%">Nombre</th><th>Matricula</th><th>-</th></tr>
                   	  </thead>
                   	  <tbody id="datos_medicos">                   	  	
                   	  </tbody>
                   </table>                      
       </div>
</div>                      
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->

<!--<script src="dist/selectpicker/dist/js/bootstrap-select.js"></script>-->
 <script type="text/javascript" src="dist/js/functionsGeneral.js"></script>
 <script type="text/javascript">mueveReloj();nuevaInstitucion();</script>
</body>
</html>