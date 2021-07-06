<?php

require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");
$fecha_rptinidefault=date("Y")."-".date("m")."-01";
$hora_rptinidefault=date("H:i");
$fecha_rptdefault=date("Y-m-d");

?>
<script type="text/javascript">
	function modalBusquedaProducto(){
	$("#modalBusquedaProducto").modal("show");
}
function buscarProductoReporte(){
	var codigo=$("#codigo_buscar").val();
	var descripcion=$("#descripcion_buscar").val();
    var parametros={"codigo":codigo,"descripcion":descripcion};
    $.ajax({
        type: "GET",
        dataType: 'html',
        url: "../ajaxProductoCombo.php",
        data: parametros,
        success:  function (resp) {
        //alert(resp);
          $("#rpt_item").html(resp);  
          $(".selectpicker").selectpicker("refresh");
          $("#modalBusquedaProducto").modal("hide");
        }
    });
}
</script>
<?php
echo "<form action='$urlSave' method='post'>";

echo "<h1>Registrar $moduleNameSingular <i class='material-icons'>push_pin</i></h1>";

echo "<center><table class='table table-sm' width='60%'>";
	echo "<tr><th align='left' class='bg-info text-white'>Productos</th><td><select name='rpt_item' id='rpt_item' class='selectpicker form-control col-sm-10'>";
	
	
	echo "</select> <a href='#' onclick='modalBusquedaProducto()' class='btn btn-warning btn-fab btn-sm float-right'><i class='material-icons'>search</i></a></td></tr>";	
echo "<tr><td align='left' class='bg-info text-white'>Observacion</td>";
echo "<td align='left' colspan='3'>
	<input type='text' class='form-control' name='nombre' size='40' onKeyUp='javascript:this.value=this.value.toUpperCase();' required>
</td></tr>";

echo "</table></center>";

echo "<div class=''>
<input type='submit' class='btn btn-primary' value='Guardar'>
<input type='button' class='btn btn-danger' value='Cancelar' onClick='location.href=\"$urlList2\"'>
";

echo "</form>";
?>

<!-- small modal -->
<div class="modal fade modal-primary" id="modalBusquedaProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content card">
               <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon" style="background: #96079D;color:#fff;">
                    <i class="material-icons">search</i>
                  </div>
                  <h4 class="card-title text-dark font-weight-bold">Buscar producto <small id="titulo_tarjeta"></small></h4>
                  <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true" style="position:absolute;top:0px;right:0;">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <div class="card-body">
<div class="row">
	<div class="col-sm-12">
		         <div class="row">
                  <label class="col-sm-3 col-form-label">Codigo</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" type="number" style="background: #D7B3D8;" id="codigo_buscar" name="codigo_buscar" value=""/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">Descripcion</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" type="text" style="background: #D7B3D8;" id="descripcion_buscar" name="descripcion_buscar" value=""/>
                    </div>
                  </div>
                </div>               
                <br><br>

                <a href="#" onclick="buscarProductoReporte()" class="btn btn-success float-right btn-sm">Buscar</a>
                 </div>
          </div>                      
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->