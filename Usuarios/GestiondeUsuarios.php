<html>
<head>
</head>
<body>
  <link href="custom.css" type="text/css" rel="stylesheet" />
  <button class="button">Cerrar sesión</button>
  <img src="Logo_UPB.jpg" alt="Paris">
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
   // echo "Voy a ejecutar: $sql<br>";
   $result = $dblink->query($sql);
   echo "Aulas:<br>\n";
   echo "<ul>";
   while ($fila = $result->fetch_object()) {
     echo "<li><a href=\"frutas2.php?categoria=$fila->id_Aulas\">$fila->nombre</a> - $fila->cantidad_alumnos</li>";
   }
   echo "</ul>";
   // Cerrar la conexion a la base
   $dblink->close();
   ?>
</body>

</html>
