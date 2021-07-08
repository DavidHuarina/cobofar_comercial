<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    COMERCIAL 
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="assets/autocomplete/awesomplete.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="assets/css/material-dashboard.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body class="">
<!--<div class="wrapper">-->
    <!--   Core JS Files   -->
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>

  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/jquery-ui.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="assets/js/plugins/jquery.dataTables.min.js"></script>
  <script src="assets/js/plugins/dataTables.fixedHeader.min.js"></script>

  <!--  Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="assets/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="assets/js/plugins/arrive.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!--script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script-->
  <!-- Chartist JS -->
  <script src="assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/material-dashboard.js?v=2.1.0"></script>
  <script src="assets/autocomplete/awesomplete.min.js"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/alerts/alerts.js"></script>

  <script src="assets/alerts/functionsGeneral.js"></script>

  <script src="assets/demo/demo.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
  
  <!--CHART GOOGLE-->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>




<div class="panel">
<!-- Navbar -->
      <nav class="navbar navbar-expand-sm navbar-transparent navbar-absolute fixed-top">
        <div class="container-fluid" style="background: #20C864">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-sm btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>
     
          </div>
 <?php
require_once 'conexionmysqli2.inc';
require_once 'funciones.php';
include("datosUsuario.php");
include("conexionmysqli2.inc");
$usuario=$_COOKIE["global_usuario"];
$link="indexVentas.php";
if($usuario==2||$usuario==1||$usuario==387||$usuario==392||$usuario==391||$usuario==8||$usuario==22||$usuario==21||$usuario==8){
        $link="indexReportes.php";
      }else{      
        if($cod_cargo==1000||$cod_cargo==1001 || $cod_cargo==1017 || $cod_cargo==1018){
         $link="indexGerencia.php";
        }
        if($cod_cargo==1002){
         $link="indexAlmacenReg.php";
        }
        if($cod_cargo==29||$cod_cargo==30||$cod_cargo==31||$cod_cargo==32||$cod_cargo==33||$cod_cargo==34||$usuario==33||$usuario==32||$usuario==31||$usuario==388||$usuario==29){
         $link="indexVentas.php";
        }    
      }
?>
<script type="text/javascript">
  function cambiarSucursalGlobal(codCiudad,sucursal){
   Swal.fire({
        title: "Sucursal " + sucursal,
        text: "¿Estas Seguro, <?=$nombreUsuarioSesion?>?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Entrar a "+sucursal,
        cancelButtonText: "No",
    })
    .then(resultado => {
        if (resultado.value) {
            var parametros={"cod_ciudad":codCiudad,"url":"<?=$link?>"};
            $.ajax({
              type: "POST",
              dataType: 'html',
              url: "saveSucursalSesion.php",
              data: parametros,
              success:  function (resp) { 
                $("#resp").html(resp);      
              }
          });
        } else {
            return false;
        }
    });
     
  }
</script>

<div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item"><h6 class="text-white">[<?=$nombreUsuarioSesion?>] COBOFAR - COMERCIAL</h6></li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons" style="color:#FFFFFF;">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="salir.php"><i class="material-icons" style="font-size: 16px" >logout</i> Salir</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
<!-- End Navbar -->
<section class="after-loop">
  <div class="login-page header-filter" filter-color="black" style="background-image: url('imagenes/login.jpg'); background-size: cover;   height:100%;" >
    <div class="container">
      <div class="div-center text-center text-white">
        <img src="imagenes/farmacias_bolivia1.gif" width="460" height="90" alt="">
        <h3><b><FONT FACE="Arial">Bienvenid@! <?=$nombreUsuarioSesion?></FONT></b></h3>
        <h5 class="">Seleccione la Sucursal con la que realizará las VENTAS el día de HOY </h5>
        <!--<h5 class="text-danger">Si no aparece la sucursal comuniquese con el departamento de sistemas.</h5>-->
      </div>
      <div class="row">
        <?php
        $sqlAgencias = "SELECT distinct f.cod_ciudad,(SELECT nombre_almacen from almacenes where cod_ciudad=f.cod_ciudad and cod_tipoalmacen=1 LIMIT 1)almacen,(select fecha from salida_almacenes where cod_almacen in (SELECT cod_almacen from almacenes where cod_ciudad=f.cod_ciudad) and cod_chofer='".$_COOKIE["global_usuario"]."' and cod_tiposalida='1001' order by fecha desc limit 1)ultimaventa FROM `funcionarios_agencias` f where f.codigo_funcionario='".$_COOKIE["global_usuario"]."' ORDER BY 3 desc;";
        //echo $sqlAgencias;
        $temas=["card-themes","card-snippets text-dark","card-templates","card-guides"];
        $resp = mysqli_query($enlaceCon,$sqlAgencias);
        $ind=0;
        while($detalle=mysqli_fetch_array($resp)){
          $ind++;
          if($ind%1==0){
            $estilo=$temas[0];
          }
          if($ind%2==0){
            $estilo=$temas[1];
          }
          if($ind%3==0){
            $estilo=$temas[2];
           
          }
          if($ind%4==0){
            $estilo=$temas[3];

          }
          if($ind%6==0){

          }
          $codCiudad=$detalle[0];
          $nombreCiudad=$detalle[1];
          if($detalle[2]!=""){
            $ultimaVenta="Ultima Venta ".strftime('%d/%m/%Y',strtotime($detalle[2]));            
          }else{
            $ultimaVenta="SIN VENTAS";
          }          
        ?>
        <div class="col-lg-3 col-md-8 mb-5 mb-lg-0 mx-auto">
         <a href="#" class="after-loop-item card border-0 <?=$estilo?> shadow-lg" onclick="cambiarSucursalGlobal('<?=$codCiudad?>','<?=$nombreCiudad?>');return false;">
            <div class="card-body d-flex align-items-end flex-column text-right">
               <h3><b><?=$nombreCiudad?></b></h3>
               <p class="w-85 text-small"><?=$ultimaVenta?></p>
               <i class="material-icons">store_mall_directory</i>
            </div>
         </a>
        </div>  
        <?php }
        ?>  
      </div>
      <div id="resp"></div> 
      <br><br><br><br><br><br><br><br>
    </div>
  </div>
</section>
</div><!-- el div que abre se encuentra dentro de cabecera al principio de NavBar Como en la documentación-->    
    </div>
   </div> 
   <?php 
  //poner aqui librerias
if(!isset($_GET['opcion'])){
  ?><script type="text/javascript">
           $(document).ready(function(e) { 
               $("#minimizeSidebar").click()
               $("#minimizeSidebar").addClass("d-none");
             });
    </script><?php
}else{
  if(isset($_GET['q'])){
    ?><script type="text/javascript">
           $(document).ready(function(e) { 
               $("#minimizeSidebar").click()
               $("#minimizeSidebar").addClass("d-none");
             });
    </script><?php
  }
}

?>
</body>
</html>
<?php