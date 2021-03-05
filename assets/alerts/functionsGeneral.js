function guardarPedidoDesdeFacturacion(){

	var parametros={"tipoSalida":tipoSalida,"tipoDoc":tipoDoc,"cliente":cliente,
	"tipoPrecio":tipoPrecio,"razonSocial":razonSocial,"nitCliente":nitCliente,"tipoVenta":tipoVenta,
    "observaciones":observaciones,"totalVenta":totalVenta,"descuentoVenta":descuentoVenta,"totalFinal":totalFinal,
    "efectivoRecibido":efectivoRecibido,"cambioEfectivo":cambioEfectivo,"fecha":fecha,"cantidad_material":cantidad_material};
    
    var index=0;var materiales=[];
    for (var i=1; i<=cantidad_material; i++) {
    	if($("#stock"+i).val()==0){
    		index++;
    		materiales["stock"+index]=$("#stock"+i).val();
            //registrar detalle
    	}
    }
	//PASA Y MOSTRAMOS LOS ESTADOS DE CUENTA    
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "guardarPedidoMaterial.php",
        data: parametros,
        success:  function (resp) {
          Swal.fire("Correcto!", "El proceso fue satisfactorio!", "success");
        }
    });
}