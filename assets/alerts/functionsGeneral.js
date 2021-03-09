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
      mensaje="Debe registrar al menos un detalle para el pedido!";
    } 
    if(observaciones==""&&motivo==0){
      error=1;
      mensaje="Debe registrar la observación espeficica con la que desea guardar el pedido!";
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
