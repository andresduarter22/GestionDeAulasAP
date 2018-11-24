<html>
<head>
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
  session_start();
  $db_name = "bd_aulasperronas";
  $db_user = "root";
  $db_pass = "";
  $dblink = new mysqli('localhost', $db_user, $db_pass, $db_name);
  if ($dblink->connect_error) {
    die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
          . $dblink->connect_error);
  }

    //Using GET
    $_idDeCategoria = $_GET['id'];
    $sql = "select * from Categorias where id_Categorias= $_idDeCategoria ;";
    $result = $dblink->query($sql);
  ?>
  <!-- holaaa -->
  <?php   while ($fila = $result->fetch_object()){  ?>
<form action="CrearCategoria.php"  method="post">
  <div class="container">
    <input type="hidden" class="form-control" id="id1" name="id1" value= <?php echo "$_idDeCategoria" ?>>
  <div class="form-group scrollbar">
    <label for="NombreAula">Nombre:</label>
    <input type="text" class="form-control" id="NombreCategoria" name="NombreCategoria" value= <?php echo "$fila->nombre_categoria" ?>>
  </div>
  <div class="form-group">
    <label for="CantidadDeAlumnos">Descripcion:</label>
    <textarea class="form-control" id="Descripcion" value= <?php echo "  $fila->descripcion "; ?> name="Descripcion">
<?php echo "  $fila->descripcion "; ?>
    </textarea/>
  </div>
  <form action="CrearCategoria.php" method="post">
    <input type="hidden" name="id" value=<?php echo $_idDeCategoria ;  ?> class="form-control">
    <input type="submit" name="submit" value="Confirmar" class="btn">
  </form>
    </div>
</form>
<?php }?>

<?php
if (isset($_POST['submit']))
{
   edit1();
}
function edit1(){
  $db= new Database();
  $dblink= $db->getConnection();
  $_nombre= $_POST['NombreCategoria'];
  $_descripcion= $_POST['Descripcion'];
  $_idDeCategoria=$_POST['id1'];

  $sql = "UPDATE Categorias SET nombre_categoria = $_nombre,descripcion=$_descripcion WHERE id_Categorias = $_idDeCategoria";
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
