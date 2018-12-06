<?php
    //$_resultados = $_GET['res'];
    $_resultadosDisp = $_GET['disp'];
    $_resultadosNoDisp = $_GET['nodisp'];

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
                <?php
                for ($i=0; $i <count($_resultadosDisp) ; $i++) {
                  $nombre= array_values($_resultadosDisp[$i]);
                  foreach ($_resultadosDisp[$i] as $key => $valor) {
                  //  echo "$valor";
                    if($valor==1 && $key == 'A'){
                      echo "<tr>";
                        echo "<td>" . $nombre[0] . "</td> ";
                        echo "<td>" . $key . " </td> ";
                        echo "<td>  <a href=\"#\" class=\"btn btn-primary\">Reservar </td>";
                      echo "</tr>";
                    }
                  }
                }
                for ($i=0; $i <count($_resultadosDisp) ; $i++) {
                  $nombre= array_values($_resultadosDisp[$i]);
                  foreach ($_resultadosDisp[$i] as $key => $valor) {
                  //  echo "$valor";
                    if($valor==1 && $key == 'B'){
                      echo "<tr>";
                        echo "<td>" . $nombre[0] . "</td> ";
                        echo "<td>" . $key . " </td> ";
                        echo "<td>  <a href=\"#\" class=\"btn btn-primary\">Reservar </td>";
                      echo "</tr>";
                    }
                  }
                }
                for ($i=0; $i <count($_resultadosDisp) ; $i++) {
                  $nombre= array_values($_resultadosDisp[$i]);
                  foreach ($_resultadosDisp[$i] as $key => $valor) {
                  //  echo "$valor";
                    if($valor==1 && $key == 'C'){
                      echo "<tr>";
                        echo "<td>" . $nombre[0] . "</td> ";
                        echo "<td>" . $key . " </td> ";
                        echo "<td>  <a href=\"#\" class=\"btn btn-primary\">Reservar </td>";
                      echo "</tr>";
                    }
                  }
                }
                for ($i=0; $i <count($_resultadosDisp) ; $i++) {
                  $nombre= array_values($_resultadosDisp[$i]);
                  foreach ($_resultadosDisp[$i] as $key => $valor) {
                  //  echo "$valor";
                    if($valor==1 && $key == 'D'){
                      echo "<tr>";
                        echo "<td>" . $nombre[0] . "</td> ";
                        echo "<td>" . $key . " </td> ";
                        echo "<td>  <a href=\"#\" class=\"btn btn-primary\">Reservar </td>";
                      echo "</tr>";
                    }
                  }
                }
                for ($i=0; $i <count($_resultadosDisp) ; $i++) {
                  $nombre= array_values($_resultadosDisp[$i]);
                  foreach ($_resultadosDisp[$i] as $key => $valor) {
                  //  echo "$valor";
                    if($valor==1 && $key == 'E'){
                      echo "<tr>";
                        echo "<td>" . $nombre[0] . "</td> ";
                        echo "<td>" . $key . " </td> ";
                        echo "<td>  <a href=\"#\" class=\"btn btn-primary\">Reservar </td>";
                      echo "</tr>";
                    }
                  }
                }
                ?>
              </table>
          </div>
          <div class="container" >
            Aulas Reservadas
            <table class="table table-striped table-bordered  table-responsive-sm m-5s">
              <thead  class="thead-dark">
                <tr>
                  <th style="width: 40%">Nombre de aula </th>
                  <th style="width: 30%">Infromacion</th>
                </tr>
              </thead>
              <tbody>

                  <?php
                    for ($i=0; $i <count($_resultadosNoDisp) ; $i++) {
                      echo "<tr>";
                      $nombre= array_values($_resultadosNoDisp[$i]);
                      echo "<td>" . $nombre[0] . "</td>";
                      echo "<td> <a href=\"#\" class=\"btn btn-primary\">Infromacion </td>";

                      echo "</tr>";
                    }
                   ?>

            </table>
          </div>
      <br><br><br>
      </div>
      <a class="btn btn-primary" href="MotorDeBusqueda.php">Atras</a>
    </div>
  </body>

</html>
