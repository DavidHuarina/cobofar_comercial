<html>
    <head>
        <title>Clientes</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
<?php

require("../../conexionmysqli.inc");
require("../../estilos_almacenes.inc");

$codCliente = $_GET["codcli"];
$nomCliente = "";
$apCliente = "";
$ciCliente = "";
$nitCliente = "";
$dirCliente = "";
$telefono1  = "";
$email      = "";
$codArea    = "";
$nomFactura = "";
$nomArea    = "";
$tipoEdad="";
$tipoGenero="";
$tipoPrecioX="";
$cadComboCiudad = "";
$consulta="
    SELECT c.cod_cliente, c.nombre_cliente,c.paterno,c.ci_cliente,c.cod_tipo_edad,c.cod_genero,c.cod_tipo_precio, c.nit_cliente, c.dir_cliente, c.telf1_cliente, c.email_cliente, c.cod_area_empresa, c.nombre_factura, a.cod_ciudad, a.descripcion
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
    $apCliente    = $reg["paterno"];
    $ciCliente    = $reg["ci_cliente"];
    $tipoEdad    = $reg["cod_tipo_edad"];
    $tipoPrecioX    = $reg["cod_tipo_precio"];
    $tipoGenero    = $reg["cod_genero"];
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
$cadComboEdad = "";
$consultaEdad="SELECT c.codigo,c.nombre, c.abreviatura FROM tipos_edades AS c WHERE c.estado = 1 ORDER BY 1";
$rs=mysqli_query($enlaceCon,$consultaEdad);
while($reg=mysqli_fetch_array($rs))
   {$codigoEdad = $reg["codigo"];
    $nomEdad = $reg["abreviatura"];
    $desEdad = $reg["nombre"];
    if($tipoEdad==$codigoEdad) {
        $cadComboEdad=$cadComboEdad."<option value='$codigoEdad' selected>$nomEdad ($desEdad)</option>";
    } else {
        $cadComboEdad=$cadComboEdad."<option value='$codigoEdad'>$nomEdad ($desEdad)</option>";
    }
  }

   $cadTipoPrecio="";
$consulta1="select t.`codigo`, t.`nombre` from `tipos_precio` t";
$rs1=mysqli_query($enlaceCon,$consulta1);
while($reg1=mysqli_fetch_array($rs1))
   {$codTipo = $reg1["codigo"];
    $nomTipo = $reg1["nombre"];
    if($tipoPrecioX==$codTipo) {
        $cadTipoPrecio=$cadTipoPrecio."<option value='$codTipo' selected>$nomTipo</option>";
    } else {
        $cadTipoPrecio=$cadTipoPrecio."<option value='$codTipo'>$nomTipo</option>";
    }
   }

$cadComboGenero="";
$consult="select t.`cod_genero`, t.`descripcion` from `generos` t where cod_estadoreferencial=1";
$rs1=mysqli_query($enlaceCon,$consult);
while($reg1=mysqli_fetch_array($rs1))
   {$codTipo = $reg1["cod_genero"];
    $nomTipo = $reg1["descripcion"];
    if($tipoGenero==$codTipo) {
        $cadComboGenero=$cadComboGenero."<option value='$codTipo' selected>$nomTipo</option>";
    } else {
        $cadComboGenero=$cadComboGenero."<option value='$codTipo'>$nomTipo</option>";
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
    var apcli = $("#apcli").val();
    var ci = $("#ci").val();
    var nit = $("#nit").val();
    var dir = $("#dir").val();
    var tel1 = $("#tel1").val();
    var mail = $("#mail").val();
    var edad = $("#edad").val();
    var genero = $("#genero").val();
    var area = $("#area").val();
    var fact = $("#fact").val();
    var parms="codcli="+codcli+"&nomcli="+nomcli+"&nit="+nit+"&dir="+dir+"&tel1="+tel1+"&mail="+mail+"&area="+area+"&fact="+fact+"&apcli="+apcli+"&ci="+ci+"&edad="+edad+"&genero="+genero+"";
    location.href="prgClienteModificar.php?"+parms;
}

        </script>
<center>
    <br/>
    <center><h3>Editar Cliente</h3></center>
    <table class="table table-sm">
        <tr class="bg-info text-white">
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>CI</th>
            <th>NIT</th>
            <th colspan="2">Direccion</th>            
        </tr>
        <tr>
            <td><span id="codcli"><?php echo "$codCliente"; ?></span></td>
            <td><input class="form-control" type="text" id="nomcli" value="<?php echo "$nomCliente"; ?>"/></td>
            <td><input class="form-control" type="text" id="apcli" value="<?php echo "$apCliente"; ?>"/></td>
            <td><input class="form-control" type="text" id="ci" value="<?php echo "$ciCliente"; ?>"/></td>
            <td><input class="form-control" type="text" id="nit" value="<?php echo "$nitCliente"; ?>"/></td>
            <td colspan="2"><input class="form-control" type="text" id="dir" value="<?php echo "$dirCliente"; ?>"/></td>
            
        </tr>
        <tr class="text-white bg-info">
            <th>Telefono</th>
            <th>Correo</th>
            <th>Factura</th>
            <th>Edad</th>
            <th>Género</th>
            <th colspan="2">Sucursal</th>
        </tr>
        <tr>
            <td><input class="form-control" type="text" id="tel1" value="<?php echo "$telefono1"; ?>"/></td>
            <td><input class="form-control" type="text" id="mail" value="<?php echo "$email"; ?>"/></td>
            <td><input class="form-control" type="text" id="fact" value="<?php echo "$nomFactura"; ?>"/></td>
            <td><select id="edad" class="selectpicker form-control"><?php echo "$cadComboEdad"; ?></select></td>
            <td><select id="genero" class="selectpicker form-control"><?php echo "$cadComboGenero"; ?></select></td>
            <td colspan="2"><select id="area" class="selectpicker form-control"><?php echo "$cadComboCiudad"; ?></select></td>
        </tr>
    </table>
    <br/>
    <input class='btn btn-primary' type="button" value="Modificar" onclick="javascript:modificarCliente();" />
    <input class='btn btn-danger' type="button" value="Cancelar" onclick="javascript:listadoClientes();" />
    <br/>
</center>
</body>
</html>