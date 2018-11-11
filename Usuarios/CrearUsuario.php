<html>
<head>
  <link rel="stylesheet" href="css/bootstrap.css" >

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Crear Usuarios</title>
</head>
<body>
  <button type="button" class="btn btn-danger">Cerrar sesión</button>
    <a href="GestionDeUsuarios.php"><img src="Logo_UPB.jpg" class="img-fluid float-right"  alt="Responsive image" ></a>
  <?php
   $db_name = "bd_aulasperronas";
   $db_user = "root";
   $db_pass = "";
   $dblink = new mysqli('localhost', $db_user, $db_pass, $db_name);
   if ($dblink->connect_error) {
     die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
           . $dblink->connect_error);
   }

   $sql = "select * from usuario;";
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
<select class="custom-select">
  <option selected>Categoria de Usuario</option>
  <option value="1">Administrador</option>
  <option value="2">Actualizador</option>
  <option value="3">Reservador</option>
</select>
<div class="form-group">
  <label for="NombreAula">Nombre:</label>
  <input type="text" class="form-control" id="usr">
</div>
<div class="form-group">
  <label for="num_interno">Numero de Interno:</label>
  <input type="text" class="form-control" id="interno">
</div>
<div class="form-group">
  <label for"E_Mail">E-Mail:</label>
  <input type="text" class="form-control" id="e_mail">
</div>


  <button><a href="GestionDeUsuarios.php">Confirmar</a>
  </button>
  <?php
   $dblink->close();
   ?>

   <!-- jQuery -->
   <script src="js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="js/bootstrap.min.js" ></script>
</body>

</html>
