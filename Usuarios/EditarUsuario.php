<html>
<head>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Editar Usuarios</title>
</head>
<body>
  <button type="button" class="btn btn-danger">Cerrar sesión</button>
  <a href="GestionDeUsuarios.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right"  alt="Responsive image" ></a>
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
   $var_value = $_SESSION['id'];
   echo "$var_value";
   //Using GET
   $_idDeUsuario = $_GET['id'];
   $sql = "select * from Usuarios where id_Usuario= $_idDeUsuario ;";
   $result = $dblink->query($sql);
?>
<!--
<div class="custom-control custom-checkbox">
  <input type="checkbox" class="custom-control-input" id="customCheck1">
  <label class="custom-control-label" for="customCheck1">Administrador</label>
  <input type="checkbox" class="custom-control-input" id="customCheck2">
  <label class="custom-control-label" for="customCheck1">Actualizador</label>
  <input type="checkbox" class="custom-control-input" id="customCheck3">
  <label class="custom-control-label" for="customCheck1">Administrador</label>
</div>
-->
<div class="container" >
<select class="custom-select" value=1>
  <option selected>Categoria de Usuario</option>
  <option value="1">Administrador</option>
  <option value="2">Actualizador</option>
  <option value="3">Reservador</option>
</select>

<?php   while ($fila = $result->fetch_object()){  ?>
<div class="form-group">
  <label for="NombreAula">Nombre:</label>
  <input type="text" value= <?php echo "  $fila->nombre "; ?> class="form-control" id="usr">
</div>
<div class="form-group">
  <label for="num_interno">Numero de Interno:</label>
  <input type="text" value= <?php echo "  $fila->num_interno "; ?> class="form-control" id="interno">
</div>
<div class="form-group">
  <label for"E_Mail">E-Mail:</label>
  <input type="text"value= <?php echo "  $fila->E_Mail "; ?>  class="form-control" id="e_mail">
</div>
<?php }?>

  <button><a href="GestionDeUsuarios.php">Confirmar</a>  </button>
  <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>

  <?php
   $dblink->close();
   ?>
</div >
   <!-- jQuery -->
   <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="../Booststrap/js/bootstrap.min.js" ></script>
</body>

</html>
