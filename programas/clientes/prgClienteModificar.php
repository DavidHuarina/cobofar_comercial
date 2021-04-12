<?php

require("../../conexionmysqli.inc");

$codCli = $_GET["codcli"];
$nomCli = $_GET["nomcli"];
$apCli = $_GET["apcli"];
$ci = $_GET["ci"];
$edad = $_GET["edad"];
$genero = $_GET["genero"];
$nit = $_GET["nit"];
$dir = $_GET["dir"];
$tel1 = $_GET["tel1"];
$mail = $_GET["mail"];
$area = $_GET["area"];
$fact = $_GET["fact"];

$nomCli = str_replace("'", "''", $nomCli);
$apCli = str_replace("'", "''", $apCli);
$ci = str_replace("'", "''", $ci);
$nit = str_replace("'", "''", $nit);
$dir = str_replace("'", "''", $dir);
$tel1 = str_replace("'", "''", $tel1);
$mail = str_replace("'", "''", $mail);
$area = $area;
$fact = str_replace("'", "''", $fact);

$consulta="
    UPDATE clientes SET
    nombre_cliente = '$nomCli',
    paterno = '$apCli',
    ci_cliente = '$ci',
    nit_cliente = '$nit',
    dir_cliente = '$dir',
    telf1_cliente = '$tel1',
    email_cliente = '$mail',
    cod_area_empresa = $area,
    cod_tipo_edad = $edad,
    cod_genero = $genero,
    nombre_factura = '$fact'
    WHERE cod_cliente = $codCli
";
?>
<script type="text/javascript">
    function listadoClientes() {
     location.href="inicioClientes.php";
}

</script>
<?php
$resp=mysqli_query($enlaceCon,$consulta);
if($resp) {
    echo "<script type='text/javascript' language='javascript'>alert('Se ha modificado el cliente.');listadoClientes();</script>";
} else {
    //echo "$consulta";
    echo "<script type='text/javascript' language='javascript'>alert('Error al modificar cliente');</script>";
}

?>
