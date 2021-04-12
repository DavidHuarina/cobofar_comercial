<?php
require_once __DIR__.'/../conexion_externa_farma.php';
  $dbh = new ConexionFarma();
  $sql="SELECT a.* FROM almacen a";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $ff=0;
  $datos=[];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
     $datos[$ff]['des']=$row['DES'];
     $datos[$ff]['direc']=$row['DIREC'];
     $datos[$ff]['age1']=$row['AGE1'];
     $datos[$ff]['age']=$row['AGE'];
     $datos[$ff]['tipo']=$row['TIPO'];
     $datos[$ff]['ip']=$row['IP'];
     $ff++;
  }

header('Content-type: application/json');   
print_r($listProvarray($ff,$datos));