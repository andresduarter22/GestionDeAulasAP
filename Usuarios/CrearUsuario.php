<html>
<head>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Crear Usuarios</title>
</head>
<body>
  <button type="button" class="btn btn-danger">Cerrar sesión</button>
    <a href="GestionDeUsuarios.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right"  alt="Responsive image" ></a>
  <?php
   $db_name = "bd_aulasperronas";
   $db_user = "root";
   $db_pass = "";
   $dblink = new mysqli('localhost', $db_user, $db_pass, $db_name);
   if ($dblink->connect_error) {
     die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
           . $dblink->connect_error);
   }

   $sql = "select * from usuario;";
   $result = $dblink->query($sql);
?>
<div class="container" >
 <select class="custom-select">
  <option selected>Categoria de Usuario</option>
  <option value="1">Administrador</option>
  <option value="2">Actualizador</option>
  <option value="3">Reservador</option>
 </select>
<div class="form-group">
  <label for="NombreAula">Nombre:</label>
  <input type="text" class="form-control" id="usr">
</div>
<div class="form-group">
  <label for="num_interno">Numero de Interno:</label>
  <input type="text" class="form-control" id="interno">
</div>
<div class="form-group">
  <label for"E_Mail">E-Mail:</label>
  <input type="text" class="form-control" id="e_mail">
</div>
</div>
<div class="container" >

<table class="table table-striped table-bordered  table-responsive-sm m-5s">
<thead  class="thead-dark">
  <tr>
    <th style="width: 15%">Nombre de usuario </th>
    <th style="width: 15%">Check </th>
  </tr>
</thead>
 <tbody>
  <?php
    $sql = "select * from aulas;";
    $result = $dblink->query($sql);
    while ($fila = $result->fetch_object()){  ?>
   <tr>
      <td><?php echo " $fila->nombre"; ?></td>
      <td><?php echo "<input type=\"checkbox\" class=\"form-check-input\" enabled>";?></td>
   </tr>
    <?php } ?>

    <table class="table table-striped table-bordered  table-responsive-sm m-5s">
    <thead  class="thead-dark">
      <tr>
        <th style="width: 15%">Nombre de usuario </th>
        <th style="width: 15%">Check </th>
      </tr>
    </thead>
     <tbody>
      <?php
        $sql = "select * from categorias;";
        $result = $dblink->query($sql);
        while ($fila = $result->fetch_object()){  ?>
       <tr>
            <td><?php echo " $fila->nombre_categoria"; ?></td>
          <td><?php echo "<input type=\"checkbox\" class=\"form-check-input\" enabled>";?></td>
       </tr>
        <?php } ?>
      </table>
</div>
  <button><a href="GestionDeUsuarios.php">Confirmar</a> </button>
  <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>



  <?php
   $dblink->close();
   ?>

   <!-- jQuery -->
   <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="../Booststrap/js/bootstrap.min.js" ></script>
</body>

</html>
