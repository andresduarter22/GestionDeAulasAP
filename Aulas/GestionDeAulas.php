<html>
<head>
  <!-- jQuery -->
  <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="../Booststrap/js/bootstrap.min.js" ></script>
  <title>Gestion de Aulas</title>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body >
  <?php session_start();
  //echo var_dump($_SESSION['idUsuario']);
  if (isset($_SESSION['idUsuario'])) { ?>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <button type="button" class="btn btn-danger">Log Out</button>
    </nav>
    <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.png" class="img-fluid float-right" alt="Responsive image" ></a>
  </div>
  <?php
      include "../Config/DataBase.php";
      $db= new Database();
      $dblink= $db->getConnection();
      $sql = 'SELECT * FROM Aulas ORDER BY nombre;';
      $result = $dblink->query($sql);
    ?>
  </br>
<div class="container" >
  <div class="pre-scrollable">
   <table class="table table-striped table-bordered" >
    <thead  class="thead-dark">
     <tr>
      <th style="width: 30%">Nombre Del Aula </th>
      <th style="width: 10%">Editar</th>
      <th style="width: 20%">Borrar</th>
    </tr>
  </thead>
   <tbody>
    <?php   while ($fila = $result->fetch()){  ?>
     <tr>
        <td><?php echo $fila['nombre']; ?></td>
          <td>
            <form method="get" action="EditarAula.php">
               <input type="hidden" name="id" value=<?php echo $fila['id_Aulas'] ;  ?> class="form-control">
               <input type="submit" class="btn btn-primary" value="Editar">
             </form>
           </td>
           <td>
             <?php
            echo "<button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\"data-target=\"#borrarAula" .$fila['id_Aulas'] . "\"> Borrar";
             $idAula= $fila['id_Aulas'];
//           echo var_dump ($fila['id_Aulas']);
                  ?>
            <!-- <form method="get" action="EliminarAula.php">
                <input type="hidden" name="id" value=<?php //echo $fila['id_Aulas'] ;  ?> class="form-control">
                <input type="submit" class="btn btn-primary" value="Borrar">
              </form>-->
            </td>
         </tr>
         <div class="modal fade" id="borrarAula<?php echo $fila['id_Aulas']; ?>" ta  bindex="-1" role="dialog" aria-labelledby="borrarAulaLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
             <div class="modal-content">
               <div class="modal-header">
                 <h5 class="modal-title" id="borrarAulaLabel">Advertencia</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
               <div class="modal-body">
                 Esta seguro que desea borrar esta aula?
               </div>
               <div class="modal-footer">
                 <a class="btn btn-primary" href="EliminarAula.php?id=<?php echo $fila['id_Aulas'];?>" value = "Eliminar" Name="id_borrar">  Confirmar </a>
               </div>
             </div>
           </div>
         </div>
    <?php } ?>

   </tbody>
  </table>
 </div>
</div>
<!-- Boton para ir Atras -->
<a class="btn btn-primary" href="../Homes/HomeLogeado.php">Atras</a>
<a href="CrearAula.php" class="btn btn-primary " >Crear Aula</a>
<!-- Inicio boton de informacion -->
<button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#infoA"><img  src="../Images/iconoInfo.png"  class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>
<div class="modal fade" id="infoA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Esta es la pantalla donde se puede consultar toda la lista de Aulas dentro de la base de Datos

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Final boton de Informacion -->

<?php
} else {
    echo "Por favor registrese Aqui";
    ?>
    <a  class="btn btn-dark" href="../Homes/Home.php"> Home Page</a>
<?php
}
?>
 </body>

</html>
