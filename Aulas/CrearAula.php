<html>
<head>
  <link rel="stylesheet" href="css/bootstrap.css" >

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body>
  <button type="button" class="btn btn-danger">Cerrar sesión</button>
    <a href="GestionDeAulas.php"><img src="Logo_UPB.jpg" class="img-fluid " alt="Responsive image" ></a>
  <?php
   $db_name = "bd_aulasperronas";
   $db_user = "root";
   $db_pass = "";
   $dblink = new mysqli('localhost', $db_user, $db_pass, $db_name);
   if ($dblink->connect_error) {
     die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
           . $dblink->connect_error);
   }

   $sql = "select * from aulas;";
   $result = $dblink->query($sql);
?>



<form action="#" method="post">
  <div class="form-group">
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
       while ($fila = $result->fetch_object()){  ?>
      <tr>
         <td><?php echo " $fila->nombre_categoria"; ?></td>
         <td><?php echo "<input type=\"checkbox\" class=\"form-check-input\" enabled>";?></td>
      </tr>
       <?php } ?>
     </tbody>
   </table>
  </div>
  <form action="GestionDeAulas.php" method="post">
    <input type="submit" name="submit" value="Confirmar" class="btn">
  </form>


</form>
<?php
if (isset($_POST['submit']))
{
   create();
}
function create(){
  $db_name = "bd_aulasperronas";
  $db_user = "root";
  $db_pass = "";
  $dblink = new mysqli('localhost', $db_user, $db_pass, $db_name);
  if ($dblink->connect_error) {
    die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
          . $dblink->connect_error);
  }
  $_nombre= $_POST['NombreAula'];
  $_cantAulumnos= $_POST['CantidadAlumnos'];

  $sql = "insert into Aulas(id_Aulas,nombre,cantidad_alumnos)
              values(NULL,'$_nombre','$_cantAulumnos')";

  if ($dblink->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $dblink->error;
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
