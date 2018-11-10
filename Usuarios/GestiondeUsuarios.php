  <html>
  <head>
    <title>Gestion de Usuarios</title>

    <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="css/bootstrap.css" >

   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  </head>
  <body>
    <button type="button" class="btn btn-danger">Cerrar sesión</button>
        <a href="GestionDeAulas.php"><img src="Logo_UPB.jpg" class="img-fluid " alt="Responsive image"></a>
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
       <table class="table table-striped table-bordered  table-responsive-sm m-5s">
       <thead  class="thead-dark">
         <tr>
           <th style="width: 15%">Nombre de usuario </th>
           <th style="width: 10%">Numero de interno</th>
           <th style="width: 20%"> Correo</th>
           <th style="width: 10%">Rol</th>
           <th style="width: 10%">Editar</th>
           <th style="width: 10%">Borrar</th>
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
             <td><?php echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\"><a href=\"EditarUsuario.php\">Editar";?></td>
             <td><?php echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\"data-target=\"#exampleModal\">Borrar";?></td>
          </tr>
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Advertincia</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Esta seguro que desea borrar el usuario
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
         <<?php } ?>
         <?php
          $dblink->close();
          ?>
       </tbody>
     </table>

     <button><a href="CrearUsuario.php">Crear Usuario</a></button



     <!-- jQuery -->
     <script src="js/jquery-3.3.1.min.js"></script>

     <!-- Bootstrap JS -->
     <script src="js/bootstrap.min.js" ></script>

  </body>

  </html>
