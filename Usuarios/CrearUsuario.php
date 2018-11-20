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

      //Conexion con base
      include "../Config/Database.php";
  //    include_once "Actions.php";

      $db= new Database();
      $dblink= $db->getConnection();
    ?>
<form action="CrearUsuario.php" method="post">
  <div class="container" >
    <select class="custom-select" name="Categoria">
      <option selected>Categoria de Usuario</option>
      <option value="1">Administrador</option>
      <option value="2">Actualizador</option>
      <option value="3">Reservador</option>
    </select>
    <div class="form-group">
      <label for="NombreUsuario">Nombre:</label>
      <input type="text" class="form-control" id="usr" name="nombre">
    </div>
    <div class="form-group">
      <label for="num_interno">Numero de Interno:</label>
      <input type="text" class="form-control" id="interno" name="numInt">
    </div>
    <div class="form-group">
      <label for"E_Mail">E-Mail:</label>
      <input type="text" class="form-control" id="e_mail" name="correo">
    </div>
    <table class="table table-striped table-bordered  table-responsive-sm m-5s">
      <thead  class="thead-dark">
        <tr>
          <th style="width: 15%">Nombre de usuario </th>
          <th style="width: 15%">Check </th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sql = 'select * from aulas;';
          $result = $dblink->query($sql);
          while ($fila = $result->fetch()){
        ?>
        <tr>
          <td><?php echo $fila['nombre'] ?></td>
          <td><?php  echo "<input type=\"checkbox\" name=\"aula[]\" id=\"aula\" value=\" ".$fila['id_Aulas']." \" enabled>";?> </td>
        </tr>
        <?php } ?>
    </table>
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
          $result->setFetchMode(PDO::FETCH_ASSOC);
          while ($fila = $result->fetch()){
        ?>
      <tr>
        <td><?php echo $fila['nombre_categoria']  ?></td>
        <td><?php echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" value=\" ".$fila['id_Categorias']." \" enabled>";?></td>
      </tr>
        <?php }
        ?>
    </table>
  </div>

  <form action="CrearUsuario.php" method="post">
    <input type="submit" name="submit" value="submit">
  </form>

  </form>
  <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>

<?php
  if (isset($_POST['submit']))  {
     create();
   }
  function create(){
    $db= new Database();
    $dblink= $db->getConnection();
    $_categoriaUsuario= $_POST['Categoria'];
    $_nombre= $_POST['nombre'];
    $_interno= $_POST['numInt'];
    $_Email= $_POST['correo'];
    $_aulas= $_POST['aula'];
    $_categorias= $_POST['categoria'];

  $sql = "insert into Usuarios(id_Usuario,nombre,num_interno,E_Mail,Rol) values(NULL,'$_nombre','$_interno','$_Email','$_categoriaUsuario')";
  if ($dblink->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $dblink->error;
  }
  $_idUsuarioCreado=$dblink->lastInsertId();
  echo "hoal";

  //revisa todas las categorias y sca la lista de los id de aulas
  foreach ($_categorias as  $value) {
    $sql = "select id_Aula from aulas_categoria where id_Categoria = '$value' " ;
    if ($dblink->query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $dblink->error;
    }
    $result = $dblink->query($sql);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    while ($fila = $result->fetch()){
      echo $fila['id_Aula'];
      $valorIDDeAula= $fila['id_Aula'];
      $sql2 = "insert into usuarios_aulas(idUsuarios_Aulas,id_DeAula,id_DeUsuario) values(NULL,'$valorIDDeAula','$_idUsuarioCreado')";
      if ($dblink->query($sql2) === FALSE) {
        echo "Error: " . $sql2 . "<br>" . $dblink->error;
      }
    }
  }


  foreach ($_aulas as  $value) {
    $sql = "insert into usuarios_aulas(idUsuarios_Aulas,id_DeAula,id_DeUsuario) values(NULL,'$value','$_idUsuarioCreado')";
    if ($dblink->query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $dblink->error;
    }
  }

  }
?>





   <!-- jQuery -->
   <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="../Booststrap/js/bootstrap.min.js" ></script>
</body>

</html>
