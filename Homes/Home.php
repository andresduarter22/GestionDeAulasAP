<?php
  $_IDUsuarioTemporal=3;
 ?>

<html>
<head>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<!--Google    -->
  <script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id"
 content="287725469437-1ielsrb28qvp2sv3pa7m1ak8jk9l8816.apps.googleusercontent.com">
  <title>Home</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="HomeLogeado.php?id=<?php echo $_IDUsuarioTemporal; ?> ">Log In</a>


    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="../Busqueda/MotorDeBusqueda.php"> Consultar Reserva
          <span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="jumbotron jumbotron-fluid">
    <img src="../Images/Logo_UPB.jpg" class="img-fluid float-right"  alt="Responsive image" >
    <div class="container">
      <h1 class="display-4">Bienvenido al Sistema de Reservas UPB La Paz</h1>

  <!--      <a class="btn btn-primary btn-lg" href="HomeLogeado.php" role="button">Log </a>
        <a class="btn btn-success" href="HomeLogeado.php" role="button">Consultar Reserva</a> -->
    </div>
  </div>
  <!-- Inicio boton de informacion -->
  <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>
  <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Esta es la pantalla donde se puede consultar toda la lista de Aulas dentro de la base de Datos

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Final boton de Informacion -->

<!-- Log In GOOGLE
<div class="g-signin2" data-onsuccess="onSignIn">
  <button type="button" class="btn">  Log in GOOGLE </button>
</div>
-->


   <!-- jQuery -->
   <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="../Booststrap/js/bootstrap.min.js" ></script>
</body>

</html>
