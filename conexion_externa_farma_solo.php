<?php
function ConexionFarma($server,$bdname){
    set_time_limit(0);
    $user="sistema";
    $pass="sistema";
    $server_bd="sqlsrv:server=".$server.";Database=".$bdname;   
    try{
      $dbh = new PDO($server_bd, $user, $pass);
      return $dbh; 
    }catch(PDOException $e){
      return false;
    }
  }