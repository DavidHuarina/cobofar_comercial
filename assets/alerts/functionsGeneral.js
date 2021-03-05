function guardarPedidoDesdeFacturacion(){

	var parametros={"codigo":codigo_s,"nombre":nombre_s,"ibnorca":cod_i,"fecha_curso":fecha_s};
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