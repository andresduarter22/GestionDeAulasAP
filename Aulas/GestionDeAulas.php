<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
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
   Aulas:<br>
   <ul>
     <?php while ($fila = $result->fetch_object()) {
       echo"<li> $fila->nombre  -  <a href = \"EditarAula.php\">Editar</a> -  <a href = \"BorrarAula.php\">Borrar</a> </li>"
     ; } ?>
  </ul>

  <button><a href="CrearAula.php">Crear Aula</a></button>
  <?php
   $dblink->close();
   ?>
   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>

</html>
