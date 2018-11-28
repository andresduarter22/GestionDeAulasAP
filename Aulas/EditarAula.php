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
  <br/>
  <br/>
  <br/>
  <br/>

  <?php
  session_start();
  $db_name = "bd_aulasperronas";
  $db_user = "root";
  $db_pass = "";
  $dblink = new mysqli('localhost', $db_user, $db_pass, $db_name);
  if ($dblink->connect_error) {
    die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
          . $dblink->connect_error);
  }
  $_idAula = $_GET['id'];
  $sql = "select * from Aulas where id_Aulas= $_idAula ;";
  $result = $dblink->query($sql);
  $fila = $result->fetch_object();
  echo var_dump($fila->cantidad_alumnos);
  ?>
  <!-- holaaa -->
<form action="EditarAula.php"  method="post">
  <div class="form-group scrollbar">
    <label for="NombreAula">Nombre:</label>
    <input type="text" class="form-control" id="NombreAula" name="NombreAula" value = <?php echo $fila->nombre; ?>>
  </div>
  <div class="form-group">
    <label for="CantidadDeAlumnos">Cantidad de Alumnos:</label>
    <input type="text" class="form-control" id="CantidadAlumnos" name="CantidadAlumnos" value = <?php echo $fila->cantidad_alumnos; ?>>
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
       $sql1 = "select * from Categorias";
       //WHERE id_Categorias = ".$_GET['id'].";
       $result1 = $dblink->query($sql1);
       while ($fila1 = $result1->fetch_object()){  ?>
      <tr>
         <td><?php echo $fila1->nombre_categoria; ?></td>
         <?php $sql2 = "select * from Aulas_Categoria where id_Aula = ".$_GET['id']." and id_Categoria =".$fila1->id_Categorias.";";
          $result2 = $dblink->query($sql2);
         if ($result2->num_rows > 0){?>
           <td><?php echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" value=\" ".$fila1->id_Categorias." \" enabled checked>";?></td>
         <?php  }else{ ?>
           <td><?php echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" value=\" ".$fila1->id_Categorias." \" enabled>";?></td>
      <?php
         }
          ?>
      </tr>
       <?php } ?>
     </tbody>
   </table>
  </div>
  <form action="EditarAula.php" method="post">
    <input type="hidden" value="<?php echo $_GET['id'] ;?>" name="id1" class="form-control"/>
    <input type="submit" name="submit" class="btn btn-primary" value="Confirmar" />
  </form>
</form>
<?php
if (isset($_POST['id1']))
{
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
<!-- Boton para ir Atras -->
<a class="btn btn-primary" href="GestionDeAulas.php">Atras</a>
<!-- Inicio boton de informacion -->
<button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>
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
        Esta es la pantalla donde se puede consultar toda la lista de Aulas dentro de la base de Datos

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Final boton de Informacion -->
<?php
 $dblink->close();
 ?>
   <!-- jQuery -->
   <script src="js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="js/bootstrap.min.js" ></script>
</body>

</html>
