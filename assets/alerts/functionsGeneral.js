//funciones despues de cargar pantalla
window.onload = detectarCarga;
  function detectarCarga(){
    $(".cargar").fadeOut("slow");
  }

$(document).ready(function() {
  $(".csp").each(function(){
    var cantidad =  $(this).attr("colspan");
    //alert(cantidad);
    for (var i = 1; i < parseInt(cantidad); i++) {
       $(this).after("<td class='d-none'></td>");
    };
   });
});

function guardarPedido(tipo){
    $("#modo_pedido").val(tipo);
   $("#modalObservacionPedido").modal("show"); 
}
function guardarPedidoDesdeFacturacion(guardar){
    //DATOS CABECERA
    var tipoSalida=$("#tipoSalida").val();
    var tipoDoc=$("#tipoDoc").val();
    var cliente=$("#cliente").val();
    var tipoPrecio=$("#tipoPrecio").val();
    var razonSocial=$("#razonSocial").val();
    var nitCliente=0;//$("#nitCliente").val();
    var tipoVenta=$("#tipoVenta").val();
    var observaciones=$("#modal_observacion").val();
    var motivo=$("#modal_motivo").val();
    var totalVenta=$("#totalVenta").val();
    var descuentoVenta=$("#descuentoVenta").val();
    var totalFinal=$("#totalFinal").val();
    var efectivoRecibido=$("#efectivoRecibido").val();
    var cambioEfectivo=$("#cambioEfectivo").val();
    var fecha=$("#fecha").val();
    var cantidad_material=num; //num es para obtener la cantidad


    var error=0;var mensaje="";
    if(cantidad_material==0){
      error=1;
      mensaje="Debe registrar al menos un detalle para la venta perdida!";
    } 
    if(observaciones==""&&motivo==0){
      error=1;
      mensaje="Debe registrar la observación espeficica con la que desea guardar la venta perdida!";
    } 
   /* if(nitCliente==""){
      error=1;
      mensaje="Debe registrar el nit!";
    }*/ 

  if(error==0){
	 var parametros={"tipoSalida":tipoSalida,"tipoDoc":tipoDoc,"cliente":cliente,
	"tipoPrecio":tipoPrecio,"razonSocial":razonSocial,"nitCliente":nitCliente,"tipoVenta":tipoVenta,
    "observaciones":observaciones,"motivo":motivo,"totalVenta":totalVenta,"descuentoVenta":descuentoVenta,"totalFinal":totalFinal,
    "efectivoRecibido":efectivoRecibido,"cambioEfectivo":cambioEfectivo,"fecha":fecha,"cantidad_material":cantidad_material};
    
    var index=0;
    for (var i=1; i<=parseInt(cantidad_material); i++) {
    	if(parseInt($("#stock"+i).val())==0){
            index++;
            //objeto en string para cambiar el nombre al post   
            var detalle='{"stock'+index+'":'+$("#stock"+i).val()+',"materiales'+index+'":'+$("#materiales"+i).val()+',"cantidad_unitaria'+index+'":'+$("#cantidad_unitaria"+i).val()+',"precio_unitario'+index+'":'+$("#precio_unitario"+i).val()+',"descuentoProducto'+index+'":'+$("#descuentoProducto"+i).val()+',"montoMaterial'+index+'":'+$("#montoMaterial"+i).val()+'}'; 
            parametros = Object.assign(parametros,JSON.parse(detalle)); //unir el obtejo detalle al obtejo principal
    	}
    }

	//PASA Y MOSTRAMOS LOS ESTADOS DE CUENTA    
    //Swal.fire("Correcto!", JSON.stringify(parametros), "success");
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "guardarPedidoMaterial.php",
        data: parametros,
        success:  function (resp) {
            var resp_a=resp.split("#_#_#_#");
            if (resp_a[1]==1){
                Swal.fire("Correcto!", "El proceso se completo correctamente!", "success")
                    .then((value) => {
                    $("#pedido_realizado").val(2);
                    $("#modalObservacionPedido").modal("hide");
                    if(guardar>0){
                      $("#btsubmit").click();      
                    }                    
                    //location.reload();
                });
            }else{
                if(resp_a[1]=="<b>Todos los campos son obligatorios</b>"){
                  Swal.fire("Error!", resp_a[0], "error"); 
                }else{
                  Swal.fire("Error!",'El proceso tuvo un problema!. Contacte con el administrador!', "error");      
                }               
            }          
        }
    });
 }else{
    Swal.fire("Error!", mensaje, "error");  
    if(guardar==1){
        $("#pedido_realizado").val(0);
        return false;
    }
 }
}

 var cuentas_tabla_general=[]; 
function filaTablaGeneral(tabla,index){
  var html="";
  for (var i = 0; i < cuentas_tabla_general[index-1].length; i++) {
    html+="<tr><td>"+(i+1)+"</td><td>"+cuentas_tabla_general[index-1][i].proveedor+"</td><td>"+cuentas_tabla_general[index-1][i].linea+"</td><td>"+cuentas_tabla_general[index-1][i].nombre+"</td></tr>";
  };
  tabla.html(html);
  $('#tablaPrincipal').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "ordering": false,
            "pageLength": 100

        });
  $("#modalDetalles").modal("show");
}  

function buscarProductoLista(url){
  var codigo_registro=$("#tipo").val();
  var nombre=$("#buscar_nombre").val();
  var codigo=$("#buscar_codigo").val();
  var lineas=$("#buscar_linea").val(); 
  var formas=$("#buscar_forma").val(); 
  var acciones=$("#buscar_accion").val(); 
  
  var parametros={"codigo_registro":codigo_registro,"codigo":codigo,"nombre":nombre,"lineas":lineas,"formas":formas,"acciones":acciones};
     $.ajax({
        type: "POST",
        dataType: 'html',
        url: url,
        data: parametros, 
        beforeSend: function () {
          iniciarCargaAjax("Obteniendo productos...");
        },     
        success:  function (resp) {
          detectarCargaAjax();
          $("#tabla_productos").html(resp);
          //$("#modalBuscarProducto").find('.modal-content').empty();         
          $("#modalBuscarProducto").modal("hide");
        }
    });
}

function iniciarCargaAjax(texto=""){
  $("#texto_ajax_titulo").html(texto); 
  $(".cargar-ajax").removeClass("d-none");
}
function detectarCargaAjax(){
  $("#texto_ajax_titulo").html("Procesando Datos");
  $(".cargar-ajax").addClass("d-none");
  $(".cargar-ajax").fadeOut("slow");
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
  var amount_parts = amount.split('.');
      regexp = /(\d+)(\d{3})/;
  while (regexp.test(amount_parts[0]))
      amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
  return amount_parts.join('.');
}
function totalesTablaVertical(tabla,columna,fila){
   var main=document.getElementById(tabla);   
   var numFilas=main.rows.length;
   var numCols=main.rows[1].cells.length; 
   for(var j=columna; j<=numCols-1; j++){
    var subtotal=0;
      for(var i=fila; i<=numFilas-2; i++){
            var datoS=main.rows[i].cells[j].innerHTML;
            datoS=datoS.trim();   
            console.log(datoS+" "+typeof(datoS));
            if(datoS=="-"){
              datoS="0";
            }
            datoS=datoS.replace(/,/g,'');
            console.log(datoS);
            var dato=parseFloat(datoS);
            //console.log(dato);
            subtotal=subtotal+dato;
            var subtotalF=number_format(subtotal,2); 
            console.log("subtotal: "+subtotal);
      }
      var html='<th>'+subtotalF+'</th>';
      $("tfoot tr").append(html);   
  }
  $("tfoot tr").prepend("<th colspan='"+columna+"'>Totales</th>");   
}