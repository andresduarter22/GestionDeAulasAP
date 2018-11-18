<html>
<head>
  <title>Gestion de Aulas</title>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body >
  <button type="button" class="btn btn-danger">Cerrar sesión</button>
    <a href="../Homes/HomeLogeado.php"><img src="Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image" ></a>
  <?php
   $db_name = "bd_aulasperronas";
   $db_user = "root";
   $db_pass = "";
   $dblink = new mysqli('localhost', $db_user, $db_pass, $db_name);
   if ($dblink->connect_error) {
     die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
           . $dblink->connect_error);
   }

   $sql = "select * from aulas;";
   $result = $dblink->query($sql);
?>
<div class="container" >


<table class=" table table-striped table-bordered  table-responsive-sm m-5 scrollbar " >
  <thead  class="thead-dark">
    <tr>
      <th style="width: 30%"> Nombre Del Aula </th>
      <th style="width: 10%">Editar</th>
      <th style="width: 20%"> Borrar</th>
    </tr>
  </thead>
   <tbody>
    <?php   while ($fila = $result->fetch_object()){  ?>
     <tr>
        <td><?php echo " $fila->nombre"; ?></td>
        <td><?php echo "<a href=\"EditarAula.php\" class=\"btn btn-primary\">Editar";?></td>
        <td><?php echo '<a href= EliminarAula.php ?id_Aulas=$fila["id_Aulas"] class= "btn btn-primary" >Borrar';?></td>
         </tr>
    <?php } ?>
    <?php
     $dblink->close();
     ?>
  </tbody>
</table>
</div>

  <button><a href="CrearAula.php" >Crear Aula</a></button>
  <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>
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

   <!-- jQuery -->
   <script src="js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="js/bootstrap.min.js" ></script>
 </body>

</html>
