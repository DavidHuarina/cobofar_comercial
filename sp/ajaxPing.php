<?php 
$ip=$_GET["ip"];
$comando = "ping ".$ip;
$output = shell_exec($comando);
$data=explode("Paquetes:",$output);
$ping=explode("(",$data[1]);
echo utf8_decode("ping ".$ip." <br> ".$ping[0]);
?>