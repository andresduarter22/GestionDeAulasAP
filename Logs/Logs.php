<html>
<head>
  <title>Tabla de Logs</title>
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
      $sql = 'select * from Logs;';
      $result = $dblink->query($sql);
      $result->setFetchMode(PDO::FETCH_ASSOC);
    ?>
<div class="container form-group" >
<table class=" table table-striped table-bordered  table-responsive-sm m-5 scrollbar " >
  <thead  class="thead-dark">
    <tr>
      <th style="width: 30%">Nombre Reservador</th>
      <th style="width: 10%">Fecha realizada</th>
      <th style="width: 20%">Materia</th>
      <th style="width: 30%">Nombre Del Aula</th>
      <th style="width: 10%">Fecha Inicial</th>
      <th style="width: 20%">Fecha Final</th>
    </tr>
  </thead>
   <tbody>
    <?php   while ($fila = $result->fetch()){  ?>
     <tr>
        <td><?php echo $fila['nombre_usuario']; ?></td>
        <td><?php echo $fila['Fecha_deReserva']; ?></td>
        <td><?php echo $fila['Materia']; ?></td>
        <td><?php echo $fila['Aula']; ?></td>
        <td><?php echo $fila['Fecha_ini']; ?></td>
        <td><?php echo $fila['Fecha_fin']; ?></td>
     </tr>
    <?php } ?>
  </tbody>
</table>
</div>

  <!-- Boton para ir atras-->
  <a href="../Homes/HomeLogeado.php" class="btn btn-primary">Atras</a>
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
          Esta es la pantalla donde se puede consultar toda la lista de Aulas dentro de la base de Datos

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
   <!-- jQuery -->
   <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="../Booststrap/js/bootstrap.min.js" ></script>
 </body>

</html>
