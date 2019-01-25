<html>
<head>
  <!-- jQuery -->
  <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="../Booststrap/js/bootstrap.min.js" ></script>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Editar Aula</title>
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
  <?php
  include_once "../Config/DataBase.php";
  $db= new Database();
  $dblink= $db->getConnection();
  //echo $_SERVER['REQUEST_METHOD'];
  $_idAula = $_GET['id'];
  //echo var_dump($_GET['id']);
  $sql = "SELECT * FROM Aulas WHERE id_Aulas= $_idAula;";
  //echo var_dump($sql);
  $result = $dblink->query($sql);
  $fila = $result->fetch();
  ?>
  <!-- holaaa -->
<form action=<?php echo '"EditarAula.php?id='.$_GET['id'].'"' ?> method="post">
  <div class="container">
    <div class="form-group scrollbar">
      <label for="NombreAula">Nombre:</label>
      <input type="text" class="form-control" id="NombreAula" name="NombreAula" value = "<?php echo $fila['nombre']; ?>">
    </div>
    <div class="form-group">
      <label for="CantidadDeAlumnos">Cantidad de Alumnos:</label>
      <input type="text" class="form-control" id="CantidadAlumnos" name="CantidadAlumnos" value = <?php echo $fila['cantidad_alumnos']; ?>>
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
</div>
   <form action="EditarAula.php" method="post">
     <input type="hidden" value="<?php echo $_GET['id'] ;?>" name="id1" class="form-control"/>
     <input type="submit" name="submit" class="btn btn-info" value="Confirmar" />
   </form>
  </div>
</form>

<?php
if (isset($_POST['id1']))
{
  $_id = strip_tags($_POST['id1']);
  $_nombre= strip_tags($_POST['NombreAula']);
  $_cantDeAlumnos= strip_tags($_POST['CantidadAlumnos']);
  $_categorias= $_POST['categoria'];

  $sql3 = "UPDATE Aulas SET nombre = '$_nombre',cantidad_alumnos = $_cantDeAlumnos WHERE id_Aulas=".$_POST['id1'].";";
  $dblink->query($sql3);

  $sql4 = "DELETE FROM Aulas_Categoria WHERE id_Aula = $_id;";
  $dblink->query($sql4);

  foreach ($_categorias as  $Categoria) {
    $sql5 = "INSERT INTO Aulas_Categoria(id_Aulas_Categoria,id_Aula,id_Categoria) VALUES(NULL,$_id,$Categoria);" ;

    $dblink->query($sql5);
    if ($dblink->query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $dblink->error;
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

  $sql_log_eda = "INSERT INTO Logs (id_Log,nombre_usuario,num_interno_usuario,correo_usuario,tipo_usuario,Accion,Fecha_Accion) VALUES (NULL,'" . $infoUs['nombre'] . "','" . $infoUs['num_interno'] . "','" . $infoUs['E_Mail'] . "','" . $rolDeUsuario . "','Se edito un aula llamada $_nombre',now())";
  $dblink->query($sql_log_eda);
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
} else {
    echo "Por favor registrese Aqui";
    ?>
    <a  class="btn btn-dark" href="../index.php"> Home Page</a>
<?php
}
?>
</body>

</html>
