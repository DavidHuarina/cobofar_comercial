<?php

require("../../conexionmysqli.inc");
require("../../estilos_almacenes.inc");


echo "<br>";
echo "<center><h3>Clientes</h3></center>";

echo "<div class=''>
<input class='btn btn-primary' type='button' value='Adicionar' onclick='javascript:frmAdicionar();'>
<input class='btn btn-primary' type='button' value='Editar' onclick='javascript:frmModificar();'>
<input class='btn btn-danger' type='button' value='Eliminar' onclick='javascript:frmEliminar();'>
</div>";

echo "<center>";
echo "<table class='table table-bordered'>";
echo "<tr class='bg-info text-white'>";
echo "<th>&nbsp;</th><th>Cliente</th><th>NIT</th><th>Direccion</th><th>Ciudad</th>";
echo "</tr>";
$consulta="
    SELECT c.cod_cliente, c.nombre_cliente, c.nit_cliente, c.dir_cliente, c.cod_area_empresa, a.descripcion,c.paterno
    FROM clientes AS c INNER JOIN ciudades AS a ON c.cod_area_empresa = a.cod_ciudad 
    WHERE 1 = 1 ORDER BY c.nombre_cliente ASC
";
$rs=mysqli_query($enlaceCon,$consulta);
$cont=0;
while($reg=mysqli_fetch_array($rs))
   {$cont++;
    $codCliente = $reg["cod_cliente"];
    $nomCliente = $reg["nombre_cliente"]." ".$reg["paterno"];
    $patCliente = $reg["paterno"];
    $nitCliente = $reg["nit_cliente"];
    $dirCliente = $reg["dir_cliente"];
    $codArea = $reg["cod_area_empresa"];
    $nomArea = $reg["descripcion"];
    echo "<tr>";
    echo "<td><input type='checkbox' id='idchk$cont' value='$codCliente' ></td><td>$nomCliente</td><td>$nitCliente</td><td>$dirCliente</td><td>$nomArea</td>";
    echo "</tr>";
   }
echo "</table>";
echo "<input type='hidden' id='idtotal' value='$cont' >";
echo "</center>";

echo "<div class=''>
<input class='btn btn-primary' type='button' value='Adicionar' onclick='javascript:frmAdicionar();'>
<input class='btn btn-primary' type='button' value='Editar' onclick='javascript:frmModificar();'>
<input class='btn btn-danger' type='button' value='Eliminar' onclick='javascript:frmEliminar();'>
</div>";

?>
