<?php
	require_once("../conexionmysqli.inc");
	require_once("../estilos2.inc");
	require_once("configModule.php");
	require_once("../funciones.php");
	require_once("../funcion_nombres.php");
?>
<script language='Javascript'>
	function registrar_nav()
		{	location.href='<?=$urlRegister?>';
		}
	function registrar_nav2()
		{	location.href='<?=$urlRegister?>?rf=1';
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
					location.href='<?=$urlEdit?>?codigo_registro='+j_cod_registro+'';
				}
			}
		}
function enviar_nav(f){	
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
			{	alert('Debe seleccionar solamente un registro para iniciar.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para iniciar.');
				}
				else
				{
					$("#modal_numero").html(" - Inventario : "+$("#nombre"+j_cod_registro).val());
                    $("#j_cod_registro").val(j_cod_registro);
                    $("#modal_aprobar").modal("show");
				}
			}           
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
				if(confirm('Esta seguro de anular los datos.'))
				{
					location.href='<?=$urlDelete?>?datos='+datos+'&admin=1';
				}
				else
				{
					return(false);
				}
			}
		}

		function finalizar_nav(f)
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
			{	alert('Debe seleccionar solamente un registro para finalizar.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para finalizar.');
				}
				else
				{
					$("#modal_numero_finalizar").html(" - Inventario : "+$("#nombre"+j_cod_registro).val());
                    $("#j_cod_registro_finalizar").val(j_cod_registro);
                    $("#modal_finalizar").modal("show");
				}
			} 
		}
		function anular_nav(f)
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
			{	alert('Debe seleccionar solamente un registro para anular.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para anular.');
				}
				else
				{
					$("#modal_numero_anular").html(" - Inventario : "+$("#nombre"+j_cod_registro).val());
                    $("#j_cod_registro_anular").val(j_cod_registro);
                    $("#modal_anular").modal("show");
				}
			} 
		}
		</script>

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
		function editar_lineas(f)
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
			{	alert('Debe seleccionar solamente un registro para editar las líneas.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para editar las líneas.');
				}
				else
				{
					location.href='<?=$urlEditLinea?>?codigo_registro='+j_cod_registro+'';
				}
			}
		}
		function aprobarSalidaTraspaso(){
           var j_cod_registro = $("#j_cod_registro").val();
           //if($("#modal_observacion").val()==""){
           //  Swal.fire("Informativo!","Debe registrar la glosa para ANULAR", "warning");
           //}else{
              var obs =$("#modal_observacion").val().replace(/['"]+/g, '');  
              location.href='cambiar_estado.php?codigo_registro='+j_cod_registro+'&estado=4&obs='+obs;
           //} 
         }
         function finalizarSalidaTraspaso(){
           var j_cod_registro = $("#j_cod_registro_finalizar").val();
           //if($("#modal_observacion").val()==""){
           //  Swal.fire("Informativo!","Debe registrar la glosa para ANULAR", "warning");
           //}else{
              var obs =$("#modal_observacion_finalizar").val().replace(/['"]+/g, '');  
              location.href='cambiar_estado.php?codigo_registro='+j_cod_registro+'&estado=3&obs='+obs;
           //} 
         }
         function anularSalidaTraspaso(){
           var j_cod_registro = $("#j_cod_registro_anular").val();
           if($("#modal_observacion_anular").val()==""){
             Swal.fire("Informativo!","Debe registrar la observación para ANULAR", "warning");
           }else{
              var obs =$("#modal_observacion_anular").val().replace(/['"]+/g, '');  
              location.href='cambiar_estado.php?codigo_registro='+j_cod_registro+'&estado=2&obs='+obs;
           } 
         }
</script>
	
	<?php
	//utilizado para validar la eliminacion y edicion no se permite al dia siguiente. 
	$fechaActual=date("Y-m-d");

	$cod_ciudad=$_COOKIE['global_agencia'];
	echo "<form method='post' action=''>";
	$sql="SELECT f.codigo,f.cod_funcionario,f.monto_registrado,f.monto_caja,f.fecha,f.glosa,f.nro_cuenta,f.cod_banco,f.ubicacion_archivo,f.cod_cuenta,f.monto_registradousd,f.fecha_registro FROM registro_depositos f join funcionarios fu on fu.codigo_funcionario=f.cod_funcionario where f.cod_estadoreferencial=1 and fu.cod_ciudad='$cod_ciudad' order by f.fecha desc;";
	//echo $sql;
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<h1>$moduleNamePlural</h1>";
	if(obtenerCargoPersonal($_COOKIE["global_usuario"])==31){
	echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='registrar_nav()'>
	<!--input type='button' value='Editar' name='editar' class='btn btn-default' onclick='editar_nav(this.form)'-->
	<input type='button' value='Anular' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
	</div>";		
	}
	
	
	echo "<center><table class='table table-sm table-bordered'>";
	echo "<tr class='bg-principal text-white'>
	<th>&nbsp;</th>
	<th width='20%'>Descripcion</th>
	<th>Banco</th>
	<th>Monto</th>
	<th>Monto USD</th>
	<th>Responsable</th>
	<th>Fecha</th>
	<th>Estado</th>
	</tr>";
	while($dat=mysqli_fetch_array($resp))
	{
		$codigo=$dat[0];
		$glosa=$dat['glosa'];
		
		$fechaDeposito=$dat['fecha_registro'];
      
		$date1 = new DateTime($fechaActual);
		$date2 = new DateTime($fechaDeposito);
		$diff = $date1->diff($date2);
		// will output 2 days
		//echo $diff->days . ' days ';

		if($dat['fecha']==""){
			$fecha="";
		}else{
			$fecha=strftime('%d/%m/%Y',strtotime($dat["fecha"]));
		}
		$banco=nombreBancoCuenta($dat["cod_cuenta"]);
        $responsable=nombreVisitador($dat["cod_funcionario"]);

        $monto=$dat['monto_registrado'];
        $monto2=$dat['monto_registradousd'];
        $monto_caja=$dat['monto_caja'];
        $monto_formato=number_format($monto,2,'.',',');
        $monto_formatoUSD=number_format($monto2,2,'.',',');
        $enlaceDetalles="<a href='$urlListArchivos?c=$codigo&b=0' target='_blank' class='btn btn-sm btn-info btn-fab' style='background:#BD9A22;'><i class='material-icons'>folder_open</i>&nbsp;</a>";
        if($diff->days<=1){
	        $inputcheck="<input type='checkbox' name='codigo' value='$codigo'>";        	
        }else{
        	$inputcheck="";
        }        

		echo "<tr>
		<td>$inputcheck</td>
		<td>$glosa</td>
		<td>$banco</td>
		<td align='right'>$monto_formato</td>
		<td align='right'>$monto_formatoUSD ($)</td>
		<td><small>$responsable</small></td>
		<td>$fecha</td>
		<td>$enlaceDetalles</td>
		</tr>";
	}
	echo "</table></center><br>";
	
	if(obtenerCargoPersonal($_COOKIE["global_usuario"])==31){
	echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='registrar_nav()'>
	<!--input type='button' value='Editar' name='editar' class='btn btn-default' onclick='editar_nav(this.form)'-->
	<input type='button' value='Anular' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
	</div>";		
	}
	
	echo "</form>";
?>

        <!-- small modal -->
<div class="modal fade modal-primary" id="modal_aprobar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content card">
               <div class="card-header card-header-success card-header-text">
                  <div class="card-text">
                    <h4>Iniciar <b id="modal_numero"></b></h4>      
                  </div>
                  <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <div class="card-body">
                    <input type="hidden" name="j_cod_registro" id="j_cod_registro" value="0">
                      <div class="row">
                          <label class="col-sm-2 col-form-label">Observación</label>
                           <div class="col-sm-10">                     
                             <div class="form-group">
                               <textarea class="form-control" id="modal_observacion" name="modal_observacion"></textarea>
                             </div>
                           </div>        
                      </div>
                      <br><br>
                      <div class="float-right">
                        <button class="btn btn-success" onclick="aprobarSalidaTraspaso()">Iniciar Revisión</button>
                        <button class="btn btn-danger"  data-dismiss="modal">CANCELAR</button>
                      </div> 
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->

        <!-- small modal -->
<div class="modal fade modal-primary" id="modal_finalizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content card">
               <div class="card-header card-header-success card-header-text">
                  <div class="card-text">
                    <h4>Finalizar <b id="modal_numero_finalizar"></b></h4>      
                  </div>
                  <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <div class="card-body">
                    <input type="hidden" name="j_cod_registro_finalizar" id="j_cod_registro_finalizar" value="0">
                      <div class="row">
                          <label class="col-sm-2 col-form-label">Observación (*)</label>
                           <div class="col-sm-10">                     
                             <div class="form-group">
                               <textarea class="form-control" id="modal_observacion_finalizar" name="modal_observacion_finalizar"></textarea>
                             </div>
                           </div>        
                      </div>
                      <br><br>
                      <div class="float-right">
                        <button class="btn btn-success" onclick="finalizarSalidaTraspaso()">Finalizar Revisión</button>
                        <button class="btn btn-danger"  data-dismiss="modal">CANCELAR</button>
                      </div> 
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->

        <!-- small modal -->
<div class="modal fade modal-primary" id="modal_anular" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content card">
               <div class="card-header card-header-danger card-header-text">
                  <div class="card-text">
                    <h4>Anular <b id="modal_numero_anular"></b></h4>      
                  </div>
                  <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <div class="card-body">
                    <input type="hidden" name="j_cod_registro_anular" id="j_cod_registro_anular" value="0">
                      <div class="row">
                          <label class="col-sm-2 col-form-label">Observación (*)</label>
                           <div class="col-sm-10">                     
                             <div class="form-group">
                               <textarea class="form-control" id="modal_observacion_anular" name="modal_observacion_anular"></textarea>
                             </div>
                           </div>        
                      </div>
                      <br><br>
                      <div class="float-right">
                        <button class="btn btn-danger" onclick="anularSalidaTraspaso()">ANULAR</button>
                        <button class="btn btn-danger"  data-dismiss="modal">CANCELAR</button>
                      </div> 
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->