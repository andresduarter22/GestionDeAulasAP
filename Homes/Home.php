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
    <a class="navbar-brand" href="HomeLogeado.php">Log In</a>
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
  <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>

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
