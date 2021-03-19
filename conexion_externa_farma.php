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
    private $host = '10.10.12.12';  
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

} 

 
