<html>
<head>
  <link rel="stylesheet" href="css/bootstrap.css" >

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
  <link href="custom.css" type="text/css" rel="stylesheet" />
  <button type="button" class="btn btn-danger">Cerrar sesión</button>
    <a href="GestionDeAulas.php"><img src="Logo_UPB.jpg" class="img-fluid " alt="Responsive image" ></a>
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
<table class="table table-striped table-bordered  table-responsive-sm m-5">
  <thead  class="thead-dark">
    <tr>
      <th style="width: 15%"> Nombre Del Aula </th>
      <th style="width: 10%">Editar</th>
      <th style="width: 20%"> Borrar</th>
    </tr>
  </thead>
   <tbody>
    <?php   while ($fila = $result->fetch_object()){  ?>
     <tr>
        <td><?php echo " $fila->nombre"; ?></td>
        <td><?php echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\"><a href=\"EditarAula.php\">Editar";?></td>
        <td><?php echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#exampleModal\"> Borrar";?></td>
     </tr>
     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body">
             AIUDA
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             <button type="button" class="btn btn-primary">Save changes</button>
           </div>
         </div>
       </div>
     </div>
    <?php } ?>
    <?php
     $dblink->close();
     ?>
  </tbody>
</table>

  <button><a href="CrearAula.php">Crear Aula</a></button>

   <!-- jQuery -->
   <script src="js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="js/bootstrap.min.js" ></script>
 </body>

</html>
