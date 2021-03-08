<?php

require("../../conexionmysqli.inc");
require("../../estilos_almacenes.inc");

$codCliente = $_GET["codcli"];
$nomCliente = "";
$nitCliente = "";
$dirCliente = "";
$telefono1  = "";
$email      = "";
$codArea    = "";
$nomFactura = "";
$nomArea    = "";
$cadComboCiudad = "";
$consulta="
    SELECT c.cod_cliente, c.nombre_cliente, c.nit_cliente, c.dir_cliente, c.telf1_cliente, c.email_cliente, c.cod_area_empresa, c.nombre_factura, a.cod_ciudad, a.descripcion
    FROM clientes AS c INNER JOIN ciudades AS a ON c.cod_area_empresa = a.cod_ciudad
    WHERE c.cod_cliente = $codCliente ORDER BY c.nombre_cliente ASC
";
$rs=mysqli_query($enlaceCon,$consulta);
$nroregs=mysqli_num_rows($rs);
if($nroregs==1)
   {$reg=mysqli_fetch_array($rs);
    //$codCliente = $reg["cod_cliente"];
    $nomCliente = $reg["nombre_cliente"];
    $nitCliente = $reg["nit_cliente"];
    $dirCliente = $reg["dir_cliente"];
    $telefono1  = $reg["telf1_cliente"];
    $email      = $reg["email_cliente"];
    $codArea    = $reg["cod_area_empresa"];
    $nomFactura = $reg["nombre_factura"];
    $nomArea    = $reg["descripcion"];
    $consulta="SELECT c.cod_ciudad, c.descripcion FROM ciudades AS c WHERE 1 = 1 ORDER BY c.descripcion ASC";
    $rs=mysqli_query($enlaceCon,$consulta);
    while($reg=mysqli_fetch_array($rs))
       {$codCiudad = $reg["cod_ciudad"];
        $nomCiudad = $reg["descripcion"];
        if($codArea==$codCiudad) {
            $cadComboCiudad=$cadComboCiudad."<option value='$codCiudad' selected>$nomCiudad</option>";
        } else {
            $cadComboCiudad=$cadComboCiudad."<option value='$codCiudad'>$nomCiudad</option>";
        }
       }
   }

?>
<script type='text/javascript' language='javascript'>

/*proceso inicial*/
function listadoClientes() {
     location.href="inicioClientes.php";
}


function modificarCliente() {
    var codcli = $("#codcli").text();
    var nomcli = $("#nomcli").val();
    var nit = $("#nit").val();
    var dir = $("#dir").val();
    var tel1 = $("#tel1").val();
    var mail = $("#mail").val();
    var area = $("#area").val();
    var fact = $("#fact").val();
    var parms="codcli="+codcli+"&nomcli="+nomcli+"&nit="+nit+"&dir="+dir+"&tel1="+tel1+"&mail="+mail+"&area="+area+"&fact="+fact+"";
    location.href="prgClienteModificar.php?"+parms;
}

        </script>
<center>
    <br/>
    <h1>Editar Cliente</h1>
    <table class="table table-sm">
        <tr class="bg-info text-white">
            <th>Codigo</th>
            <th>Cliente</th>
            <th>NIT</th>
            <th>Direccion</th>
            <th>Telefono</th>
        </tr>
        <tr>
            <td><span id="codcli"><?php echo "$codCliente"; ?></span></td>
            <td><input class="form-control" type="text" id="nomcli" value="<?php echo "$nomCliente"; ?>"/></td>
            <td><input class="form-control" type="text" id="nit" value="<?php echo "$nitCliente"; ?>"/></td>
            <td><input class="form-control" type="text" id="dir" value="<?php echo "$dirCliente"; ?>"/></td>
            <td><input class="form-control" type="text" id="tel1" value="<?php echo "$telefono1"; ?>"/></td>
        </tr>
        <tr class="text-white bg-info">
            <th>Correo</th>
            <th>Factura</th>
            <th colspan="3">Ciudad</th>
        </tr>
        <tr>
            <td><input class="form-control" type="text" id="mail" value="<?php echo "$email"; ?>"/></td>
            <td><input class="form-control" type="text" id="fact" value="<?php echo "$nomFactura"; ?>"/></td>
            <td colspan="3"><select id="area" class="selectpicker form-control"><?php echo "$cadComboCiudad"; ?></select></td>
        </tr>
    </table>
    <br/>
    <input class='btn btn-primary' type="button" value="Modificar" onclick="javascript:modificarCliente();" />
    <input class='btn btn-danger' type="button" value="Cancelar" onclick="javascript:listadoClientes();" />
    <br/>
</center>
