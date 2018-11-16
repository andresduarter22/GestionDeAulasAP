<html>
<head>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


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
      <li class="nav-item ">
       <a class="nav-link" href="#">Cargar Archivo <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item ">
       <a class="nav-link" href="#">Descargar Archivo</a>
      </li>
    </ul>
    </div>
    <a class="navbar-brand" href="../Usuarios/GestiondeUsuarios.php">Usuarios</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Categorias</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="../Aulas/GestionDeAulas.php">Aulas</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

  </nav>

  <div class="jumbotron jumbotron-fluid">
    <img src="../Images/Logo_UPB.jpg" class="img-fluid float-right"  alt="Responsive image" >
    <div class="container">
      <h1 class="display-4">Bienvenido Usuario</h1>
    <br><br><br>
  <!--      <a class="btn btn-primary btn-lg" href="HomeLogeado.php" role="button">Log </a>-->
        <a class="btn btn-success" href="#" role="button">Realizar Reserva</a>
    </div>
  </div>
  <a class="btn btn-secondary" href="#" role="button">Logs</a>



  <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>

   <!-- jQuery -->
   <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="../Booststrap/js/bootstrap.min.js" ></script>
</body>

</html>
