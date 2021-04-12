<html>
<head>
  <meta charset="utf-8" />
  <title>Farmacias Bolivia</title>
    <link rel="shortcut icon" href="imagenes/icon_farma.ico" type="image/x-icon">
  <link type="text/css" rel="stylesheet" href="menuLibs/css/demo.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<body>
<?php
require_once '../conexionmysqli.inc';
require_once 'configModule.php';
require_once '../funciones.php';

$sql=mysqli_query($enlaceCon,"SELECT n.nombre, n.abreviatura,n.desde,n.hasta,e.nombre as estado,n.monto_inicio,n.monto_final from $table n join estados_descuentos e on e.codigo=n.cod_estadodescuento where n.codigo=$codigo_registro");
$dat=mysqli_fetch_array($sql);

$nombre=$dat[0];
$abreviatura=$dat[1];
$desde=strftime('%Y-%m-%d',strtotime($dat[2]));
$hasta=strftime('%Y-%m-%d',strtotime($dat[3]));
$desdeFormato=strftime('%d/%m/%Y',strtotime($dat[2]));
$hastaFormato=strftime('%d/%m/%Y',strtotime($dat[3]));
$desde_hora=strftime('%H:%M',strtotime($dat[2]));
$hasta_hora=strftime('%H:%M',strtotime($dat[3]));
$estado=$dat['estado'];
$monto_inicio=$dat['monto_inicio'];
$monto_final=$dat['monto_final'];
$desdeMonto=number_format($monto_inicio,2,'.',',');
$hastaMonto=number_format($monto_final,2,'.',',');
?>
<div id="logo_carga" class="logo-carga" style="display:none;"></div>
<div class="content">
	<div id="contListaGrupos" class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
			  <div class="card">
				<div class="card-header card-header-deafult card-header-text text-center card-header-primary">
					<div class="card-text">
					  <h4 class="card-title"><b>DETALLE DEL DESCUENTO</b></h4>
					</div>
				</div>
				<div class="card-body">
					<div class=""> 	
					<div class="row" id="">		
              <label class="col-sm-1 col-form-label" style="color:#000000; ">Nombre Desc.:</label>
<div class="col-sm-5">
  <div class="form-group">
  	<input type="text" class="form-control" readonly="true" value="<?=$nombre?>" style="background-color:#E3CEF6;text-align: left" >
  </div>
</div>  
<label class="col-sm-1 col-form-label" style="color:#000000; ">Descuento % :</label>
<div class="col-sm-1">
  <div class="form-group">
  	<input type="text" class="form-control" readonly="true" value="<?=$abreviatura?>" style="background-color:#E3CEF6;text-align: left">
  </div>
</div>  
</div>
<div class="row">
<label class="col-sm-1 col-form-label" style="color:#000000; ">Del :</label>
<div class="col-sm-2">
  <div class="form-group">
  	<input type="text" class="form-control" readonly="true" value="<?=$desdeFormato?>" style="background-color:#E3CEF6;text-align: left" >
  </div>
</div>  
<label class="col-sm-1 col-form-label" style="color:#000000; ">H:M</label>
<div class="col-sm-1">
  <div class="form-group">
  	<input type="text" class="form-control" readonly="true" value="<?=$desde_hora?>" style="background-color:#E3CEF6;text-align: left" >
  </div>
</div> 

<label class="col-sm-1 col-form-label" style="color:#000000; ">Al :</label>
<div class="col-sm-2">
  <div class="form-group">
  	<input type="text" class="form-control" readonly="true" value="<?=$hastaFormato?>" style="background-color:#E3CEF6;text-align: left" >
  </div>
</div> 
<label class="col-sm-1 col-form-label" style="color:#000000; ">H:M</label>
<div class="col-sm-1">
  <div class="form-group">
  	<input type="text" class="form-control" readonly="true" value="<?=$hasta_hora?>" style="background-color:#E3CEF6;text-align: left" >
  </div>
</div> 
<label class="col-sm-1 col-form-label" style="color:#000000; ">Estado</label>
<div class="col-sm-1">
  <div class="form-group">
  	<input type="text" class="form-control" readonly="true" value="<?=$estado?>" style="background-color:#E3CEF6;text-align: left" >
  </div>
</div>
                    </div>
                    <br><br>
                    <div class="col-sm-12 div-center"><center><h3>Rango del Monto</h3></center></div>
<table class='table'>
  <tr><th class='text-right'>DESDE</th><th class='text-left'>HASTA</th></tr>
  <tr><th class='text-right'><a class='btn btn-warning text-white'><?=$desdeMonto?></a></th><th class='text-left'><a class='btn btn-warning text-white'><?=$hastaMonto?></a></th></tr></table>

          <br>
          <hr>
					<div class="col-sm-12 div-center"><center><h3>Sucursales Beneficiadas</h3></center></div>
					<div class="col-sm-12 div-center">	
						<table class="table table-bordered">
							<thead>
								<tr class="text-dark bg-plomo">
									<th class="text-right text-white" style="background:#741C89;">#</th>
                  <th class=" text-white" style="background:#741C89;">Sucursal</th>
									<th class=" text-white" style="background:#741C89;">Dirección</th>
								</tr>
							</thead>
							<tbody>
							<?php 
   $sql="select d.cod_ciudad,(SELECT cod_ciudad from tipos_precio_ciudad where cod_tipoprecio=$codigo_registro and cod_ciudad=d.cod_ciudad),d.direccion from ciudades d where d.cod_estadoreferencial=1 order by 1";
   $resp=mysqli_query($enlaceCon,$sql);
   $index=0;
  while($dat=mysqli_fetch_array($resp))
  {
    $index++;    
    $ciudades=obtenerNombreCiudad($dat[0]);
    $checked="";
    $direccion=$dat['direccion'];
    if($dat[1]>0){
      echo "<tr>
       <td>$index</td>
       <td>$ciudades</td>
       <td>$direccion</td>
      </tr>";   
    }
  }
              ?>
							</tbody>
						</table>
					</div>  


          <div class="row col-sm-12">
         
				  	<div class="card-footer fixed-bottom col-sm-12">						
						<!--<a href="#" class="btn btn-danger">Volver</a>-->
				  	</div>
				 </div>
			    </div><!--div end card-->			
               </div>
            </div>
	</div>
</div>

</body>
</html>