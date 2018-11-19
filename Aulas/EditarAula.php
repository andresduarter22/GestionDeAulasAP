<html>
<head>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Editar Aulas</title>
</head>
<body>
  <div>
    <button type="button" class="btn btn-danger">Cerrar sesión</button>
      <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image" ></a>
  </div>
  <br/>

  <?php
    //Conexion con base
    include "../Config/Database.php";
    //include_once "Actions.php";

    $db= new Database();
    $dblink= $db->getConnection();
  ?>
  <!-- holaaa -->
<form action="CrearAula.php"  method="post">
  <div class="form-group scrollbar">
    <label for="NombreAula">Nombre:</label>
    <input type="text" class="form-control" id="NombreAula" name="NombreAula">
  </div>
  <div class="form-group">
    <label for="CantidadDeAlumnos">Cantidad de Alumnos:</label>
    <input type="text" class="form-control" id="CantidadAlumnos" name="CantidadAlumnos">
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
  </div>
  <form action="CrearAula.php" method="post">
    <input type="submit" name="submit" value="Confirmar" class="btn">
  </form>
</form>
<?php
if (isset($_POST['submit']))
{
   create();
}
function create(){
  $db= new Database();
  $dblink= $db->getConnection();
  $_nombre= $_POST['NombreAula'];
  $_cantAulumnos= $_POST['CantidadAlumnos'];
  $_idAulaCreada=$dblink->lastInsertId();
  foreach ($_categorias as  $value) {
    $sql = "update Aulas_Categoria set(nombre = $_nombre,cantidad_alumnos=$_cantDeAlumnos)";
    if ($dblink->query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $dblink->error;
    }
  }
}

?>
<button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>
<div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<?php
 $dblink->close();
 ?>
   <!-- jQuery -->
   <script src="js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="js/bootstrap.min.js" ></script>
</body>

</html>
