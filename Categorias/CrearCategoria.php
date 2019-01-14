<html>
<head>
  <!-- jQuery -->
  <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="../Booststrap/js/bootstrap.min.js" ></script>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Crear Categoria</title>
</head>
<body>
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
  <br/>

  <?php
    include "../Config/DataBase.php";
    $db= new Database();
    $dblink= $db->getConnection();
  ?>

<form action="CrearCategoria.php"  method="post">
  <div class="container">
    <div class="form-group scrollbar">
      <label for="NombreAula">Nombre:</label>
      <input type="text" class="form-control" id="NombreCategoria" name="NombreCategoria" required>
    </div>
    <div class="form-group">
      <label for="CantidadDeAlumnos">Descripcion:</label>
      <textarea class="form-control" id="Descripcion" name="Descripcion" required></textarea/>
    </div>
    <form action="CrearCategoria.php" method="post">
      <input type="submit" name="submit" value="Confirmar" class="btn btn-info">
    </form>
  </div>
</form>
<?php
if (isset($_POST['submit']))
{
   create();
}
function create(){
  $db= new Database();
  $dblink= $db->getConnection();
  $_nombre= strip_tags($_POST['NombreCategoria']);
  $_descripcion= strip_tags($_POST['Descripcion']);
  $sql_crear_info = "INSERT INTO Categorias(id_Categorias,nombre_categoria,descripcion) VALUES(NULL,'$_nombre','$_descripcion')";
  if ($dblink->query($sql_crear_info) === FALSE) {
    echo "Error: " . $sql_crear_info . "<br>" . $dblink->error;
  }

// the message
//$msg = "Se creo la categoria: ";
// use wordwrap() if lines are longer than 70 characters
//$msg1 = wordwrap($msg,70);
// send email
//mail("andresduarter13@gmail.com","Prueba",$msg1);
header("Location: GestionDeCategorias.php");
  $sql_log = "INSERT INTO Logs (id_Log,nombre_usuario,num_interno_usuario,correo_usuario,tipo_usuario,Accion,Fecha_Accion) VALUES (NULL,'Andres','666','ad@gmail.com','m','Se creo una categoria llamada $_nombre',now())";
  $dblink->query($sql_log);
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
        Esta es la pantalla donde se puede crear una nueva categoria.

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Final boton de Informacion -->
</body>

</html>
