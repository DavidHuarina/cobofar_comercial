<?php

require("../../conexionmysqli.inc");
//require("../../estilos_almacenes.inc");
?>
<div class="content">
    <div class="container-fluid">

        <div class="col-md-12">
          <form id="" class="form-horizontal" action="" method="post">
            <div class="card">
              <div class="card-header card-header-warning card-header-text">
                <div class="card-text">
                  <h4 class="card-title">Distribuidores</h4>
                </div>
              </div>
              <div class="card-body ">
                <?php
echo "<table class='table table-bordered' id='tablaPrincipal'><thead>";
echo "<tr class='bg-principal'>";
echo "<th>&nbsp;</th><th>Nombre</th><th>Direccion</th><th>Telefono 1</th><th>Telefono 2</th><th>Contacto</th><th>Lineas</th>";
echo "</tr></thead><tbody>";
$consulta="
    SELECT p.cod_proveedor, p.nombre_proveedor, p.direccion, p.telefono1, p.telefono2, p.contacto
    FROM proveedores AS p 
    WHERE 1 = 1 ORDER BY p.nombre_proveedor ASC
";
$rs=mysqli_query($enlaceCon,$consulta);
$cont=0;
while($reg=mysqli_fetch_array($rs))
   {$cont++;
    $codProv = $reg["cod_proveedor"];
    $nomProv = $reg["nombre_proveedor"];
    $direccion = $reg["direccion"];
    $telefono1 = $reg["telefono1"];
    $telefono2 = $reg["telefono2"];
    $contacto  = $reg["contacto"];
    echo "<tr>";
    echo "<td><input type='checkbox' id='idchk$cont' value='$codProv' ></td><td>$nomProv</td><td>$direccion</td><td>$telefono1</td>
    <td>$telefono2</td><td>$contacto</td>";
    echo "<td><a href='navegadorLineasDistribuidores.php?codProveedor=$codProv'><img src='../../imagenes/detalle.png' width='40' title='Ver Lineas'></a></td>";
    echo "</tr>";
   }
echo "</tbody></table>";
echo "<input type='hidden' id='idtotal' value='$cont' >";
echo "</center>";

?>
              </div>
              <div  class="card-footer fixed-bottom">
                <div class=''><input class='btn btn-primary' type='button' value='Adicionar' onclick='javascript:frmAdicionar();'>
<input class='btn btn-primary' type='button' value='Editar' onclick='javascript:frmModificar();'>
<input class='btn btn-danger' type='button' value='Eliminar' onclick='javascript:frmEliminar();'></div>
              </div>
            </div>
          </form>
        </div>
    
    </div>
</div>
 <script type="text/javascript" src="../../dist/js/functionsGeneral.js"></script>