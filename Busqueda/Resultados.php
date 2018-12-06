<?php
    //$_resultados = $_GET['res'];
    $_resultados = $_GET['r'];

 ?>

<html>
  <head>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Resultados de Busqueda</title>
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
        <p class="display-5">Resultados De Busqueda  </p>
        <?php
        //  echo $_resultados;
          $arrRes= implode(",",$_resultados);
          //echo implode(",",$_resultados[2]);
          for ($i=0; $i <count($_resultados) ; $i++) {
            $nombre= array_values($_resultados[$i]);
            echo $nombre[0] . " ";
            foreach ($_resultados[$i] as $key => $valor) {
            //  echo "$valor";
              if($valor==1){
                echo $key . "  ";
              }
            }
            echo "<br>";
          }

         ?>
          <div class="container" >
            Aulas Diponibles
            <table class="table table-striped table-bordered  table-responsive-sm m-5s">
              <thead  class="thead-dark">
                <tr>
                  <th style="width: 40%">Nombre de aula </th>
                  <th style="width: 30%">Horario </th>
                  <th style="width: 30%">Reservar </th>

                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>hola</td>
                  <td>x2 </td>
                  <td>x3 </td>
                </tr>
            </table>
          </div>
          <div class="container" >
            Aulas Reservadas
            <table class="table table-striped table-bordered  table-responsive-sm m-5s">
              <thead  class="thead-dark">
                <tr>
                  <th style="width: 40%">Nombre de aula </th>
                  <th style="width: 30%">Horario </th>
                  <th style="width: 30%">Reservar </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>hola</td>
                  <td>x2 </td>
                  <td>x3 </td>
                </tr>
            </table>
          </div>
      <br><br><br>
      </div>
    </div>
  </body>
</html>
