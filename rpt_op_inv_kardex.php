<?php
echo "<script language='JavaScript'>
		function envia_formulario(f)
		{	var rpt_territorio, rpt_almacen,tipo_ingreso,fecha_ini, fecha_fin, tipo_item, rpt_item;
			rpt_territorio=f.rpt_territorio.value;
			rpt_almacen=f.rpt_almacen.value;
			fecha_ini=f.exafinicial.value;
			fecha_fin=f.exaffinal.value;
			tipo_item=f.tipo_item.value;
			rpt_item=f.rpt_item.value;
			window.open('rpt_inv_kardex.php?rpt_territorio='+rpt_territorio+'&rpt_almacen='+rpt_almacen+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'&tipo_item='+tipo_item+'&rpt_item='+rpt_item+'','','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,width=1000,height=800');			
			return(true);
		}
		function envia_formulario_xls(f)
		{	var rpt_territorio, rpt_almacen,tipo_ingreso,fecha_ini, fecha_fin, tipo_item, rpt_item;
			rpt_territorio=f.rpt_territorio.value;
			rpt_almacen=f.rpt_almacen.value;
			fecha_ini=f.exafinicial.value;
			fecha_fin=f.exaffinal.value;
			tipo_item=f.tipo_item.value;
			rpt_item=f.rpt_item.value;
			window.open('rpt_inv_kardex_xls.php?rpt_territorio='+rpt_territorio+'&rpt_almacen='+rpt_almacen+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'&tipo_item='+tipo_item+'&rpt_item='+rpt_item+'','','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,width=1000,height=800');			
			return(true);
		}
		function envia_select(form){
			form.submit();
			return(true);
		}
		</script>";
require("conexionmysqli.inc");
if($_COOKIE["admin_central"]==1){
	$global_tipoalmacen=1;
}
if(isset($global_tipoalmacen)&&$global_tipoalmacen==1)
{	require("estilos_almacenes.inc");
}
else
{	require("estilos_almacenes.inc");
}

?>
<script type="text/javascript">	
function cargalistadoAlmacenes(){
    var ciudad=$("#rpt_territorio").val();
    var parametros={"ciudad":ciudad};
    $.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajaxCargarAlmacenCiudad.php",
        data: parametros,
        success:  function (resp) {
          $("#rpt_almacen").html(resp);  
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
$fecha_rptdefault=date("d/m/Y");
echo "<h1>Reporte Kardex de Existencia Fisica</h1><br>";
echo"<form method='post' action='rpt_op_inv_kardex.php'>";
	echo"\n<table class='texto' align='center' cellSpacing='0' width='50%'>\n";
	echo "<tr><th align='left'>Territorio</th><td><select name='rpt_territorio' id='rpt_territorio' class='selectpicker form-control' data-size='6' data-live-search='true' onChange='cargalistadoAlmacenes()'>";
	if($global_tipoalmacen==1)
	{	$sql="select cod_ciudad, descripcion from ciudades order by descripcion";
	}
	else
	{	$sql="select cod_ciudad, descripcion from ciudades where cod_ciudad='$global_agencia' order by descripcion";
	}
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<option value=''></option>";
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_ciudad=$dat[0];
		$nombre_ciudad=$dat[1];
		if($rpt_territorio==$codigo_ciudad)
		{	echo "<option value='$codigo_ciudad' selected>$nombre_ciudad</option>";
		}
		else
		{	echo "<option value='$codigo_ciudad'>$nombre_ciudad</option>";
		}
	}
	echo "</select></td></tr>";
	echo "<tr><th align='left'>Sucursal</th><td><select name='rpt_almacen' id='rpt_almacen' class='selectpicker form-control'>";
	
	echo "</select><input type='hidden' value='2' name='tipo_item'></td></tr>";
	echo "<tr><th align='left'>Productos</th><td><select name='rpt_item' id='rpt_item' class='selectpicker form-control col-sm-10'>";
	
	
	echo "</select> <a href='#' onclick='modalBusquedaProducto()' class='btn btn-warning btn-fab btn-sm float-right'><i class='material-icons'>search</i></a></td></tr>";	
	echo "<tr><th align='left'>Fecha inicio:</th>";
			echo" <TD bgcolor='#ffffff'><INPUT  type='text' class='texto' value='$fecha_rptdefault' id='exafinicial' size='10' name='exafinicial'>";
    		echo" <IMG id='imagenFecha' src='imagenes/fecha.bmp'>";
    		echo" <DLCALENDAR tool_tip='Seleccione la Fecha' ";
    		echo" daybar_style='background-color: DBE1E7; font-family: verdana; color:000000;' ";
    		echo" navbar_style='background-color: 7992B7; color:ffffff;' ";
    		echo" input_element_id='exafinicial' ";
    		echo" click_element_id='imagenFecha'></DLCALENDAR>";
    		echo"  </TD>";
	echo "</tr>";
	echo "<tr><th align='left'>Fecha final:</th>";
			echo" <TD bgcolor='#ffffff'><INPUT  type='text' class='texto' value='$fecha_rptdefault' id='exaffinal' size='10' name='exaffinal'>";
    		echo" <IMG id='imagenFecha1' src='imagenes/fecha.bmp'>";
    		echo" <DLCALENDAR tool_tip='Seleccione la Fecha' ";
    		echo" daybar_style='background-color: DBE1E7; font-family: verdana; color:000000;' ";
    		echo" navbar_style='background-color: 7992B7; color:ffffff;' ";
    		echo" input_element_id='exaffinal' ";
    		echo" click_element_id='imagenFecha1'></DLCALENDAR>";
    		echo"  </TD>";
	echo "</tr>";
	
	echo"\n </table><br>";
	require('home_almacen.php');
	echo "<center><input type='button' name='reporte' value='Ver Reporte' onClick='envia_formulario(this.form)' class='boton'>
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

