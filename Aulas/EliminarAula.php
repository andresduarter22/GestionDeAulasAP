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

  <button><a href="GestionDeAulas.php">Atras</a>
  <button><a href="GestionDeAulas.php">Confirmar</a>
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
