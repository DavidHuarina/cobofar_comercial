<?php
echo "<script language='JavaScript'>
		function envia_formulario(f)
		{	var rpt_almacen, tipo_item, rpt_ver, rpt_fecha, tipo_item, rpt_item;
			rpt_ver=f.rpt_ver.value;
			rpt_fecha=f.rpt_fecha.value;
			tipo_item=f.tipo_item.value;
			rpt_item=f.rpt_item.value;
			var codAlmacen=new Array();
			var j=0;
			for(var i=0;i<=f.rpt_almacen.options.length-1;i++)
	        {	if(f.rpt_almacen.options[i].selected)
	        	{	codAlmacen[j]=f.rpt_almacen.options[i].value;
	        		j++;
	        	}
	        }
			window.open('rpt_inv_saldos_sucursales.php?rpt_almacen='+codAlmacen+'&rpt_ver='+rpt_ver+'&rpt_fecha='+rpt_fecha+'&tipo_item='+tipo_item+'&rpt_item='+rpt_item,'','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,width=1000,height=800');

			return(true);
		}
		function activa_tipomaterial(f){
			if(f.tipo_item.value==1)
			{	f.rpt_tipomaterial.disabled=true;
			}
			else
			{	f.rpt_tipomaterial.disabled=false;
			}
		}
		function envia_select(form){
			form.submit();
			return(true);
		}
		</script>";
		?>
<script type="text/javascript">
 function cambiarSubLinea(){
  var categoria=$("#rpt_categoria").val();
  var parametros={"categoria":categoria};
     $.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajaxCambiarComboLinea.php",
        data: parametros,   
        success:  function (resp) { 
        	//alert(resp);
          $("#rpt_subcategoria").html(resp);
          $(".selectpicker").selectpicker("refresh");
        }
    });
 }
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
        url: "ajaxProductoCombo.php",
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
require("conexionmysqli.inc");
if($global_tipoalmacen==1)
{	require("estilos_almacenes_central.inc");
}
else
{	require("estilos_almacenes.inc");
}
$fecha_rptdefault=date("d/m/Y");
echo "<h1>Reporte Saldos Producto - Sucursales</h1>";

echo"<form method='post' action=''>";
	
	echo"\n<table class='texto' align='center' cellSpacing='0' width='50%'>\n";
	echo "<tr><th align='left'>Sucursal</th><td><select name='rpt_almacen' class='selectpicker form-control' data-style='btn btn-primary' multiple data-actions-box='true' data-live-search='true' data-size='8'>";
	$sql="select cod_almacen, nombre_almacen from almacenes where cod_tipoalmacen=1 and estado_pedidos=1 order by orden";
	$resp=mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_almacen=$dat[0];
		$nombre_almacen=$dat[1];
		if($rpt_almacen==$codigo_almacen)
		{	echo "<option value='$codigo_almacen' selected>$nombre_almacen</option>";
		}
		else
		{	echo "<option value='$codigo_almacen' selected>$nombre_almacen</option>";
		}
	}
	echo "</select><input type='hidden' value='2' name='tipo_item'></td></tr>";

	echo "<tr><th align='left'>Ver:</th>";
	echo "<td><select name='rpt_ver' class='selectpicker form-control' data-style='btn btn-primary'>";
	echo "<option value='1'>Todo</option>";
	echo "<option value='2'>Con Existencia</option>";
	echo "<option value='3'>Sin existencia</option>";
	echo "</tr>";
	$fecha_rptdefault=date("d/m/Y");
	echo "<tr><th align='left'>Existencias a fecha:</th>";
			echo" <TD bgcolor='#ffffff'><INPUT  type='text' class='texto' value='$fecha_rptdefault' id='rpt_fecha' size='10' name='rpt_fecha'>";
    		echo" <IMG id='imagenFecha' src='imagenes/fecha.bmp'>";
    		echo" <DLCALENDAR tool_tip='Seleccione la Fecha' ";
    		echo" daybar_style='background-color: DBE1E7; font-family: verdana; color:000000;' ";
    		echo" navbar_style='background-color: 7992B7; color:ffffff;' ";
    		echo" input_element_id='rpt_fecha' ";
    		echo" click_element_id='imagenFecha'></DLCALENDAR>";
    		echo"  </TD>";
	echo "</tr>";
	echo "<tr><th align='left'>Productos</th><td><select name='rpt_item' id='rpt_item' class='selectpicker form-control col-sm-10'>";
	
	
	echo "</select> <a href='#' onclick='modalBusquedaProducto()' class='btn btn-warning btn-fab btn-sm float-right'><i class='material-icons'>search</i></a></td></tr>";	
	
	echo"\n </table><br>";
	echo "<center><input type='button' name='reporte' value='Ver Reporte' onClick='envia_formulario(this.form)' class='btn btn-warning'>
	</center><br>";
	echo"</form>";
	echo "</div>";
	echo"<script type='text/javascript' language='javascript'  src='dlcalendar.js'></script>";

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