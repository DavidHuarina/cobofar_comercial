<html>
    <head>
        <title>Clientes</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
<?php
require("../../conexionmysqli.inc");
//require("../../estilos_almacenes.inc");

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

$cadComboGenero="";
$consult="select t.`cod_genero`, t.`descripcion` from `generos` t where cod_estadoreferencial=1";
$rs1=mysqli_query($enlaceCon,$consult);
while($reg1=mysqli_fetch_array($rs1))
   {$codTipo = $reg1["cod_genero"];
    $nomTipo = $reg1["descripcion"];
    $cadComboGenero=$cadComboGenero."<option value='$codTipo'>$nomTipo</option>";
   }
?>
<script type='text/javascript' language='javascript'>



function listadoClientes() {
     location.href="inicioClientes.php";
}
function adicionarCliente() {
    var nomcli = $("#nomcli").val();
    var apcli = $("#apcli").val();
    var ci = $("#ci").val();
    var nit = $("#nit").val();
    var dir = $("#dir").val();
    var tel1 = $("#tel1").val();
    var mail = $("#mail").val();
    var area = $("#area").val();
    var fact = $("#fact").val();
    var edad = $("#edad").val();
    var genero = $("#genero").val();
    var parms="nomcli="+nomcli+"&nit="+nit+"&ci="+ci+"&dir="+dir+"&tel1="+tel1+"&mail="+mail+"&area="+area+"&fact="+fact+"&edad="+edad+"&apcli="+apcli+"&genero="+genero+"";
    location.href="prgClienteAdicionar.php?"+parms;
}


        </script>
<div class="content">
    <div class="container-fluid">

        <div class="col-md-12">
          <!--<form id="form" class="form-horizontal" action="" method="post">-->
            <div class="card">
              <div class="card-header card-header-info card-header-text">
                <div class="card-text">
                  <h4 class="card-title">Registrar Cliente</h4>
                </div>
              </div>
              <span id="id" style="display:none"><?php echo "$codCliente"; ?></span>
              <div class="card-body ">
                <div class="row">
                  <label class="col-sm-2 col-form-label">Nombre</label>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <input class="form-control" type="text" id="nomcli" required value="<?php echo "$nomCliente"; ?>"/>
                    </div>
                  </div>
                  <label class="col-sm-1 col-form-label">Apellidos</label>
                  <div class="col-sm-5">
                    <div class="form-group">
                      <input class="form-control" type="text" id="apcli" value="<?php echo "$apCliente"; ?>" required/>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <label class="col-sm-2 col-form-label">CI</label>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <input class="form-control" type="text" id="ci" value="<?php echo "$ciCliente"; ?>"required/>
                    </div>
                  </div>
                  <label class="col-sm-1 col-form-label">NIT</label>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <input class="form-control" type="text" id="nit" value="<?php echo "$nitCliente"; ?>" required/>
                    </div>
                  </div>
                  <label class="col-sm-1 col-form-label">Teléfono</label>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input class="form-control" type="text" id="tel1" value="<?php echo "$telefono1"; ?>" required/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Dirección</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" type="text" id="dir" value="<?php echo "$dirCliente"; ?>" required/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" type="email" id="mail" value="<?php echo "$email"; ?>" required/>
                    </div>
                  </div>
                  <label class="col-sm-1 col-form-label">Factura</label>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input class="form-control" type="text" id="fact" value="<?php echo "$nomFactura"; ?>" required/>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <label class="col-sm-2 col-form-label">Género</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <select class="selectpicker form-control" name="genero"id="genero" data-style="btn btn-primary" data-live-search="true" required>
                           <?php echo "$cadComboGenero"; ?>
                       </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Edad</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <select class="selectpicker form-control" name="edad"id="edad" data-style="btn btn-warning" data-live-search="true" required>
                          <?php echo "$cadComboEdad"; ?>
                       </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Sucursal</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <select class="selectpicker form-control" id="area" data-style="btn btn-warning" data-live-search="true" required>
                          <?php echo "$cadComboCiudad"; ?>
                       </select>
                    </div>
                  </div>
                </div>
                <br><br>
              </div>
              <div  class="card-footer fixed-bottom">
                <div class="">
                <input class="btn btn-success" type="button" value="Guardar" onclick="javascript:adicionarCliente();" />
                 <input class="btn btn-danger" type="button" value="Cancelar" onclick="javascript:listadoClientes();" />
             </div>
              </div>
            </div>
         
        </div>
    
    </div>
</div>
 </body>    
 </html>