<script language='Javascript'>
		function enviar_nav(codProveedor)
		{	location.href='registrarLineaDistribuidor.php?codProveedor='+codProveedor;
		}
		
		function editar_nav(f, codProveedor)
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
			{	alert('Debe seleccionar solamente un registro.');
			}
			else
			{
				if(j==0)
				{
					alert('Debe seleccionar un registro.');
				}
				else
				{
					location.href='editarLineaDistribuidor.php?codigo_registro='+j_cod_registro+'&codProveedor='+codProveedor;
				}
			}
		}
		
		function eliminar_nav(f, codProveedor)
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
			{	alert('Debe seleccionar al menos una Linea para eliminar.');
			}
			else
			{
				if(confirm('Esta seguro de eliminar los datos.'))
				{
					location.href='eliminarLineaDistribuidor.php?codProveedor='+codProveedor+'&datos='+datos+'';
				}
				else
				{
					return(false);
				}
			}
		}
		</script>
<?php

require("../../conexionmysqli.inc");
//require("../../estilos_almacenes.inc");
require("../../funcion_nombres.php");
echo "<link rel='stylesheet' type='text/css' href='../../stilos.css'/>";
?>
        <link rel="stylesheet" type="text/css" href="../../dist/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../../dist/bootstrap/dataTables.bootstrap4.min.css"/>
        <script type="text/javascript" src="../../dist/bootstrap/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="../../dist/bootstrap/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../../dist/bootstrap/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="../../lib/js/xlibPrototipo-v0.1.js"></script>
        <link rel="stylesheet" type="text/css" href="../../dist/css/micss.css"/>
<?php
$codProveedor=$_GET['codProveedor'];
$nombreProveedor=nombreProveedor($codProveedor);
?>
<div class="content">
    <div class="container-fluid">
        <div class="col-md-12">
          <form id="" class="form-horizontal" action="" method="post">
            <div class="card">
              <div class="card-header card-header-warning card-header-text">
                <div class="card-text">
                  <h4 class="card-title">Lineas de Distribuidor  <?=$nombreProveedor?></h4>
                </div>
              </div>
              <div class="card-body ">
                <?php
echo "<table class='table table-bordered' id='tablaPrincipal'><thead>";
echo "<tr class='bg-principal'>";
echo "<th>&nbsp;</th><th>Linea</th><th>Abreviatura</th><th>Procedencia</th><th>Margen de precio</th><th>Contacto 1</th><th>Contacto 2</th>";
echo "</tr></thead><tbody>";
$consulta="select p.cod_linea_proveedor, p.nombre_linea_proveedor, p.abreviatura_linea_proveedor, p.contacto1, 
	p.contacto2, (select t.nombre_procedencia from tipos_procedencia t where t.cod_procedencia=p.cod_procedencia), 
	margen_precio
	from proveedores_lineas p where p.cod_proveedor=$codProveedor and estado=1";

$rs=mysqli_query($enlaceCon,$consulta);

$cont=0;
while($reg=mysqli_fetch_array($rs)){
	$cont++;
    $codLinea = $reg["cod_linea_proveedor"];
    $nombreLinea = $reg["nombre_linea_proveedor"];
    $contacto1 = $reg["contacto1"];
    $contacto2 = $reg["contacto2"];
    $abreviatura = $reg["abreviatura_linea_proveedor"];
	$procedencia=$reg[5];
	$margenPrecio=$reg[6];
    echo "<tr>";
    echo "<td><input type='checkbox' id='$codLinea' value='$codLinea' ></td><td>$nombreLinea</td><td>$abreviatura</td>
	<td>$procedencia</td><td>$margenPrecio</td>
	<td>$contacto1</td><td>$contacto2</td>";
    echo "</tr>";
   }
echo "</table></tbody></table>";
echo "</center>";

echo "";


?>
              </div>
              <div  class="card-footer fixed-bottom">
               <div class=''><input class='btn btn-primary' type='button' value='Adicionar' onClick='enviar_nav($codProveedor);'>
<input class='btn btn-primary' type='button' value='Editar' onClick='editar_nav(this.form, $codProveedor);'>
<input class='btn btn-danger' type='button' value='Eliminar' onClick='eliminar_nav(this.form, $codProveedor)'>
<input class='btn btn-danger' type='button' value='Cancelar' onClick='location.href=(\"inicioProveedores.php\");'>
</div>
            </div>
          </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../dist/js/functionsGeneral.js"></script>