<html>
<head>
  <title>Gestion de Usuarios</title>

  <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="css/bootstrap.min.css" >

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
     die('Error al conectar a la Base de Datos (' .  $dblink->connect_errno . ') '
           . $dblink->connect_error);
   }
   $sql = "select * from usuarios;";
   $result = $dblink->query($sql);
   ?>
   <table class="table table-striped table-bordered table-dark">
     <thead>
       <tr>
         <th>Nombre de usuario </th>
         <th>Numero de interno</th>
         <th>Correo</th>
         <th>Rol</th>
         <th>Editar</th>
         <th>Borrar</th>
       </tr>
     </thead>
     <tbody>
       <<?php   while ($fila = $result->fetch_object()){  ?>
        <tr>
           <td><?php echo " $fila->nombre"; ?></td>
           <td><?php echo "$fila->num_interno";  ?></td>
           <td><?php echo " $fila->E_Mail"; ?></td>
           <td><?php if ($fila->Rol ==0 ) {
             echo "reservador";
           } elseif ($fila->Rol ==1 ) {
             echo "actualizador";
           } else {
             echo "Administrador";
           }
            "$fila->Rol";  ?></td>
           <td><?php echo "<a href=\"EditarUsuario.php\"> Editar";?></td>
           <td><?php echo "<a href=\"EliminarUsuario.php\"> Borrar";?></td>
        </tr>
       <<?php } ?>
     </tbody>
   </table>
   <!-- jQuery -->
   <script src="js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="js/bootstrap.min.js" ></script>

</body>

</html>
