<?php

require("../../conexionmysqli.inc");
require("../../estilos_almacenes.inc");


$codCliente = "";
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

$cadComboCiudad = "";
$consulta="SELECT c.cod_ciudad, c.descripcion FROM ciudades AS c WHERE 1 = 1 ORDER BY c.descripcion ASC";
$rs=mysqli_query($enlaceCon,$consulta);
while($reg=mysqli_fetch_array($rs))
   {$codCiudad = $reg["cod_ciudad"];
    $nomCiudad = $reg["descripcion"];
    $cadComboCiudad=$cadComboCiudad."<option value='$codCiudad'>$nomCiudad</option>";
   }

   $cadComboEdad = "";
$consultaEdad="SELECT c.codigo,c.nombre, c.abreviatura FROM tipos_edades AS c WHERE c.estado = 1 ORDER BY 1";
$rs=mysqli_query($enlaceCon,$consultaEdad);
while($reg=mysqli_fetch_array($rs))
   {$codigoEdad = $reg["codigo"];
    $nomEdad = $reg["abreviatura"];
    $desEdad = $reg["nombre"];
    $cadComboEdad=$cadComboEdad."<option value='$codigoEdad'>$nomEdad ($desEdad)</option>";
   }

$cadTipoPrecio="";
$consulta1="select t.`codigo`, t.`nombre` from `tipos_precio` t";
$rs1=mysqli_query($enlaceCon,$consulta1);
while($reg1=mysqli_fetch_array($rs1))
   {$codTipo = $reg1["codigo"];
    $nomTipo = $reg1["nombre"];
    $cadTipoPrecio=$cadTipoPrecio."<option value='$codTipo'>$nomTipo</option>";
   }

  
?>
<link rel="stylesheet" type="text/css" href="../../dist/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../../dist/bootstrap/dataTables.bootstrap4.min.css"/>
        <script type="text/javascript" src="../../dist/bootstrap/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="../../dist/bootstrap/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../../dist/bootstrap/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="../lib/js/xlibPrototipo-v0.1.js"></script>
        <link rel="stylesheet" href="selectpicker/dist/css/bootstrap-select.css">
        <link rel="stylesheet" type="text/css" href="../../dist/css/micss.css"/>
        <link rel="stylesheet" type="text/css" href="../../dist/demo.css"/>
<center>
    <br/>
    <h1>Adicionar Cliente</h1>
	
    <table class="texto">
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>CI</th>
            <th>NIT</th>
            <th>Direccion</th>
            <th>Telefono</th>
        </tr>
        <tr>
            <td><span id="id" style="display:none"><?php echo "$codCliente"; ?></span><input type="text" class="form-control "id="nomcli" value="<?php echo "$nomCliente"; ?>"/></td>
            <td><input type="text" autocomplete="off" class="form-control "id="apcli" value="<?php echo "$apCliente"; ?>"/></td>
            <td><input type="text" class="form-control "id="ci" value="<?php echo "$ciCliente"; ?>"/></td>
            <td><input type="text" class="form-control "id="nit" value="<?php echo "$nitCliente"; ?>"/></td>
            <td><input type="text" class="form-control "id="dir" value="<?php echo "$dirCliente"; ?>"/></td>
            <td><input type="text" class="form-control "id="tel1" value="<?php echo "$telefono1"; ?>"/></td>
        </tr>
        <tr>
            <th>Correo</th>
            <th>Factura</th>
            <th>Sucursal</th>
            <th>Edad</th>
            <th></th>
        </tr>
        <tr>
            <td><input type="text" class="form-control "id="mail" value="<?php echo "$email"; ?>"/></td>
            <td><input type="text" class="form-control "id="fact" value="<?php echo "$nomFactura"; ?>"/></td>
            <td><select class='selectpicker show-menu-arrow form-control-sm' data-style='btn-info' id="area"><?php echo "$cadComboCiudad"; ?></select></td>
            <td><select class='selectpicker show-menu-arrow form-control-sm' data-style='btn-info' name="edad"id="edad"><?php echo "$cadComboEdad"; ?></select></td>
            <td></td>
        </tr>
    </table>
    <br/>
	<div class="divBotones">
		<input class="boton" type="button" value="Guardar" onclick="javascript:adicionarCliente();" />
		<input class="boton2" type="button" value="Cancelar" onclick="javascript:listadoClientes();" />
	</div>
    <br/>
</center>
<script src="../../dist/selectpicker/dist/js/bootstrap-select.js"></script>
 <script type="text/javascript" src="../../dist/js/functionsGeneral.js"></script>