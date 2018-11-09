<html>
<head>
  <title>Gestion de Usuarios</title>

  <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body>
  <link href="custom.css" type="text/css" rel="stylesheet" />
  <button class="button">Cerrar sesión</button>

    <br>
    <?php
   $db_name = "bd_aulasperronas";
   $db_user = "root";
   $db_pass = "";
   $dblink = new mysqli('localhost', $db_user, $db_pass, $db_name);
   if ($dblink->connect_error) {
     die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
           . $dblink->connect_error);
   }
   $sql = "select * from usuarios;";
   $result = $dblink->query($sql);
   ?>
   <table class="table table-striped table-bordered">
     <thead>
       <tr>
         <th>Nombre de usuario </th>
         <th>Numero de interno</th>
         <th>Correo</th>
         <th>Rol</th>
       </tr>
     </thead>
     <tbody>
       <<?php   while ($fila = $result->fetch_object()){  ?>
        <tr>
           <td><?php echo " $fila->nombre"; ?></td>
           <td><?php echo "$fila->num_interno";  ?></td>
           <td><?php echo " $fila->E_Mail"; ?></td>
           <td><?php echo "$fila->Rol";  ?></td>

        </tr>
       <<?php } ?>
     </tbody>
   </table>
   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>

</html>
