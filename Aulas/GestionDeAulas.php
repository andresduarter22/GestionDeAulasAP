<html>
<head>
  <link href="Style.css" type="text/css" rel="stylesheet" />

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
     <?php  while ($fila = $result->fetch_object()) {
        ?> <li><<?php $fila->id_Aulas  ?> - <<?php  $fila->nombre ?> - <<?php $fila->cantidad_alumnos ?> -
          <button><a href="EditarAula.php">Editar Aula</a></button> - <button><a href="BorarAula.php">Borrar Aula</a></button> </li>";
      }

  </ul>

  <button><a href="CrearAula.php">Crear Aula</a>
  </button>
  <?php
   $dblink->close();
   ?>
</body>

</html>
