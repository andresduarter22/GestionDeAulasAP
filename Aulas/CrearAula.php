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
  <div>
    <button type="button" class="btn btn-danger">Cerrar sesión</button>
      <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image" ></a>
  </div>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>

  <?php
    //Conexion con base
    include_once "../Config/Database.php";
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
    <table class="table table-striped table-bordered  table-responsive-sm m-5s">
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
</form>
<?php
if (isset($_POST['submit']))
{
  $db= new Database();
  $dblink= $db->getConnection();
  $_nombre= $_POST['NombreAula'];
  $_cantAulumnos= $_POST['CantidadAlumnos'];
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
  $sql_log_ca = "INSERT INTO Logs(id_Log,nombre_usuario,num_interno_usuario,correo_usuario,tipo_usuario,Accion,Fecha_Accion) VALUES (NULL,'Andres','666','ad@gmail.com','m','Se creo un aula llamada $_nombre',now())";
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
 $dblink->close();
 ?>
</body>

</html>
