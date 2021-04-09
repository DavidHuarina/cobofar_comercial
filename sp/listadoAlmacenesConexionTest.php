<?php
require_once __DIR__.'/../conexion_externa_farma.php';
require '../conexionmysqli.inc';
require_once '../function_web.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title>CONEXION SUCURSALES</title>
	<meta charset="utf-8">
    <style type="text/css">
        .bg-conexion{
            /*background-image: url('../imagenes/conexion.jpg');*/
             width: 100%; height: 100vh; 
        }
    </style>
    <script type="text/javascript">
      function hacerPing(ip,fila){
        var parametros={"ip":ip};
         $.ajax({
           type: "GET",
           dataType: 'html',
           url: "ajaxPing.php",
           data: parametros,
           beforeSend: function(){
             $("#ping"+fila).html("...");
           },
           success:  function (resp) {
             $("#ping"+fila).html(resp);          
          }
        });
      }

    </script>
</head>
<body class="bg-conexion">
<br><br>
<center><h3 style='color: #9F2207;'><b>TEST SUCURSALES</b></h3></center>

<center>
    <p>Hora de inicio de consulta:<?=date("d/m/Y H:i")?></p>
<hr>
<br>
<div class="col-sm-10 div-center">
<div id='tabla_pie'></div>
<table class="table table-sm table-bordered table-condensed">
    <tr class="bg-info text-white" style="background: #9F2207 !important;">
        <td>N.</td>
        <td>AGE1</td>
        <td>CORTO</td>
        <td>NOMBRE</td>
        <td>IP</td>
        <td width="30%">PING</td>
        <td>ESTADO</td>
        <td></td>
    </tr>
<?php
$listAlma=obtenerListadoAlmacenes();//web service
$contador=0;$contadorError=0;
foreach ($listAlma->lista as $alma) {
    $contador++;
    $corto=$alma->corto;
	$age1=$alma->age1;
	$nombre=$alma->des;
	$direccion=$alma->direc;
	$age=$alma->age;
	$ip=$alma->ip;
	$tipo=1;// TIPO DE CIUDAD
    $estado=1;
    if($alma->tipo=="E"){
    	$estado=2;
    }
    
    //CONEXION TEST
    $dbh = new ConexionFarma();
    $dbh->setHost($ip);
    $verificarCon=$dbh->start();
    $estadoHtml="";$estiloFondo="";
    if($verificarCon==true){
        $estadoHtml="<i class='material-icons text-success'>check</i>";
    }else{
        $contadorError++;
        $estadoHtml="<i class='material-icons text-danger'>close</i>";
        $estiloFondo="bg-warning text-dark";
    }
    ?>
    <tr class="<?=$estiloFondo?>">
        <td><?=$contador?></td>
        <td><?=utf8_decode($age1)?></td>
        <td><?=$corto?></td>
        <td><?=$nombre?></td>
        <td><?=$ip?></td>
        <td><div id="ping<?=$contador?>" style="font-size: 14px;"></div></td>
        <td><?=$estadoHtml?></td>
        <td><a href="#" onclick="hacerPing('<?=$ip?>','<?=$contador?>');return false;" class="btn btn-warning btn-sm">PING</a></td>
    </tr>
    <?php
}
?>
  <tr class="bg-info text-white" style="background: #9F2207 !important;">
        <td>N.</td>
        <td>AGE1</td>
        <td>CORTO</td>
        <td>NOMBRE</td>
        <td>IP</td>
        <td width="30%">PING</td>
        <td>ESTADO</td>
        <td></td>
    </tr>
</table>
<?php 
$htmlPie='<div id="pie_sucursal"><table class="table table-sm table-bordered table-condensed">
    <tr><td class="font-weight-bold text-dark" style="background: #ABABAB;text-align:left;">TOTAL SUCURSALES</td><td>'.$contador.'</td></tr>
    <tr><td class="font-weight-bold bg-info text-dark" style="background: #ABABAB  !important;text-align:left;">TOTAL CONEXIONES CON ERRORES</td><td>'.$contadorError.'</td></tr>
    <tr><td class="font-weight-bold bg-info text-dark" style="background: #ABABAB !important;text-align:left;">TOTAL CONEXIONES EXITOSAS</td><td>'.($contador-$contadorError).'</td></tr>
</table></div>';
echo $htmlPie;
?>
</div>
<script type="text/javascript">
    $( document ).ready(function() {
      $("#tabla_pie").html($("#pie_sucursal").html());
      $('#ejemplo').dataTable({
        "bPaginate": false, //Ocultar paginación
      })
    }); 
</script>
<br><br>
<p>Hora de fin de consulta:<?=date("d/m/Y H:i")?></p>
 </center>

</body>
</html>
