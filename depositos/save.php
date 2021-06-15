<?php
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");
require('../funcion_nombres.php');
require("../funciones.php");

$fecha_registro=date("Y-m-d H:i:s");
$cod_ciudad=$_COOKIE['global_agencia'];
$codAlmacen=$_COOKIE['global_almacen'];
$codAlmacen=$_COOKIE['global_almacen'];
$cod_funcionario=$_POST['rpt_personal'];
$fecha_ini=$_POST['fecha_ini'];
$fecha_fin=$_POST['fecha_fin'];
$hora_ini=$_POST['exahorainicial'];
$hora_fin=$_POST['exahorafinal'];

$sql="SELECT IFNULL(max(codigo)+1,1) FROM $table";
$resp=mysqli_query($enlaceCon,$sql);
$codigo=mysqli_result($resp,0,0);
$monto_caja=0;
$dirArchivo="";
$archivoDefecto=0;
$monto_caja=$_POST["monto_calc"];
$monto_caja2=$_POST["monto_calc2"];
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
}else{
  $nombreArchivo="Cierre.".strftime('%d-%m-%Y',strtotime($fecha_ini)).".".nombreVisitador($cod_funcionario);
  $directorio2 = 'archivos-respaldo/archivos_depositos/RD-'.$codigo."/".$nombreArchivo.".pdf";
  $dirArchivo ='../'.$directorio2;
  //Para Guardar PDF
  $archivoDefecto=1;
}

$sql="insert into $table (codigo,glosa, fecha,fecha_registro,cod_banco,cod_funcionario, nro_cuenta,monto_caja,monto_registrado,ubicacion_archivo,cod_estadoreferencial,cod_cuenta,fechaf,hora,horaf,monto_registradousd,monto_cajausd) 
values($codigo,'$nombre','$fecha_ini','$fecha_registro','$rpt_banco','$cod_funcionario','$numero_cuenta','$monto_caja','$monto','$dirArchivo','1','$rpt_cuenta','$fecha_fin','$exahorainicial','$exahorafinal','$monto_caja2','$monto2')";
$sql_inserta=mysqli_query($enlaceCon,$sql);
if($sql_inserta==1){
  if($monto_caja>0){
     $sql="INSERT INTO cuentas_registrodeposito (cod_cuenta,cod_registrodeposito) VALUES('$rpt_cuenta','$codigo')";
     $sql_inserta=mysqli_query($enlaceCon,$sql);
  }  
  if($monto_caja2>0){
     $sql="INSERT INTO cuentas_registrodeposito (cod_cuenta,cod_registrodeposito) VALUES('$rpt_cuenta2','$codigo')";
     $sql_inserta=mysqli_query($enlaceCon,$sql);
  }


  


  if($archivoDefecto==1){
     $directorio2=str_replace("/","@",$directorio2);
     echo "<script language='Javascript'>
      location.href='$urlListGuardarPDF?rpt_territorio=$cod_ciudad&rpt_funcionario=$cod_funcionario&fecha_ini=$fecha_ini&fecha_fin=$fecha_fin&hora_ini=$hora_ini&hora_fin=$hora_fin&variableAdmin=1&ruta=$directorio2';
      </script>";  
  }else{
    echo "<script language='Javascript'>
      alert('Los datos fueron registrados exitosamente.');
      location.href='$urlList2';
      </script>";
  }
	
}else{
	echo "<script language='Javascript'>
			alert('Ocurrio un error inesperado, contacte al administrador.');
			location.href='$urlList2';
			</script>";
}


?>