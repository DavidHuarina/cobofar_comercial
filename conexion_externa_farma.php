<?php 
/*Conexion Externa FARMACIAS BOLIVIA SQL SERVER*/
class ConexionFarma extends PDO {    

    private $tipo_de_base = 'sqlsrv';
    private $host = '10.10.1.11';  
    private $nombre_de_base = 'Gestion';
    private $usuario = 'sistema';
    private $contrasena = 'sistema';

public function __construct() {
      //Sobreescribo el método constructor de la clase PDO.
      try{
         parent::__construct($this->tipo_de_base.':server='.$this->host.';Database='.$this->nombre_de_base, $this->usuario, $this->contrasena,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));// 
      }catch(PDOException $e){
         echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
         exit;
      }
   } 
public function setHost($host){
   $this->host=$host;
 }
public function setBase($base){
   $this->nombre_de_base=$base;
 }
 public function start(){
  set_time_limit(0);
  
  //PARA CONTRASEÑA CON MINUSCULAS
  $ipCon=$this->host;
  /*$enlaceCon=mysqli_connect("127.0.0.1","root","","farmaciasalmacen");
  $sql = "SELECT ip FROM sucursales_minusculas where ip='$ipCon'";
  $resp = mysqli_query($enlaceCon,$sql);
  $ipSuc=mysqli_result($resp,0,0);*/


  $this->contrasena="B0l1v14.@1202";
  if($this->host==$ipSuc){
    $this->contrasena="B0l1v14.@1202";
  }
  //FIN DE FUNCION DE CONTRASENA
   try{
         parent::__construct($this->tipo_de_base.':server='.$this->host.';Database='.$this->nombre_de_base, $this->usuario, $this->contrasena,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));// 
         return true;
      }catch(PDOException $e){
         return false;
      }
  }
} 

class ConexionFarmaSucursal extends PDO {    

    private $tipo_de_base = 'sqlsrv';
    private $host = '10.10.8.12';  
    private $nombre_de_base = 'Gestion';
    private $usuario = 'sistema';
    private $contrasena = 'B0l1v14.@1202';    
public function __construct() {
      //Sobreescribo el método constructor de la clase PDO.
      try{
        //PARA CONTRASEÑA CON MINUSCULAS
        $ipCon=$this->host;
        $enlaceCon=mysqli_connect("127.0.0.1","root","","farmaciasalmacen");
        $sql = "SELECT ip FROM sucursales_minusculas where ip='$ipCon'";
        $resp = mysqli_query($enlaceCon,$sql);
        $ipSuc=mysqli_result($resp,0,0);


        $this->contrasena="B0l1v14.@1202";
        if($this->host==$ipSuc){
          $this->contrasena="B0l1v14.@1202";
        }
       //FIN DE FUNCION DE CONTRASENA
         parent::__construct($this->tipo_de_base.':server='.$this->host.';Database='.$this->nombre_de_base, $this->usuario, $this->contrasena,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));// 
      }catch(PDOException $e){
         echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
         exit;
      }
   } 

} 

function ConexionFarma($server,$bdname){
    set_time_limit(0);
    //error_reporting(0);
    //PARA CONTRASEÑA CON MINUSCULAS
    $ipCon=$server;
    $enlaceCon=mysqli_connect("127.0.0.1","root","","farmaciasalmacen");
    $sql = "SELECT ip FROM sucursales_minusculas where ip='$ipCon'";
    //echo $sql;
    $resp = mysqli_query($enlaceCon,$sql);
    $ipSuc=mysqli_result($resp,0,0);


    $pass="B0l1v14.@1202";
    if($server==$ipSuc){
      $pass="B0l1v14.@1202";
    }
  //FIN DE FUNCION DE CONTRASENA
    $user="sistema";    
    $server_bd="sqlsrv:server=".$server.";Database=".$bdname;   
    try{
      $dbh = new PDO($server_bd, $user, $pass);
      return $dbh; 
    }catch(PDOException $e){
       //echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
      return false;
    }
  }

  if (!function_exists('mysqli_result')) {
    function mysqli_result($result, $number, $field=0) {
        mysqli_data_seek($result, $number);
        $row = mysqli_fetch_array($result);
        return $row[$field];
    }
}

