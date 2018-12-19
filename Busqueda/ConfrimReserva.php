<?php
  include "../Config/Database.php";
  session_start();
  $db= new Database();
  $dblink= $db->getConnection();

  $id_DeAulaAReservar=  $_SESSION["id_AulasParaReservar"];
  $id_UsuarioQueReserva= $_SESSION['id_UsuarioQueReserva'];
  $fechas= $_SESSION['fechas'];
  $tipoDeReserva= $_SESSION['tipoDeReserva'];
  $horario= $_SESSION['horario'];

  $nombreDeMateria= $_POST['NombreMateria'];
  $docente = $_POST['NombreDocente'];


  //echo "$id_DeAulaAReservar ";
  //echo $id_UsuarioQueReserva;
  //echo implode(",",$fechas);
  //echo $fechas['fechaini'];
  //echo $tipoDeReserva;

  if(isset($_POST['confirmReservation'])){
        $sql = "SELECT * FROM materias WHERE nombre_materia = '$nombreDeMateria' ;";
        $result = $dblink->query($sql);
        $idDeMateria= 0;
        if($result->rowCount()){
            $infoMateria= $result->fetch();
            $idDeMateria= $infoMateria[0];
         }else{
            $sql = "INSERT INTO materias VALUES (NULL, '$nombreDeMateria'); ";
            $result = $dblink->query($sql);
            $idDeMateria= $dblink->lastInsertId();
        }

        if($tipoDeReserva==1){
            //seguidos
            $fechainicial=$fechas['fechaini'];
            $fechafinal=$fechas['fechafin'];
            $sql= "INSERT INTO reservas values (NULL, $id_DeAulaAReservar, $id_UsuarioQueReserva,$idDeMateria,'$fechainicial', '$fechafinal', 1, '$horario', '$docente' ) ;";
            $dblink->query($sql);
        }else{
            for( $i =0 ; $i< count($fechas) ; $i++){
                $sql= "INSERT INTO reservas values (NULL, $id_DeAulaAReservar, $id_UsuarioQueReserva,$idDeMateria,'$fechas[$i]' ,'$fechas[$i]' , 1, '$horario', '$docente' ) ;";
                echo $sql . "<br>";
                $dblink->query($sql);
            }
        }

  }



 ?>

<html>
  <head>
    <!-- jQuery -->
    <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../Booststrap/js/bootstrap.min.js" ></script>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Confirmacion de Reserva</title>
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
  <div class="container">
    <form action="ConfrimReserva.php" method="post" >
      <div class="form-group">
        <label for="exampleInputEmail1">Materia</label>
        <input type="text" name="NombreMateria" class="form-control" id="NombreMateria"  placeholder="Ingrese Materia">
        <small id="Materia Help" class="form-text text-muted">Ingrese el nombre de la materia a la cual se guardara la reserva</small>
      </div>
      <div class="form-group">
        <label >Nombre de Docente</label>
        <input  class="form-control" name="NombreDocente" id="NombreDocente" placeholder="Nombre de docente">
      </div>
      <button type="submit" class="btn btn-primary"  name="confirmReservation" value="submit" >Submit</button>
    </form>
  </div>

 <!--  <a class="btn btn-primary" href="Resultados.php">Atras</a> -->
  </body>
</html>
