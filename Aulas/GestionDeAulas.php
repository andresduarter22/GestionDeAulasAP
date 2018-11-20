<html>
<head>
  <title>Gestion de Aulas</title>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body >
  <button type="button" class="btn btn-danger">Cerrar sesión</button>
    <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image" ></a>
    <?php
      //Conexion con base
      include "../Config/Database.php";
      session_start();
      $db= new Database();
      $dblink= $db->getConnection();
      $sql = 'select * from Aulas;';
      $result = $dblink->query($sql);
      $result->setFetchMode(PDO::FETCH_ASSOC);
    ?>
<div class="container form-group" >
<table class=" table table-striped table-bordered  table-responsive-sm m-5 scrollbar " >
  <thead  class="thead-dark">
    <tr>
      <th style="width: 30%"> Nombre Del Aula </th>
      <th style="width: 10%">Editar</th>
      <th style="width: 20%"> Borrar</th>
    </tr>
  </thead>
   <tbody>
    <?php   while ($fila = $result->fetch()){  ?>
     <tr>
        <td><?php echo $fila['nombre']; ?></td>
        <td><?php echo "<a href=\"EditarAula.php\" class=\"btn btn-primary\">Editar";?></td>
        <td><?php echo '<a href= EliminarAula.php ?id_Aulas=$fila["id_Aulas"] class= "btn btn-danger" >Borrar';?></td>
         </tr>
    <?php } ?>

  </tbody>
</table>
</div>
<!-- Boton para ir Atras -->
<a class="btn btn-primary" href="HomeLogeado.php">Atras</a>
<a href="CrearAula.php" class="btn btn-primary" >Crear Aula</a>
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
