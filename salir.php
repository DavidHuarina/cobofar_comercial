<?php
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

/*setcookie("global_almacen", "", time() - 3600);
setcookie("globalGestion", "", time() - 3600);
setcookie("global_usuario", "", time() - 3600);
setcookie("global_agencia", "", time() - 3600);
setcookie("global_tipo_almacen", "", time() - 3600);*/
echo "<script language='Javascript'>
			location.href='index.html';
			</script>";
?>