<?php
	require_once("../conexionmysqli.inc");
	require_once("../estilos2.inc");
	require_once("configModule.php");
	require_once("../funcion_nombres.php");
	require_once("../funciones.php");
	$codMaestro=$_GET['codigo'];
	$nameMaestro=obtenerNombreMaestro($table,$codMaestro);
	 
?><script>	
	function editar_productos(f)
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
			{	alert('Debe seleccionar solamente un registro para editar los productos.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro para editar los productos.');
				}
				else
				{
					location.href='<?=$urlEditProducto?>?codigo_registro='+j_cod_registro+'&cod_padre=<?=$codMaestro?>';
				}
			}
		}
</script><?php
echo "<script language='Javascript'>
		function enviar_nav()
		{	location.href='$urlRegisterDet?cod_maestro=$codMaestro';
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
					location.href='$urlDeleteDet?datos='+datos+'&cod_maestro=$codMaestro';
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
					location.href='$urlEditDet?codigo_registro='+j_cod_registro+'&cod_maestro=$codMaestro';
				}
			}
		}
		</script>";
	
	
	echo "<form method='post' action=''>";
	$sql="select codigo, nombre, abreviatura, estado from $tableDetalle where estado=1 and $campoForaneo=$codMaestro order by 2";
	//echo $sql;
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<h1>Lista de $moduleDetNamePlural</h1>";
	
	echo "<h1>$moduleNameSingular $nameMaestro</h1>";
	
	
	echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
	<input type='button' value='Editar' name='Editar' class='btn btn-info' onclick='editar_nav(this.form)'>
	<input type='button' value='Modificar Productos' name='productos' class='btn btn-info' onclick='editar_productos(this.form)'>
	<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>	
	</div>";
	
	
	echo "<center><table class='table table-sm'>";
	echo "<tr class='bg-info text-white'>
	<th>&nbsp;</th>
	<th>Codigo</th>
	<th>Nombre</th>
	<th>Abreviatura</th>
	<th style='text-align:right'>Productos</th>
	</tr>";
	$index=1;$cont= array();
	while($dat=mysqli_fetch_array($resp))
	{
		$nc=0;
		$sqlDetalle="SELECT m.codigo_material,m.descripcion_material,l.cod_proveedor,m.cod_linea_proveedor from subgrupos_material s join material_apoyo m on m.codigo_material=s.cod_material join proveedores_lineas l on l.cod_linea_proveedor=m.cod_linea_proveedor where m.estado=1 and s.cod_subgrupo=".$dat[0]." order by m.descripcion_material";    
		//echo $sqlDetalle;
		$respDetalle=mysqli_query($enlaceCon,$sqlDetalle);                               
       while($row2=mysqli_fetch_array($respDetalle)) {
           $dato =new stdClass();
           $nombreX=$row2['descripcion_material'];
           $proveedorX=obtenerNombreProveedor($row2['cod_proveedor']);
           $lineaX=obtenerNombreProveedorLinea($row2['cod_linea_proveedor']);
           $dato->codigo=($nc+1);
           $dato->nombre=$nombreX;
           $dato->proveedor=$proveedorX;
           $dato->linea=$lineaX;
           $datos[$index-1][$nc]=$dato;                           
           $nc++;
        }
        $cont[$index-1]=$nc; 

		$codigo=$dat[0];
		$nombre=$dat[1];
		$abreviatura=$dat[2];
		echo "<tr>
		<td><input type='checkbox' name='codigo' value='$codigo'></td>
		<td>$codigo</td>
		<td>$nombre</td>
		<td>$abreviatura</td>";
        ?>
        <td class="td-actions text-right">
          <a href='#' class="btn btn-warning" title="Ver Productos" onclick="filaTablaGeneral($('#tablas_registradas'),<?=$index?>)">
            &nbsp;<?=$nc?>
          </a>
        </td> 
        <?php
		echo "</tr>";
		$index++;
	}
	echo "</table></center><br>";
	
	echo "<div class=''>
	<input type='button' value='Adicionar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
	<input type='button' value='Editar' name='Editar' class='btn btn-info' onclick='editar_nav(this.form)'>
	<input type='button' value='Modificar Productos' name='productos' class='btn btn-info' onclick='editar_productos(this.form)'>
	<input type='button' value='Eliminar' name='eliminar' class='btn btn-danger' onclick='eliminar_nav(this.form)'>
	</div>";
	
	echo "</form>";


	$lan=sizeof($cont);
for ($i=0; $i < $lan; $i++) {
  ?><script>var productos=[];</script><?php
     for ($j=0; $j < $cont[$i]; $j++) { 
         if($cont[$i]>0){
          ?><script>productos.push({codigo:<?=$datos[$i][$j]->codigo?>,nombre:'<?=$datos[$i][$j]->nombre?>',proveedor:'<?=$datos[$i][$j]->proveedor?>',linea:'<?=$datos[$i][$j]->linea?>'});</script><?php         
          }          
        }
    ?><script>cuentas_tabla_general.push(productos);</script><?php                    
}
?>
<!-- small modal -->
<div class="modal fade modal-primary" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content card">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">settings_applications</i>
                  </div>
                  <h4 class="card-title">Productos Registrados</h4>
                </div>
                <div class="card-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  <i class="material-icons">close</i>
                </button>
                  <table class="table table-sm table-bordered table-condensed" id='tablaPrincipal'>
                    <thead>
                      <tr class="text-white bg-principal">
                      <th>#</th>
                      <th>Proveedor</th>
                      <th>Linea</th>
                      <th>Producto</th>
                      </tr>
                    </thead>
                    <tbody id="tablas_registradas">
                      
                    </tbody>
                  </table>
                  <br><br>
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->