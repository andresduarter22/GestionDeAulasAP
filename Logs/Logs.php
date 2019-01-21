<html>
<head>
  <!-- jQuery -->
  <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>
  <script src="../Booststrap/jquery-ui-1.12.1/jquery-ui.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../Booststrap/js/bootstrap.min.js" ></script>
  <script src="../Booststrap/js/jquery-ui.multidatespicker.js" ></script>
  <title>Tabla de Logs</title>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <link rel="stylesheet" href="../Booststrap/jquery-ui-1.12.1/jquery-ui.min.css">
  <link rel="stylesheet" href="../Booststrap/css/jquery-ui.multidatespicker.css" >
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
      //Conexion con base
      include "../Config/DataBase.php";
      $db= new Database();
      $dblink= $db->getConnection();

    ?>
    <!--Filtro-->
    <div class="container">
      <form  action=<?php echo "Logs.php" ?> method="post">
        Filtro
        <input id="fechaDeInicio" autocomplete="off" name="fechaDeInicio" placeholder="Ingrese fecha de inicio" class="form-control"/>
        <input id="fechaDeFin" autocomplete="off" name="fechaDeFin" placeholder="Ingrese fecha de fin" class="form-control"/>
        <input type="submit" name="submit_fechas" class="btn btn-info" value="Confirmar Filtro por fechas" />
      </form>
      <br/>
      <br/>
      <br/>
      <br/>
      <br/>
      <form action=<?php echo "Logs.php" ?> method="post">
        <input id="NombreFiltro" placeholder="Inserte nombre del usuario en especifico" name="NombreFiltro" class="form-control"/>
        <input type="submit" name="submit_nombre" class="btn btn-info" value="Confirmar Filtro por Nombre de usuario" />
      </form>
    </div>
  <!--Tabla de Logs-->
<div class="container" >
<div class=" pre-scrollable">
  <table class="table table-striped table-bordered  " >
    <thead  class="thead-dark">
    <tr>
      <th style="width: 5%">Nombre</th>
      <th style="width: 10%">Numero Interno</th>
      <th style="width: 10%">Correo Electronico</th>
      <th style="width: 5%">Rango</th>
      <th style="width: 40%">Accion realizada</th>
      <th style="width: 30%">Fecha de la Accion realizada</th>
    </tr>
   </thead>
   <tbody >
    <?php
    $sql = "SELECT * FROM Logs;";
    $result = $dblink->query($sql);
    if($result != null){
    while ($fila = $result->fetch()){  ?>
     <tr>
        <td><?php echo $fila['nombre_usuario']; ?></td>
        <td><?php echo $fila['num_interno_usuario']; ?></td>
        <td><?php echo $fila['correo_usuario']; ?></td>
        <td><?php echo $fila['tipo_usuario']; ?></td>
        <td><?php echo $fila['Accion']; ?></td>
        <td><?php echo $fila['Fecha_Accion']; ?></td>
     </tr>
    <?php }
    } ?>
  </tbody>
</table>
</div>
</div>
<?php if(isset($_POST['submit_fechas'])){

  echo var_dump($_POST['fechaDeInicio']);
} ?>
<?php if(isset($_POST['submit_nombre'])){

  echo var_dump($_POST['NombreFiltro']);

} ?>

  <!-- Boton para ir atras-->
  <a href="../Homes/HomeLogeado.php" class="btn btn-primary">Atras</a>
  <!-- Inicio boton de informacion -->
  <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>
  <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          En esta pantalla usted puede consultar la informacion todas la reservas, subida de un excel.
          Ademas de la creacion, edicion o eliminacion de aulas, categorias y usuarios.

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Final boton de Informacion -->

<script type="text/javascript">
$('#fechaDeInicio').multiDatesPicker({
  maxPicks: 1,
  dateFormat: "dd/mm/yy"
})

$('#fechaDeFin').multiDatesPicker({
  maxPicks: 1,
  dateFormat: "dd/mm/yy"
})

</script>
<?php
}else{
  ?>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    </nav>
    <a href="../Homes/Home.php"><img src="../Images/Logo_UPB.png" class="img-fluid float-right" alt="Responsive image" ></a>
  </div>
  <?php
  echo "Por favor inicie sesion";
}
 ?>
 </body>

</html>
