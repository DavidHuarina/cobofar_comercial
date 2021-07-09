<!DOCTYPE html>
<html lang="es">
<meta charset="utf-8">
<head>

  <meta content="text/html; charset=ISO-8859-1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="imagenes/icon_farma.png" />

  <title>Farmacias Bolivia</title>

  <!-- Custom fonts for this template-->
  <link href="dist/vendor/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="dist/vendor/css/sb-admin-2.min.css" rel="stylesheet">

</head>
<style>
    .bg-login-image{
        
        background-size: 100% 100%;
        background-repeat:no-repeat;
        background:url('imagenes/login.jpg');
        background-size: cover;
    }
</style>
<body class="bg-gradient-success">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Farmacias Bolivia <br> <small>Comercial v2.4</small></h1>
                  </div>
                  <form class="user" action="cookie.php" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="usuario" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Ingrese su usuario..." autocomplete="off">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="contrasena" id="exampleInputPassword" placeholder="Contrasena">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Recordar Contrasena</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-user btn-block">
                      Entrar
                    </button>
                    <hr>
                    <?php
                    if(isset($_GET["ma"])){
                       ?><label class='text-danger' style='position:fixed;'><b>MAC: <?=$_GET["ma"]?></b></label><?php
                    }else{
                       ?><label class='text-success' style='position:fixed;'><b>Datos incorrectos, vuelve a intentarlo :(</b></label><?php
                    }?>
                    
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="dist/vendor/vendor/jquery/jquery.min.js"></script>
  <script src="dist/vendor/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="dist/vendor/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="dist/vendor/js/sb-admin-2.min.js"></script>

</body>

</html>