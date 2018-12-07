<html>
<head>
  <!-- jQuery -->
  <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="../Booststrap/js/bootstrap.min.js" ></script>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body>
  <button type="button" class="btn btn-danger">Cerrar sesión</button>
    <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image" ></a>
  <?php
   $db_name = "bd_aulasperronas";
   $db_user = "root";
   $db_pass = "";
   $dblink = new mysqli('localhost', $db_user, $db_pass, $db_name);
   if ($dblink->connect_error) {
     die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
           . $dblink->connect_error);
   }

   $sql = "select * from aulas where id_Aulas=".$_GET['id'];
   $result = $dblink->query($sql);
   $fila = $result->fetch_object();
   //echo $_SERVER['REQUEST_METHOD']
?>
<br/>
<br />
<br />
<br />
<br />
<br/>
<br />
<br />
<br />
<br />
 <input type="text" name="id2" value= 'Desea eliminar el aula: <?php echo $fila->nombre; ?>?' class="form-control" disabled />
  <form method="post" action=<?php echo '"EliminarAula.php?id='.$_GET['id'].'"' ?>>
      
      <br/>
      <br />
      <br />
      <br />
      <br />
      <input type="hidden" value="<?php echo $_GET['id'] ;?>" name="id1" class="form-control"/>
      <input type="submit" name="submit" class="btn btn-primary" value="Confirmar" />
  </form>
  <?php
  if(isset($_POST['id1'])){
    $_id=$_POST['id1'];
    $sql1= "DELETE from Aulas WHERE id_Aulas = ".$_id.";";
    $dblink->query($sql1);
  }
   ?>
<!-- Boton para ir Atras -->
<a class="btn btn-primary" href="GestionDeAulas.php">Atras</a>
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
        Esta es la pantalla donde se puede eliminar el aula seleccionada.

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
