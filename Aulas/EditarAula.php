<html>
<head>
  <!-- jQuery -->
  <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="../Booststrap/js/bootstrap.min.js" ></script>
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
  include_once "../Config/Database.php";
  $db= new Database();
  $dblink= $db->getConnection();
  //echo $_SERVER['REQUEST_METHOD'];
  $_idAula = $_GET['id'];
  //echo var_dump($_GET['id']);
  $sql = "select * from Aulas where id_Aulas= $_idAula;";
  //echo var_dump($sql);
  $result = $dblink->query($sql);
  $fila = $result->fetch();
  ?>
  <!-- holaaa -->
<form action=<?php echo '"EditarAula.php?id='.$_GET['id'].'"' ?> method="post">
  <div class="form-group scrollbar">
    <label for="NombreAula">Nombre:</label>
    <input type="text" class="form-control" id="NombreAula" name="NombreAula" value = "<?php echo $fila['nombre']; ?>">
  </div>
  <div class="form-group">
    <label for="CantidadDeAlumnos">Cantidad de Alumnos:</label>
    <input type="text" class="form-control" id="CantidadAlumnos" name="CantidadAlumnos" value = <?php echo $fila['cantidad_alumnos']; ?>>
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
       $sql1 = "SELECT * FROM Categorias";
       //WHERE id_Categorias = ".$_GET['id'].";
       $result1 = $dblink->query($sql1);
       while ($fila1 = $result1->fetch()){  ?>
      <tr>
         <td><?php echo $fila1['nombre_categoria']; ?></td>
         <?php $sql2 = "SELECT * FROM Aulas_Categoria WHERE id_Aula = ".$_GET['id']." AND id_Categoria =".$fila1['id_Categorias'].";";
         //echo var_dump($sql2);
          $result2 = $dblink->query($sql2);
         if ($result2->fetchColumn() > 0){?>
           <td><?php echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" value=\" ".$fila1['id_Categorias']." \" enabled checked>";?></td>
         <?php  }else{ ?>
           <td><?php echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" value=\" ".$fila1['id_Categorias']." \" enabled>";?></td>
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
  $_id = $_POST['id1'];
  $_nombre= $_POST['NombreAula'];
  $_cantDeAlumnos= $_POST['CantidadAlumnos'];
  $_categorias= $_POST['categoria'];
  //echo var_dump($_POST['CantidadAlumnos']);
  //echo var_dump($_cantAulumnos);
  $sql3 = "UPDATE Aulas SET nombre = '$_nombre',cantidad_alumnos = $_cantDeAlumnos WHERE id_Aulas=".$_POST['id1'].";";
  //echo var_dump($sql3);
  $dblink->query($sql3);
  $sql4 = "DELETE FROM aulas_categoria WHERE id_Aula = $_id;";
  //echo var_dump($sql4);
  $dblink->query($sql4);
  foreach ($_categorias as  $value) {
    $sql5 = "INSERT INTO Aulas_Categoria(id_Aulas_Categoria,id_Aula,id_Categoria) VALUES(NULL,$_id,$value);" ;
    //echo var_dump($sql5);
    $dblink->query($sql5);
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
        <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Esta es la pantalla donde se puede editar la informacion del aula seleccioanda.

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
