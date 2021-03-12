<?php

echo "<script language='Javascript'>
		function enviar_nav()
		{	location.href='registrar_material_apoyo.php';
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
			{	alert('Debe seleccionar al menos un material de apoyo para proceder a su eliminación.');
			}
			else
			{
				if(confirm('Esta seguro de eliminar los datos.'))
				{
					location.href='eliminar_material_apoyo.php?datos='+datos+'';
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
			var j_ciclo;
			for(i=0;i<=f.length-1;i++)
			{
				if(f.elements[i].type=='checkbox')
				{	if(f.elements[i].checked==true)
					{	j_ciclo=f.elements[i].value;
						j=j+1;
					}
				}
			}
			if(j>1)
			{	alert('Debe seleccionar solamente un material de apoyo para editar sus datos.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un material de apoyo para editar sus datos.');
				}
				else
				{
					location.href='editar_material_apoyo.php?cod_material='+j_ciclo+'';
				}
			}
		}
		function cambiar_vista(sel_vista, f)
		{
			var modo_vista;
			modo_vista=sel_vista.value;
			location.href='navegador_material.php?vista='+modo_vista+'';
		}
		</script>";
		
	require("conexionmysqli.inc");
	require('estilos.inc');
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


	echo "<h1>Registro de Producto</h1>";

	echo "<form method='post' action=''>";
	$sql="select m.codigo_material, m.descripcion_material, m.estado, 
		(select e.nombre_empaque from empaques e where e.cod_empaque=m.cod_empaque), 
		(select f.nombre_forma_far from formas_farmaceuticas f where f.cod_forma_far=m.cod_forma_far), 
		(select pl.nombre_linea_proveedor from proveedores p, proveedores_lineas pl where p.cod_proveedor=pl.cod_proveedor and pl.cod_linea_proveedor=m.cod_linea_proveedor),
		(select t.nombre_tipoventa from tipos_venta t where t.cod_tipoventa=m.cod_tipoventa), m.cantidad_presentacion, m.principio_activo 
		from material_apoyo m
		where m.estado='1' order by m.descripcion_material limit 100";
	
	//echo $sql;
	$resp=mysqli_query($enlaceCon,$sql);
	
	
	echo "<div class=''>
		<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
		<input type='button' value='Editar' name='Editar' class='btn btn-primary' onclick='editar_nav(this.form)'>
		<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
		<div class='float-right'><a href='#' class='btn btn-default btn-sm' data-toggle='modal' data-target='#modalBuscarProducto'>&nbsp;<i class='material-icons'>search</i></a>  
  </div>
		</div>";
	
	echo "<center><table class='table table-sm' id='tabla_productos'>";
	echo "<tr class='bg-info text-white'><th>Indice</th><th>&nbsp;</th><th>Nombre Producto</th><th>Empaque</th>
		<th>Cant.Presentacion</th><th>Forma Farmaceutica</th><th>Linea Distribuidor</th><th>Principio Activo</th><th>Tipo Venta</th>
		<th>Accion Terapeutica</th></tr>";
	
	$indice_tabla=1;
	while($dat=mysqli_fetch_array($resp))
	{
		$codigo=$dat[0];
		$nombreProd=$dat[1];
		$estado=$dat[2];
		$empaque=$dat[3];
		$formaFar=$dat[4];
		$nombreLinea=$dat[5];
		$tipoVenta=$dat[6];
		$cantPresentacion=$dat[7];
		$principioActivo=$dat[8];
		
		$txtAccionTerapeutica="";
		$sqlAccion="select a.nombre_accionterapeutica from acciones_terapeuticas a, material_accionterapeutica m
			where m.cod_accionterapeutica=a.cod_accionterapeutica and 
			m.codigo_material='$codigo'";
		$respAccion=mysqli_query($enlaceCon,$sqlAccion);
		while($datAccion=mysqli_fetch_array($respAccion)){
			$nombreAccionTerX=$datAccion[0];
			$txtAccionTerapeutica=$txtAccionTerapeutica." - ".$nombreAccionTerX;
		}
		
		echo "<tr><td align='center'>$indice_tabla</td><td align='center'>
		<input type='checkbox' name='codigo' value='$codigo'></td>
		<td>$nombreProd</td><td>$empaque</td>
		<td>$cantPresentacion</td><td>$formaFar</td>
		<td>$nombreLinea</td><td>$principioActivo</td><td>$tipoVenta</td><td>$txtAccionTerapeutica</td></tr>";
		$indice_tabla++;
	}
	echo "</table></center><br>";
	
		echo "<div class=''>
		<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
		<input type='button' value='Editar' name='Editar' class='btn btn-primary' onclick='editar_nav(this.form)'>
		<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
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