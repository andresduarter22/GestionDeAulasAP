<html>
<head>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Editar Categoria</title>
</head>
<body>
  <div>
    <button type="button" class="btn btn-danger">Cerrar sesión</button>
      <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image" ></a>
  </div>
  <br/>

  <?php
    include "../Config/Database.php";
    $db= new Database();
    $dblink= $db->getConnection();
  ?>
  <!-- holaaa -->
<form action="CrearCategoria.php"  method="post">
  <div class="form-group scrollbar">
    <label for="NombreAula">Nombre:</label>
    <input type="text" class="form-control" id="NombreCategoria" name="NombreCategoria">
  </div>
  <div class="form-group">
    <label for="CantidadDeAlumnos">Descripcion:</label>
    <textarea class="form-control" id="Descripcion" name="Descripcion">

    </textarea/>
  </div>
  <form action="CrearCategoria.php" method="post">
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
  $_nombre= $_POST['NombreCategoria'];
  $_descripcion= $_POST['Descripcion'];

  $sql = "insert into Categorias(id_Categorias,nombre_categoria,descripcion) values(NULL,'$_nombre','$_descripcion')";
  if ($dblink->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $dblink->error;
  }

}

?>
<!-- Boton para ir Atras -->
<a class="btn btn-primary" href="GestionDeCategorias.php">Atras</a>
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
 <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

 <!-- Bootstrap JS -->
 <script src="../Booststrap/js/bootstrap.min.js" ></script>
</body>

</html>
