<?php
session_start();
require_once '../conexionmysqli.inc';
require_once '../funciones.php';
require_once '../funcion_nombres.php';
require_once 'configModule.php';

if(isset($_GET['c'])){
	$codigo=$_GET['c'];
}else{
	$codigo=0;
}

 $nombreX=obtenerDescripcionArchivoDeposito($codigo);
 $urlArchivoMostrar=obtenerUrlArchivoDeposito($codigo);
 $downloadFile='download="Doc - COBOFAR ('.$nombreX.')"';
?>

<div class="content">
	<div class="container-fluid">


			<div class="card">
				<div class="card-header card-header-primary card-header-text">
					<div class="card-text">
					  <h4 class="card-title">Vista de Archivos</h4>
					</div>
				</div>
				<div class="card-body ">
					<div class="col-sm-12"><center><h3>ARCHIVOS ADJUNTOS</h3></center></div>
          <div class="row col-sm-12">
                        
            <div class="col-sm-12">
              <div class="row col-sm-12 div-center">
              <table class="table table-warning table-bordered table-condensed">
                <thead>
                  <tr>
                    <th class="small" width="35%">Archivo</th>           
                  </tr>
                </thead>
                <tbody id="tabla_archivos">
                  <tr>
                    <td class="text-center">
                        <div class="btn-group" id="existe_div_archivo_cabecera">
                          <div class='btn-group'>
                            <a class='btn btn-sm btn-info btn-block' href='<?=$urlArchivoMostrar?>' target='_blank'><?=$nombreX?></a>
                            <a class='btn btn-sm btn-default btn-fab' href='<?=$urlArchivoMostrar?>' <?=$downloadFile?>><i class='material-icons'>vertical_align_bottom</i></a>           
                            <a class='btn btn-sm btn-primary btn-fab' id="boton_previo" href='#' onclick='vistaPreviaArchivoSol("<?=$urlArchivoMostrar?>","Descargar: Doc - COBOFAR (<?=$nombreX?>)"); return false;'><i class='material-icons'>remove_red_eye</i></a>
                          </div>
                        </div>  
                    </td>    
                  </tr>   
                </tbody>
              </table>

            </div>
            <div class="" id="cont_archivos">           
            </div>  
          </div>	
					<br><br><br>
					<hr>
					<div class="col-sm-12 text-info font-weight-bold"><center><label id="titulo_vista_previa"><b>SELECCIONE UN ARCHIVO</b></label></center></div>
					<div class="row col-sm-12">
                      <iframe src="../vista_file.html"  id="vista_previa_frame" width="800" class="div-center" height="600" scrolling="yes" style="border:none; border: #741899 solid 9px;border-radius:10px;">
                      	No hay vista disponible
                      </iframe>
					</div>	


				</div>
				<div class="card-footer fixed-bottom">
						<a href="<?=$urlList2;?>" class="btn btn-danger"> Volver </a>

				  	</div>
			</div>	
	</div>
</div>
