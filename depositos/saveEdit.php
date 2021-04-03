<?php
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("../funciones.php");
require("configModule.php");

$codigo=$_POST['codigo'];
$nombre=$_POST['nombre'];

$dirArchivo=obtenerUrlArchivoDeposito($codigo);

if(!($_FILES['documentos_cabecera']["name"]== null || $_FILES['documentos_cabecera']["name"]=="")){
      $filename = $_FILES['documentos_cabecera']["name"]; //Obtenemos el nombre original del archivos
      $source = $_FILES['documentos_cabecera']["tmp_name"]; //Obtenemos un nombre temporal del archivos    
      $directorio = '../archivos-respaldo/archivos_depositos/RD-'.$codigo; //Declaramos una  variable con la ruta donde guardaremos los archivoss
      //Validamos si la ruta de destino existe, en caso de no existir la creamos
      if(!file_exists($directorio)){      	
                mkdir($directorio, 0777,true) or die("No se puede crear el directorio de extracci&oacute;n");    
      }

      //ELIMINAR FICHEROS
      /*$files = glob($directorio.'/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino el fichero
      }*/

      $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivos
      //Movemos y validamos que el archivos se haya cargado correctamente
      //El primer campo es el origen y el segundo el destino
      if(move_uploaded_file($source, $target_path)) { 
      	$dirArchivoAntiguo=obtenerUrlArchivoDeposito($codigo);
      	unlink($dirArchivoAntiguo);
        $dirArchivo=$target_path;
      } else {    
          echo "error";
      } 
}

$sql_upd=mysqli_query($enlaceCon,"update $table set glosa='$nombre',fecha='$fecha_fin',cod_banco='$rpt_banco',nro_cuenta='$numero_cuenta',monto_registrado='$monto',ubicacion_archivo='$dirArchivo' where codigo='$codigo'");
if($sql_upd==1){
	echo "<script language='Javascript'>
			alert('Los datos fueron modificados correctamente.');
			location.href='$urlList2';
			</script>";
}else{
	echo "<script language='Javascript'>
			alert('Ocurrio un error inesperado, contacte al administrador.');
			location.href='$urlList2';
			</script>";
}

?>