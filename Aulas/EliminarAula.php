<html>
<head>
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
?>
  <input type="text" name="id1" value= <?php echo  $_GET['id'] ;?> class="form-control" disabled />
  <form method="post" action=<?php echo '"EliminarAula.php?id='.$_GET['id'].'"' ?>>
      <input type="hidden" value="<?php echo $_GET['id'] ;?>" name="id1" class="form-control"/>
      <input type="submit" name="submit" class="btn btn-primary" value="Confirmar" />
  </form>
  <?php
  if(isset($_POST['id1'])){
    $_id=$_POST['id1'];
    $sql1= "DELETE from Aulas WHERE id_Aulas = ".$_id;
    $dblink->query($sql1);
  }
   ?>
<!-- Boton para ir Atras -->
<a class="btn btn-primary" href="GestionDeAulas.php">Atras</a>
  <button><a href="GestionDeAulas.php">Confirmar</a>
  </button>
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
   <script src="js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="js/bootstrap.min.js" ></script>
</body>

</html>
