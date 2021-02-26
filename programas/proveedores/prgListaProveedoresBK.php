<?php

require("../../conexionmysqli.inc");
require("../../estilos_almacenes.inc");
require("../../function_web.php");
echo "<center>";

echo "<h3 class='text-muted'>Distribuidores</h3>";
echo "<table class='table table-bordered' id='tablaPrincipal'><thead>";
echo "<tr class='bg-principal'>";
echo "<th>&nbsp;</th><th>Nombre</th><th>Direccion</th><th>Telefono</th><th>Email</th><th>Contacto</th><th>Sta</th><th>Lineas</th>";
echo "</tr></thead><tbody>";
$consulta="
    SELECT p.cod_proveedor, p.nombre_proveedor, p.direccion, p.telefono1, p.telefono2, p.contacto
    FROM proveedores AS p 
    WHERE 1 = 1 ORDER BY p.nombre_proveedor ASC
";
$rs=mysqli_query($enlaceCon,$consulta);
$cont=0;

$listProv=obtenerListadoProveedoresWeb();
foreach ($listProv->lista as $proveedores) {
    $cont++;
    $codProv = $proveedores->idproveedor;
    $nomProv = $proveedores->des;
    $direccion = $proveedores->dir;
    $telefono1 = $proveedores->tel;
    $telefono2 = $proveedores->email;
    $contacto  = $proveedores->responsa;
    $sta  = $proveedores->sta;
    echo "<tr>";
    echo "<td><input type='checkbox' id='idchk$cont' value='$codProv' ></td><td>$nomProv</td><td>$direccion</td><td>$telefono1</td>
    <td>$telefono2</td><td>$contacto</td><td>$sta</td>";
    echo "<td><a href='navegadorLineasDistribuidores.php?codProveedor=$codProv'><img src='../../imagenes/detalle.png' width='40' title='Ver Lineas'></a></td>";
    echo "</tr>";
}
/*while($reg=mysqli_fetch_array($rs))
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
   }*/
echo "</tbody></table>";
echo "<input type='hidden' id='idtotal' value='$cont' >";
echo "</center>";

echo "<div class='divBotones'><input class='btn btn-warning text-white' type='button' value='Adicionar' onclick='javascript:frmAdicionar();'>
<input class='btn btn-warning text-white' type='button' value='Editar' onclick='javascript:frmModificar();'>
<input class='btn btn-danger' type='button' value='Eliminar' onclick='javascript:frmEliminar();'></div>";

?>
 <script type="text/javascript" src="../../dist/js/functionsGeneral.js"></script>