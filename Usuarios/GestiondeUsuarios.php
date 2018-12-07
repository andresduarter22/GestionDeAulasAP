<?php
  if (isset($_POST['submit']))  {
    delete();
  }
  function delete(){
    echo "borra";
  }


 ?>

<html>
  <head>
    <!-- jQuery -->
    <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../Booststrap/js/bootstrap.min.js" ></script>
    <title>Gestion de Usuarios</title>

   <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >

   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  </head>
  <body>
    <button type="button" class="btn btn-danger">Cerrar sesión</button>
    <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image"></a>
      <?php
        //Conexion con base
        include "../Config/Database.php";
        session_start();
        $db= new Database();
        $dblink= $db->getConnection();
        $sql = 'select * from usuarios;';
        $result = $dblink->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
      ?>
    <div class="container" >
     <table class="table table-striped table-bordered  table-responsive-sm  scrollbar">
     <thead  class="thead-dark">
       <tr>
         <th style="width: 15%">Nombre de usuario </th>
         <th style="width: 10%">Numero de interno</th>
         <th style="width: 20%">Correo</th>
         <th style="width: 10%">Rol</th>
         <th style="width: 10%">Editar</th>
         <th style="width: 10%">Borrar</th>
       </tr>
     </thead>
        <tbody>
          <?php   while ($fila = $result->fetch()){  ?>
          <tr>
             <td><?php echo $fila['nombre']; ?></td>
             <td><?php echo $fila['num_interno']; ?></td>
             <td><?php echo $fila['E_Mail']; ?></td>
             <td><?php if ($fila['Rol']==0 ) {
               echo "Reservador";
             } elseif ($fila['Rol'] == 1 ) {
               echo "Actualizador";
             } else {
               echo "Administrador";
             }
                ?></td>
             <td> <?php
                  $_idUs=$fila['id_Usuario'];
                  echo "<a href=\"EditarUsuario.php?id=$_idUs\" class=\"btn btn-primary\">Editar";
                ?>
              </td>
             <td><?php echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\"data-target=\"#exampleModal" .$fila['id_Usuario'] . "\"> Borrar";
                  $idDEUSUARI=$_idUs;
                ?></td>
          </tr>
          <div class="modal fade" id="exampleModal<?php echo $fila['id_Usuario']; ?>" ta  bindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Esta seguro que desea borrar el usuario, incluidas sus reservas y todo lo relacionado a este usuario?
                </div>
                <div class="modal-footer">

                  <button type="button" class="btn " > <a href="Methods.php?id=<?php echo $fila['id_Usuario'];?>" >  Eliminar </button>

                </div>
              </div>
            </div>
          </div>
         <?php } ?>
       </tbody>
     </table>
   </div>
   <button><a href="CrearUsuario.php">Crear nuevo usuario</a></button>

   <a class="btn btn-primary" href="../Homes/HomeLogeado.php">Atras</a>
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
  </body>

  </html>
