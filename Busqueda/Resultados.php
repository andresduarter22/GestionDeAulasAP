<?php

    include "../Config/Database.php";
    include "search.php";
  //  session_start();
    $db= new Database();
    $dblink= $db->getConnection();
    $idDeUsuarioReservador=6;

    $se=new search();
    $arregDisp=0;
    if(isset($_POST['startSearch'])){
      $arregDisp=$se->busca();
    }

    echo $se->_aulaEspecifica;
  //  echo $se->__get($_horario);
    //$data = json_decode(trim(file_get_contents('php://input')),true);
    //echo implode(",",$data);
    //echo $data;

    //$_resultadosDisp = $_GET['disp'];
    //$_resultadosNoDisp = $_GET['nodisp'];


    $_resultadosDisp = $arregDisp[0];
    $_resultadosNoDisp = $arregDisp[1];
  //  echo $_resultadosDisp;

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
    <?php // echo implode(",",$_resultadosNoDisp[1]); ?>
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <p class="display-5">Resultados De Busqueda  </p>
          <div class="container" >
            Aulas Diponibles
            <table class="table table-striped table-bordered  table-responsive-sm m-5s">
              <thead  class="thead-dark">
                <tr>
                  <th style="width: 40%">Nombre de aula </th>
                  <th style="width: 30%">Reservar </th>
                </tr>
              </thead>
              <tbody>
                <?php
                for ($i=0; $i <count($_resultadosDisp) ; $i++) {
                  //  echo "$valor";
                  $sql = "SELECT * FROM aulas WHERE id_Aulas= $_resultadosDisp[$i] ";
                  $result = $dblink->query($sql);
                  $infoAulas=$result->fetch();

                  $sql = "SELECT * FROM usuarios_aulas WHERE id_DeAula= $_resultadosDisp[$i] AND id_DeUsuario = $idDeUsuarioReservador ;";
                  $infoUsCatego = $dblink->query($sql);
                //  echo "$sql";
                    echo "<tr>";
                      if($infoUsCatego->rowCount()){
                        echo "<td class=\"table-success\">" . $infoAulas[1] . "</td> ";
                        echo "<td class=\"table-success\">
                          <form method=\"POST\" action= \"ConfrimReserva.php\">
                            <input type=\"hidden\" name=\"id_AulasParaReservar\" value= " . $infoAulas[0] . " >
                            <input type=\"submit\" value=\"Realizar Reserva\" />
                          </form>
                         </td>";
                      }else {
                        echo "<td class=\"table-danger\">" . $infoAulas[1] . "</td> ";
                        echo "<td class=\"table-danger\">
                              <form action= \"AutoComplete.php\">
                                <input type=\"submit\" value=\"RTest\" />
                                </form>
                         </td>";
                      }
                    echo "</tr>";
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

                      for ($j=0; $j<  count($_resultadosNoDisp[$i]); $j++) {
                        $idReserv=$_resultadosNoDisp[$i][$j];
                        $sql = "SELECT * FROM reservas WHERE id_Reservas =  $idReserv; " ;
                        $result = $dblink->query($sql);
                        $infoReserva= $result->fetch();

                        if($j==0){
                          $sql = "SELECT nombre FROM aulas WHERE id_Aulas =  $infoReserva[1] ; " ;
                          $result = $dblink->query($sql);
                          $q= $result->fetch();

                            echo "<td>" . $q[0] . "</td> ";
                        }

                        $sql = "SELECT * FROM usuarios WHERE id_Usuario =  $infoReserva[2] ; " ;
                        $result = $dblink->query($sql);
                        $infoUsuario= $result->fetch();

                        $sql = "SELECT * FROM materias WHERE id_Materias =  $infoReserva[3] ; " ;
                        $result = $dblink->query($sql);
                        $infoMaterias= $result->fetch();
                        if ($j==0) {
                          echo "<td>";
                        }
                        echo "--" . $infoUsuario[1] . " Interno:". $infoUsuario[2] ."<br> Docente: ". $infoReserva[8] ."<br> Materia: " . $infoMaterias[1] . "<br> Fechas: Del " . $infoReserva[4] . " al " . $infoReserva[5]  . "<br>";
                        if($j==(count($_resultadosNoDisp)-1)){
                          echo "</td>";
                        }
                      }
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
                  <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  En esta pagina se pueden ver las aulas disponibles que cumplen los parametros requeridos
                  El color verde muestra que se puede realizar la reserva
                  El color rojo significa que este usuario no tiene el permiso para realizar la reserva
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
