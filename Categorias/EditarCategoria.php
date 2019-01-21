<html>
<head>
  <!-- jQuery -->
  <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="../Booststrap/js/bootstrap.min.js" ></script>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Editar Categoria</title>
</head>
<body>
  <?php session_start();
  //echo var_dump($_SESSION['idUsuario']);
  if (isset($_SESSION['idUsuario'])) { ?>
    <div>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button type="button" class="btn btn-danger">Log Out</button>
      </nav>
      <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.png" class="img-fluid float-right" alt="Responsive image" ></a>
    </div>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>

  <?php
  include "../Config/DataBase.php";
  $db= new Database();
  $dblink= $db->getConnection();

    //Using GET
    $_idDeCategoria = $_GET['id'];
    $sql = "SELECT * FROM Categorias WHERE id_Categorias= $_idDeCategoria ;";
    $result = $dblink->query($sql);
    //echo $_SERVER['REQUEST_METHOD']
  ?>
  <!-- holaaa -->
  <?php   while ($fila = $result->fetch()){?>
<form method="post" action=<?php echo '"EditarCategoria.php?id='.$_GET['id'].'"' ?>>
  <div class="container">
    <input type="hidden" class="form-control" id="id" name="id" value= "<?php echo $_GET['id'] ;?>">
  <div class="form-group scrollbar">
    <label for="NombreAula">Nombre:</label>
    <input type="text" class="form-control" id="NombreCategoria" name="NombreCategoria" value= "<?php echo $fila['nombre_categoria']; ?>">
  </div>
  <div class="form-group">
    <label for="CantidadDeAlumnos">Descripcion:</label>
    <textarea class="form-control" id="Descripcion" value= "<?php echo $fila['descripcion']; ?>" name="Descripcion">
<?php echo  $fila['descripcion']; ?>
    </textarea/>
  </div>
    <input type="hidden" value="<?php echo $_GET['id'] ;?>" name="id1" class="form-control"/>
    <input type="submit" name="submit" class="btn btn-info" value="Confirmar" />
  </div>
</form>
<?php } ?>

<?php
if (isset($_POST['id1'])){
  $_id= strip_tags($_POST['id1']);
  $_nombre= strip_tags($_POST['NombreCategoria']);
  $_descripcion= strip_tags($_POST['Descripcion']);
  $sql_editar_info = "UPDATE Categorias SET nombre_categoria ='".$_nombre."',descripcion='".$_descripcion."' WHERE id_Categorias =".$_POST['id1'].";";
  if ($dblink->query($sql_editar_info) === FALSE) {
    echo "Error: " . $sql_editar_info . "<br>" . $dblink->error;
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

  $sql_log_ec = "INSERT INTO Logs (id_Log,nombre_usuario,num_interno_usuario,correo_usuario,tipo_usuario,Accion,Fecha_Accion) VALUES (NULL,'" . $infoUs['nombre'] . "','" . $infoUs['num_interno'] . "','" . $infoUs['E_Mail'] . "','" . $rolDeUsuario . "','Se edito una categoria llamada $_nombre',now())";
  $dblink->query($sql_log_ec);
header("Location: GestionDeCategorias.php");
}
?>
<!-- Boton para ir Atras -->
<a class="btn btn-primary" href="GestionDeCategorias.php">Atras</a>
<!-- Inicio boton de informacion -->
<button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#infoA"><img  src="../Images/iconoInfo.png"  class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>
<div class="modal fade" id="infoA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Esta es la pantalla donde se puede editar la informacion del aula seleccionada.

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Final boton de Informacion -->
<?php
}else{
  ?>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    </nav>
    <a href="../Homes/Home.php"><img src="../Images/Logo_UPB.png" class="img-fluid float-right" alt="Responsive image" ></a>
  </div>
  <?php
  echo "Por favor inicie sesion";
}
 ?>
</body>

</html>
