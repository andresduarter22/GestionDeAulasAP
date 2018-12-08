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
  <div >
    <button type="button" class="btn btn-danger">Cerrar sesión</button>
      <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image" ></a>
  </div>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>

  <?php
  include "../Config/Database.php";
  $db= new Database();
  $dblink= $db->getConnection();

    //Using GET
    $_idDeCategoria = $_GET['id'];
    $_nombre = $_POST['NombreCategoria'];
    $_descripcion = $_POST['Descripcion'];
    $sql = "SELECT * FROM Categorias WHERE id_Categorias= $_idDeCategoria ;";
    $result = $dblink->query($sql);
    //echo var_dump($_nombre);
    //echo var_dump($_descripcion);
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
    <input type="submit" name="submit" class="btn btn-primary" value="Confirmar" />
  </div>
</form>
<?php } ?>

<?php
if (isset($_POST['id1'])){
  $_id= $_POST['id1'];
  $_nombre= $_POST['NombreCategoria'];
  $_descripcion= $_POST['Descripcion'];
  //echo var_dump($_nombre);
  //echo var_dump($_descripcion);
  $sql1 = "UPDATE Categorias SET nombre_categoria ='".$_nombre."',descripcion='".$_descripcion."' WHERE id_Categorias =".$_POST['id1'].";";
//  echo var_dump($sql1);
  $dblink->query($sql1);
  if ($dblink->query($sql1) === FALSE) {
    echo "Error: " . $sql . "<br>" . $dblink->error;
  }

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
        Esta es la pantalla donde se puede editar la informacion del aula seleccionada

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
