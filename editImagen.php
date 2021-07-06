<?php
include("datosUsuario.php");
require("conexionmysqli2.inc");
$htmlMensaje="";
if(isset($_FILES["documentos_cabecera"])){
    $user=$_COOKIE["global_usuario"];
  if($_FILES['documentos_cabecera']["name"]){
      $filename = $_FILES['documentos_cabecera']["name"]; //Obtenemos el nombre original del archivos
      $source = $_FILES['documentos_cabecera']["tmp_name"]; //Obtenemos un nombre temporal del archivos

      $directorio = 'archivos-respaldo/archivos_perfiles/USER-'.$user; //Declaramos una  variable con la ruta donde guardaremos los archivoss
      //Validamos si la ruta de destino existe, en caso de no existir la creamos
      if(!file_exists($directorio)){
                mkdir($directorio, 0777,true) or die("No se puede crear el directorio de extracci&oacute;n");    
      }
      //ELIMINAR FICHEROS
      $files = glob($directorio.'/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino el fichero
      }

      $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivos
      //Movemos y validamos que el archivos se haya cargado correctamente
      //El primer campo es el origen y el segundo el destino
      if(move_uploaded_file($source, $target_path)) { 
         $dirArchivo=$target_path;                  
      } else {    
         $dirArchivo="";
      }       
      $sqlContra = "UPDATE usuarios_sistema SET imagen='$dirArchivo' where codigo_funcionario='$user'";
      mysqli_query($enlaceCon,$sqlContra);
      ?><script type="text/javascript">window.location.href='editImagen.php';</script><?php
  }
}

  

?>
<style type="text/css">
	
	@import url(https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700);

	*, *:after, *:before {
	    margin: 0;
	    padding: 0;

	    box-sizing: border-box;
	    -webkit-box-sizing: border-box;
	    -moz-box-sizing: border-box;

	    -webkit-text-size-adjust: 100%;
	    -ms-text-size-adjust: 100%;

	    font-smoothing: antialiased;
	    text-rendering: optimizeLegibility;
	    -webkit-font-smoothing: antialiased;
	    font-smooth: always;

	    -webkit-user-select: none;
	    -khtml-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;

	    font-family: inherit;

	    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	}

	body {
	    font: 300 13px/1.6 Roboto, Helvetica, Arial;
	    color: #444;
	    position: relative;
	    background: url('imagenes/login.jpg') no-repeat;
	    height: 100vh;
	    text-align: center;
		background: #3f51b5;
		background-size: cover;
	}
	body:after{
		content: "";
		display: block;
		width: 100%;
		height: 100%;
		position: absolute;
		left: 0;
		top: 0;
		background: url('imagenes/login.jpg') no-repeat;
		z-index: -1
	}

	ul{
	    list-style: none;
	}

	img {
	    -ms-interpolation-mode: bicubic;
	    vertical-align: middle;
	    border: 0;
	}

	.profile-card{
		width: 450px;
		border-radius: 2px;
		overflow: hidden;
		box-shadow: 0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);
		position: relative;
		margin: auto;
		background: rgba(255,255,255,1);		
		top: 50%;
		transform: translateY(-50%);
	}

	.profile-card header{
		display: block;
		position: relative;
		background: rgba(255,255,255,1);
		text-align: center;
		padding: 30px 0 20px;
		z-index: 1;
		overflow: hidden;
	}

	.profile-card header:before{
		content: "";
		position: absolute;
		background: url('http://ali.shahab.pk/blur.php?img=http://ali.shahab.pk/ali-shahab.jpg&x=60') no-repeat;
		background-size: cover;
		width: 100%;
		height: 100%;
		left: 0;
		top: 0;
		z-index: -1;
		
	}

	.profile-card header:after{
		content: "";
		position: absolute;
		bottom: -1px;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: -1;
		background-image: linear-gradient(
		    to bottom,
		    rgba(255, 255, 255, 0) 0%,
		    rgba(255, 255, 255, 1) 100%
		);
	}

	.profile-card header img{
		border-radius: 100%;
		overflow: hidden;
		width: 150px;
		min-height: 150px;
		border: 1px solid rgba(255,255,255,.5);
		box-shadow: 0 1px 0 rgba(0,0,0,.1),0 1px 2px rgba(0,0,0,.1);
	}

	.profile-card header h1{
		font-weight: 200;
		font-size: 42px;
		color: #444;
		letter-spacing: -3px;
		margin: 0;
		padding: 0;
	}

	.profile-card header h2{
		font-weight: 400;
		font-size: 14px;
		color: #666;
		letter-spacing: .5px;
		margin: 0;
		padding: 0;
	}

	.profile-card .profile-bio{
		padding: 0 30px;
		text-align: center;
		color: #888;
	}

	.profile-card .profile-social-links{
		display: table;
		width: 70%;
		margin: 20px auto;
	}

	.profile-card .profile-social-links li{
		display: table-cell;
		width: 33.3333333333333333%
	}

	.profile-card .profile-social-links li a{
		display: block;
		text-align: center;
		padding: 10px;
		margin: 0 10px;
		border-radius: 100%;
		-webkit-transition: box-shadow 0.2s;
		-moz-transition: box-shadow 0.2s;
		-o-transition: box-shadow 0.2s;
		transition: box-shadow 0.2s;
	}
	.profile-card .profile-social-links li a:hover{
		box-shadow: 0 1px 1.5px 0 rgba(0,0,0,.12),0 1px 1px 0 rgba(0,0,0,.24);
	}

	.profile-card .profile-social-links li a:active{
		box-shadow: 0 4px 5px 0 rgba(0,0,0,.14),0 1px 10px 0 rgba(0,0,0,.12),0 2px 4px -1px rgba(0,0,0,.2);
	}

	.profile-card .profile-social-links li a img{
		width: 100%;
		display: block;
	}
	#fondo{

	}
</style>
<!-- this is the markup. you can change the details (your own name, your own avatar etc.) but don’t change the basic structure! -->
<aside class="profile-card">
  
  <header>
    
    <!-- here’s the avatar -->
    <a href="http://ali.shahab.pk">
      <img src="<?=$imagenLogin?>" width="">
    </a>

    <!-- the username -->
    <h1><?=$nombreUsuarioSesion?></h1>
    
    <!-- and role or location -->
    <h2><?=$nombreAlmacenSesion?></h2>
    
  </header>
  
  <!-- bit of a bio; who are you? -->
  <div class="profile-bio">
    
    <p>COBOFAR - COMERCIAL</p>
    <form class="form" action="editImagen.php" method="POST" enctype='multipart/form-data'>
  <div class="input-group mb-2 mr-sm-2">
    <div class="input-group-prepend">
      <div class="input-group-text"><label>Seleccione</label></div>
    </div>
    <small id='label_txt_documentos_cabecera'></small> 
                      <span class='input-archivo'>
                        <input type='file' class='archivo d-none' name='documentos_cabecera' id='documentos_cabecera' accept="image/*"/>
                      </span>
                      <label title='Ningún archivo' for='documentos_cabecera' id='label_documentos_cabecera' class='label-archivo btn btn-info btn-sm'><i class='material-icons'>publish</i> Subir Archivo
                      </label>
  </div>

  <button type="submit" class="btn btn-warning">Guardar Cambios</button>
  <br><br>
  <div id="mensaje"><?=$htmlMensaje?></div>
</form>
  </div>
  
  <!-- some social links to show off -->
  <ul class="profile-social-links">
    
    
  </ul>
  
</aside>
<!-- that’s all folks! -->