<html>
<head>
  <!-- jQuery -->
  <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="../Booststrap/js/bootstrap.min.js" ></script>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Crear Aula</title>
</head>
<body>
  <?php session_start();
  //echo var_dump($_SESSION['idUsuario']);
  if (isset($_SESSION['idUsuario'])) { ?>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="../Usuarios/GestiondeUsuarios.php">Usuarios</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="../Categorias/GestionDeCategorias.php">Categorias</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="GestionDeAulas.php">Aulas</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
    </nav>
    <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.png" class="img-fluid float-right" alt="Responsive image" ></a>
  </div>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>

  <?php
    //Conexion con base
    include_once "../Config/DataBase.php";
    $db= new Database();
    $dblink= $db->getConnection();
  ?>
  <!-- holaaa -->
<form action="CrearAula.php"  method="post">
  <div class="container">
    <div class="form-group scrollbar">
      <label for="NombreAula">Nombre:</label>
      <input type="text" class="form-control" id="NombreAula" name="NombreAula" required>
    </div>
    <div class="form-group">
      <label for="CantidadDeAlumnos">Cantidad de Alumnos:</label>
      <input type="number" class="form-control" id="CantidadAlumnos" name="CantidadAlumnos" required>
    </div>
  </div>
  <div class="container">
    <div class=" pre-scrollable">
    <table class="table table-striped table-bordered" >
    <thead  class="thead-dark">
      <tr>
        <th style="width: 15%">Nombre de Aula </th>
        <th style="width: 15%">Check </th>
      </tr>
    </thead>
    <tbody>
      <?php
       $sql = "select * from Categorias;";
       $result = $dblink->query($sql);
       while ($fila = $result->fetch()){  ?>
      <tr>
         <td><?php echo $fila['nombre_categoria'] ?></td>
         <td><?php echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" value=\" ".$fila['id_Categorias']." \" enabled>";?></td>
      </tr>
       <?php } ?>
     </tbody>
   </table>
   <form action="CrearAula.php" method="post">
     <input type="submit" name="submit" value="Confirmar" class="btn btn-info">
   </form>
  </div>
</div>
</form>
<?php
if (isset($_POST['submit']))
{
  $_nombre= strip_tags($_POST['NombreAula']);
  $_cantAulumnos= strip_tags($_POST['CantidadAlumnos']);
  $_categorias= $_POST['categoria'];
  $sql = "INSERT INTO Aulas(id_Aulas,nombre,cantidad_alumnos) VALUES(NULL,'$_nombre','$_cantAulumnos');";
  if ($dblink->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $dblink->error;
  }
  $_idAulaCreada=$dblink->lastInsertId();
  foreach ($_categorias as  $value) {
    $sql1 = "INSERT INTO Aulas_Categoria(id_Aulas_Categoria,id_Aula,id_Categoria) VALUES(NULL,$_idAulaCreada,$value);";
    if ($dblink->query($sql1) === FALSE) {
      echo "Error: " . $sql1 . "<br>" . $dblink->error;
    }
  }

  $idDeUsuario = $_SESSION['idUsuario'];
  $sql_validacion_loggeo = "SELECT * FROM Usuarios where id_Usuario=$idDeUsuario";
  $info_usuario = $dblink->query($sql_validacion_loggeo);
  $infoUs = $info_usuario->fetch();

  if ($infoUs['Rol'] == 0) {
      $rolDeUsuario = "Reservador";
  } else if ($infoUs['Rol'] == 1) {
      $rolDeUsuario = "Actualizador";
  } else {
      $rolDeUsuario = "Administrador";
  }
  $sql_log_ca = "INSERT INTO Logs(id_Log,nombre_usuario,num_interno_usuario,correo_usuario,tipo_usuario,Accion,Fecha_Accion) VALUES (NULL,'" . $infoUs['nombre'] . "','" . $infoUs['num_interno'] . "','" . $infoUs['E_Mail'] . "','" . $rolDeUsuario . "','Se creo un aula llamada $_nombre',now())";
  $dblink->query($sql_log_ca);

  header("Location: GestionDeAulas.php");
}

?>
<!-- Boton para ir Atras -->
<a class="btn btn-primary" href="GestionDeAulas.php">Atras</a>
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
        Esta es la pantalla donde se puede crear un aula nueva.

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Final boton de Informacion -->
<?php
} else {
    echo "Por favor registrese Aqui";
    ?>
    <a  class="btn btn-dark" href="../index.php"> Home Page</a>
<?php
}
?>
</body>

</html>
