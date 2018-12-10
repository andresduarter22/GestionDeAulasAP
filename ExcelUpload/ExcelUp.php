<?php
  include "csv.php";

  $_idDeUsuario = 1;

//  $_idDeUsuario = $_GET['id'];
//  echo "$_idDeUsuario";

  $csv=new csv();
  if(isset($_POST['sub'])){
      $csv->import($_FILES['file']['tmp_name'], $_POST['id']);
  }
?>
<html>
  <head>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Upload Excel</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="Home.php">Log Out</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
      </div>
      <a class="navbar-brand" href="../Usuarios/GestiondeUsuarios.php">Usuarios</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="../Categorias/GestionDeCategorias.php">Categorias</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="../Aulas/GestionDeAulas.php">Aulas</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
    </nav>
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <p class="lead">Ingrese el documento csv  </p>
          <div class="container" >
            <form method="post" enctype="multipart/form-data">
              <input type="file" name="file">
              <input type='hidden' name='id' value='<?php echo "$_idDeUsuario";?>'/>
              <input type="submit" name="sub" value="Import">
            </form>
          </div>
      <br><br><br>
    <!--      <a class="btn btn-primary btn-lg" href="HomeLogeado.php" role="button">Log </a>-->
      </div>
    </div>


    <a class="btn btn-primary" href="../Homes/HomeLogeado.php">Atras</a>

  </body>
</html>
