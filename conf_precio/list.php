<?php
	require_once("../conexionmysqli.inc");
	require_once("../estilos2.inc");
	require_once("configModule.php");
	require_once("../funciones.php");


echo "<script language='Javascript'>
		function enviar_nav()
		{	location.href='$urlRegister';
		}
		function eliminar_nav(f)
		{
			var i;
			var j=0;
			datos=new Array();
			for(i=0;i<=f.length-1;i++)
			{
				if(f.elements[i].type=='checkbox')
				{	if(f.elements[i].checked==true)
					{	datos[j]=f.elements[i].value;
						j=j+1;
					}
				}
			}
			if(j==0)
			{	alert('Debe seleccionar al menos un registro para eliminar.');
			}
			else
			{
				if(confirm('Esta seguro de eliminar los datos.'))
				{
					location.href='$urlDelete?datos='+datos+'';
				}
				else
				{
					return(false);
				}
			}
		}

		function editar_nav(f)
		{
			var i;
			var j=0;
			var j_cod_registro;
			for(i=0;i<=f.length-1;i++)
			{
				if(f.elements[i].type=='checkbox')
				{	if(f.elements[i].checked==true)
					{	j_cod_registro=f.elements[i].value;
						j=j+1;
					}
				}
			}
			if(j>1)
			{	alert('Debe seleccionar solamente un registro para editar.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para editar.');
				}
				else
				{
					location.href='$urlEdit?codigo_registro='+j_cod_registro+'';
				}
			}
		}
		</script>";
	?>
<script type="text/javascript">
	function editar_dias(f)
		{
			var i;
			var j=0;
			var j_cod_registro;
			for(i=0;i<=f.length-1;i++)
			{
				if(f.elements[i].type=='checkbox')
				{	if(f.elements[i].checked==true)
					{	j_cod_registro=f.elements[i].value;
						j=j+1;
					}
				}
			}
			if(j>1)
			{	alert('Debe seleccionar solamente un registro para editar los días.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para editar los días.');
				}
				else
				{
					location.href='<?=$urlEditDia?>?codigo_registro='+j_cod_registro+'';
				}
			}
		}
		function editar_ciudades(f)
		{
			var i;
			var j=0;
			var j_cod_registro;
			for(i=0;i<=f.length-1;i++)
			{
				if(f.elements[i].type=='checkbox')
				{	if(f.elements[i].checked==true)
					{	j_cod_registro=f.elements[i].value;
						j=j+1;
					}
				}
			}
			if(j>1)
			{	alert('Debe seleccionar solamente un registro para editar las sucursales.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para editar las sucursales.');
				}
				else
				{
					location.href='<?=$urlEditCiudad?>?codigo_registro='+j_cod_registro+'';
				}
			}
		}
$(document).ready(function() {
   $('#tablaPrincipal').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "ordering": false,
            "pageLength": 100

        });
});
</script>
	<?php

	$cadComboLinea="";
$consult="select t.`cod_linea_proveedor`, t.`nombre_linea_proveedor`,p.nombre_proveedor from `proveedores_lineas` t join proveedores p on p.cod_proveedor=t.cod_proveedor where estado=1";
$rs1=mysqli_query($enlaceCon,$consult);
while($reg1=mysqli_fetch_array($rs1))
   {$codTipo = $reg1["cod_linea_proveedor"];
    $nomTipo = $reg1["nombre_linea_proveedor"];
    $nomProv = $reg1["nombre_proveedor"];
    $cadComboLinea.="<option value='$codTipo' data-subtext='$nomProv'>$nomTipo</option>";
   }
$cadComboForma="";
$consult="select e.cod_forma_far, e.nombre_forma_far from formas_farmaceuticas e where e.estado=1 order by 2";
$rs1=mysqli_query($enlaceCon,$consult);
while($reg1=mysqli_fetch_array($rs1))
   {$codTipo = $reg1["cod_forma_far"];
    $nomTipo = $reg1["nombre_forma_far"];
    $cadComboForma.="<option value='$codTipo'>$nomTipo</option>";
   }
$cadComboAccion="";
$consult="select e.cod_accionterapeutica, e.nombre_accionterapeutica from acciones_terapeuticas e where e.estado=1 order by 2";
$rs1=mysqli_query($enlaceCon,$consult);
while($reg1=mysqli_fetch_array($rs1))
   {$codTipo = $reg1["cod_accionterapeutica"];
    $nomTipo = $reg1["nombre_accionterapeutica"];
    $cadComboAccion.="<option value='$codTipo'>$nomTipo</option>";
   }


	echo "<form method='post' action=''>";
	$sql="select m.codigo_material, m.descripcion_material, m.estado, 
		(select e.nombre_empaque from empaques e where e.cod_empaque=m.cod_empaque), 
		(select f.nombre_forma_far from formas_farmaceuticas f where f.cod_forma_far=m.cod_forma_far), 
		(select pl.nombre_linea_proveedor from proveedores p, proveedores_lineas pl where p.cod_proveedor=pl.cod_proveedor and pl.cod_linea_proveedor=m.cod_linea_proveedor),
		(select t.nombre_tipoventa from tipos_venta t where t.cod_tipoventa=m.cod_tipoventa), m.cantidad_presentacion, m.principio_activo,(select p.nombre_proveedor from proveedores p, proveedores_lineas pl where p.cod_proveedor=pl.cod_proveedor and pl.cod_linea_proveedor=m.cod_linea_proveedor)
		from $table m
		where m.estado='1' order by m.descripcion_material limit 100";
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<h1>Lista de $moduleNamePlural</h1>";
	
	echo "<div class=''>
<div class='float-right'><a href='#' class='btn btn-default btn-sm' data-toggle='modal' data-target='#modalBuscarProducto'>&nbsp;<i class='material-icons'>search</i></a>  
  </div>
	</div>";
	
	
	echo "<center><table class='table table-sm table-bordered' id='tabla_productos'><thead>";
	echo "<tr class='bg-principal text-white'>
	<th>N.</th>
	<th>Proveedor</th>
	<th>Linea</th>
	<th>Producto</th>
	<th>Precio</th>
	<th>Detalle</th>
	</tr></thead><tbody>";
	$index=0;
	while($dat=mysqli_fetch_array($resp))
	{ 
		$index++;
		$codigo=$dat[0];
		$nombre=$dat[1];
		$linea=$dat[5];
		$proveedor=$dat[9];
		$precioProducto=number_format(obtenerPrecioProductoSucursal($codigo),2,'.',' ');
		$enlace="<a class='btn btn-warning btn-sm' style='background:#F5921B !important;' title='Modificar en Sucursales' href='$urlListDetalle?codigo=$codigo' onclick=''><i class='material-icons'>edit</i>&nbsp;<i class='material-icons'>business</i></a>";
		echo "<tr>
		<td>$index</td>
		<td>$proveedor</td>
		<td>$linea</td>
		<td>$nombre</td>
		<td><small>$precioProducto</small></td>
		<td>$enlace</td>
		</tr>";
	}
	echo "</tbody></table></center><br>";
	
	echo "<div class=''>
	</div>";
	
	echo "</form>";
?>


<!-- modal devolver solicitud -->
<div class="modal fade" id="modalBuscarProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:#732590; !important;color:#fff;">
        <h4 class="modal-title">Buscar Producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
      </div>
      <div class="modal-body">        
        <div class="row">
          <label class="col-sm-1 col-form-label" style="color:#7e7e7e"><span id=""><small>Codigo<br>Producto</small></span></label>
          <div class="col-sm-2">
            <div class="form-group" >
              <input type="text" class="form-control" name="buscar_codigo" id="buscar_codigo" style="background-color:#e2d2e0">              
            </div>
          </div>
          <label class="col-sm-1 col-form-label" style="color:#7e7e7e"><span id=""><small>Nombre<br>Producto</small></span></label>
          <div class="col-sm-8">
            <div class="form-group" >              
                <input type="text" class="form-control" name="buscar_nombre" id="buscar_nombre" style="background-color:#e2d2e0">
            </div>
          </div>
        </div> 
        <div class="row">
          <label class="col-sm-1 col-form-label" style="color:#7e7e7e"><span id=""><small >Lineas</small></span></label>
          <div class="col-sm-11">
            <div class="form-group" >              
                <select class="selectpicker form-control form-control-sm" data-live-search="true" title="-- Elija una linea --" name="buscar_linea[]" id="buscar_linea" multiple data-actions-box="true" data-style="select-with-transition" data-actions-box="true" data-size="10">
                    <?php echo $cadComboLinea;?>
                </select>
            </div>
          </div>
        </div> 
        <div class="row">
                    <div class="col-sm-6">
                      <div class="row">
                       <label class="col-sm-2 col-form-label" style="color:#7e7e7e"><small>Forma Farmacéutica</small></label>
                       <div class="col-sm-10">
                        <div class="form-group">
                              <select class="selectpicker form-control form-control-sm" name="buscar_forma[]" id="buscar_forma" data-style="select-with-transition" multiple data-actions-box="true" data-live-search="true" data-size="10">
                                 <?php echo $cadComboForma;?>
                                   </select>                           
                            </div>
                        </div>
                   </div>
                     </div>
                    <div class="col-sm-6">
                      <div class="row">
                       <label class="col-sm-2 col-form-label" style="color:#7e7e7e"><small>Acción Terapéutica</small></label>
                       <div class="col-sm-10">
                        <div class="form-group">
                                <select class="selectpicker form-control form-control-sm" name="buscar_accion[]" id="buscar_accion" data-style="select-with-transition" multiple data-actions-box="true" data-size="10" data-live-search="true">
                                 <?php echo $cadComboAccion;?>    
                                 </select>
                            </div>
                        </div>
                    </div>
              </div>
                  </div><!--div row-->     
      </div>
      <br>  
      <div class="modal-footer">
        <a href="#" class="btn btn-success btn btn-sm" style="background:#732590 !important;" onclick="buscarProductoLista('ajaxBuscarProducto.php')"><i class="material-icons">search</i> BUSCAR PRODUCTO</a>
      </div>
    </div>
  </div>
</div>
<!-- modal reenviar solicitud devuelto -->