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
                  <h4 class="card-title">Clientes</h4>
                </div>
              </div>
              <div class="card-body ">
                <?php
echo "<center>";
echo "<table class='table table-bordered' id='tablaPrincipal'><thead>";
echo "<tr class='bg-principal'>";
echo "<th>&nbsp;</th><th>Cliente</th><th>NIT</th><th>Direccion</th><th>Ciudad</th>";
echo "</tr></thead><tbody>";
$consulta="
    SELECT c.cod_cliente, c.nombre_cliente,c.paterno, c.nit_cliente, c.dir_cliente, c.cod_area_empresa, a.descripcion
    FROM clientes AS c INNER JOIN ciudades AS a ON c.cod_area_empresa = a.cod_ciudad 
    WHERE 1 = 1 ORDER BY c.nombre_cliente ASC
";
$rs=mysqli_query($enlaceCon,$consulta);
$cont=0;
while($reg=mysqli_fetch_array($rs))
   {$cont++;
    $codCliente = $reg["cod_cliente"];
    $nomCliente = $reg["nombre_cliente"]." ".$reg["paterno"];
    $nitCliente = $reg["nit_cliente"];
    $dirCliente = $reg["dir_cliente"];
    $codArea = $reg["cod_area_empresa"];
    $nomArea = $reg["descripcion"];
    echo "<tr>";
    echo "<td><input type='checkbox' id='idchk$cont' value='$codCliente' ></td><td>$nomCliente</td><td>$nitCliente</td><td>$dirCliente</td><td>$nomArea</td>";
    echo "</tr>";
   }
echo "</tbody></table>";
echo "<input type='hidden' id='idtotal' value='$cont' >";
echo "</center>";

?>
              </div>
              <div  class="card-footer fixed-bottom">
                <div class=''>
<input class='btn btn-primary' type='button' value='Adicionar' onclick='javascript:frmAdicionar();'>
<input class='btn btn-primary' type='button' value='Editar' onclick='javascript:frmModificar();'>
<input class='btn btn-danger' type='button' value='Eliminar' onclick='javascript:frmEliminar();'>
</div>
              </div>
            </div>
          </form>
        </div>
    
    </div>
</div>

 <script type="text/javascript" src="../../dist/js/functionsGeneral.js"></script>
