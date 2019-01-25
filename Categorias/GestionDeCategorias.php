<html>
<head>
  <!-- jQuery -->
  <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="../Booststrap/js/bootstrap.min.js" ></script>
  <title>Gestion de Categorias</title>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
      <a class="navbar-brand" href="GestionDeCategorias.php">Categorias</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="../Aulas/GestionDeAulas.php">Aulas</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
    </nav>
    <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.png" class="img-fluid float-right" alt="Responsive image" ></a>
  </div>
  <?php
      //Conexion con base
      include "../Config/DataBase.php";
      $db= new Database();
      $dblink= $db->getConnection();
      $sql = 'SELECT * FROM Categorias;';
      $result = $dblink->query($sql);
      $result->setFetchMode(PDO::FETCH_ASSOC);
    ?>
  </br>
<div class="container form-group" >
  <div class=" pre-scrollable">
   <table class="table table-striped table-bordered" >
    <thead  class="thead-dark">
     <tr>
      <th style="width: 30%">Nombre de la Categoria</th>
      <th style="width: 10%">Editar</th>
      <th style="width: 20%">Borrar</th>
    </tr>
  </thead>
   <tbody>
    <?php   while ($fila = $result->fetch()){  ?>
     <tr>
        <td><?php echo $fila['nombre_categoria']; ?></td>
        <td>
          <form method="get" action="EditarCategoria.php">
             <input type="hidden" name="id" value=<?php echo $fila['id_Categorias'] ;  ?> class="form-control">
             <input type="submit" class="btn btn-primary" value="Editar">
           </form>
         </td>
         <td>
           <form method="get" action="EliminiarCategoria.php">
              <input type="hidden" name="id" value=<?php echo $fila['id_Categorias'] ;  ?> class="form-control">
              <input type="submit" class="btn btn-danger" value="Borrar">
            </form>
          </td>
         </tr>
    <?php } ?>

   </tbody>
  </table>
 </div>
</div>
<!-- Boton para ir Atras -->
<a class="btn btn-primary" href="../Homes/HomeLogeado.php">Atras</a>
<a href="CrearCategoria.php" class="btn btn-primary" >Crear Categoria</a>
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
        Esta es la pantalla donde se puede consultar la lista de Categorias dentro de la base de Datos
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
