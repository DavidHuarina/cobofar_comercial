<?php
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");
require("../funciones.php");

$fecha_registro=date("Y-m-d H:i:s");
$cod_ciudad=$_COOKIE['global_agencia'];
$codAlmacen=$_COOKIE['global_almacen'];
$cod_funcionario=$_COOKIE['global_usuario'];
$sql="SELECT IFNULL(max(codigo)+1,1) FROM $table";
$resp=mysqli_query($enlaceCon,$sql);
$codigo=mysqli_result($resp,0,0);
$monto_caja=0;
$dirArchivo="";

if($_FILES['documentos_cabecera']["name"]){
      $filename = $_FILES['documentos_cabecera']["name"]; //Obtenemos el nombre original del archivos
      $source = $_FILES['documentos_cabecera']["tmp_name"]; //Obtenemos un nombre temporal del archivos    
      $directorio = '../archivos-respaldo/archivos_depositos/RD-'.$codigo; //Declaramos una  variable con la ruta donde guardaremos los archivoss
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
          echo "error";
      } 
}

$sql="insert into $table (codigo,glosa, fecha,fecha_registro,cod_banco,cod_funcionario, nro_cuenta,monto_caja,monto_registrado,ubicacion_archivo,cod_estadoreferencial) 
values($codigo,'$nombre','$fecha_fin','$fecha_registro','$rpt_banco','$cod_funcionario','$numero_cuenta','$monto_caja','$monto','$dirArchivo','1')";
$sql_inserta=mysqli_query($enlaceCon,$sql);
if($sql_inserta==1){
	echo "<script language='Javascript'>
			alert('Los datos fueron registrados exitosamente.');
			location.href='$urlList2';
			</script>";
}else{
	echo "<script language='Javascript'>
			alert('Ocurrio un error inesperado, contacte al administrador.');
			location.href='$urlList2';
			</script>";
}


?>