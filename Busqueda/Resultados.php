<?php

    include "../Config/Database.php";
    $db= new Database();
    $dblink= $db->getConnection();

    //$data = json_decode(trim(file_get_contents('php://input')),true);
    //echo implode(",",$data);
    //echo $data;

    $_resultadosDisp = $_GET['disp'];
    $_resultadosNoDisp = $_GET['nodisp'];

 ?>

<html>
  <head>
    <!-- jQuery -->
    <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../Booststrap/js/bootstrap.min.js" ></script>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Resultados de Busqueda</title>
  </head>
  <body>
    <div>
        <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image" ></a>
    </div>
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
    <?php echo implode(",",$_resultadosNoDisp[1]); ?>
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
                        echo "<td>  <a href=\"ConfrimReserva.php\" class=\"btn btn-primary\">Reservar </td>";
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
                        echo "<td>  <a href=\"ConfrimReserva.php\" class=\"btn btn-primary\">Reservar </td>";
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
                        echo "<td>  <a href=\"ConfrimReserva.php\" class=\"btn btn-primary\">Reservar </td>";
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
                        echo "<td>  <a href=\"ConfrimReserva.php\" class=\"btn btn-primary\">Reservar </td>";
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
                        echo "<td>  <a href=\"ConfrimReserva.php\" class=\"btn btn-primary\">Reservar </td>";
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
                  <th style="width: 30%">Informacion</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                    for ($i=0; $i <count($_resultadosNoDisp) ; $i++) {
                      echo "<tr>";
                        $nombre= array_values($_resultadosNoDisp[$i]);
                        echo "<td>" . $nombre[0] . "</td>";
                        /*
                        * En la posicion 6 del arreglo se tiene las fechas
                        * tentativamente se deberia tener el tipo de reserva (seguida o especifica)
                        * id de aula    check
                        * id de materia  !!!! no funciona sql buscando por nombre para que ingrese la materia
                        * id de usuario
                        * idealmente deberiamos tener una pagina mas donde se ingrese la materia, autocompletar si es necesario
                        * o crear una nueva materia
                        */

                        echo "<td>" . $nombre[6] . "</td>";

                      echo "</tr>";
                    }
                   ?>
            </table>
          </div>
      <br><br><br>
      </div>
      <a class="btn btn-primary" href="MotorDeBusqueda.php">Atras</a>
      <!--boton de informacion-->
          <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>
          <div class="modal fade" id="info" name="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  AIUDA XD
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
    </div>
  </body>

</html>
