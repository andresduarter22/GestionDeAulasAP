<html>
<head>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Editar Usuarios</title>
</head>
<body>
  <button type="button" class="btn btn-danger">Cerrar sesión</button>
  <a href="GestionDeUsuarios.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right"  alt="Responsive image" ></a>
  <?php
    session_start();
    include "../Config/Database.php";
    session_start();
    $db= new Database();
    $dblink= $db->getConnection();
   if ($dblink->connect_error) {
     die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
           . $dblink->connect_error);
   }
   $var_value = $_SESSION['id'];
  // echo "$var_value";
   //Using GET
   $_idDeUsuario = $_GET['id'];
   $sql = "select * from Usuarios where id_Usuario= $_idDeUsuario ;";
   $result = $dblink->query($sql);
   $result->setFetchMode(PDO::FETCH_ASSOC);
?>
<!--
<div class="custom-control custom-checkbox">
  <input type="checkbox" class="custom-control-input" id="customCheck1">
  <label class="custom-control-label" for="customCheck1">Administrador</label>
  <input type="checkbox" class="custom-control-input" id="customCheck2">
  <label class="custom-control-label" for="customCheck1">Actualizador</label>
  <input type="checkbox" class="custom-control-input" id="customCheck3">
  <label class="custom-control-label" for="customCheck1">Administrador</label>
</div>
-->
<div class="container" >
<select class="custom-select" value=1>
  <option selected>Categoria de Usuario</option>
  <option value="1">Administrador</option>
  <option value="2">Actualizador</option>
  <option value="3">Reservador</option>
</select>

<?php   while ($fila = $result->fetch()){  ?>
<div class="form-group">
  <label for="NombreAula">Nombre:</label>
  <input type="text" value= <?php echo   $fila['nombre'] ; ?> class="form-control" id="usr">
</div>
<div class="form-group">
  <label for="num_interno">Numero de Interno:</label>
  <input type="text" value= <?php echo   $fila['num_interno']; ?> class="form-control" id="interno">
</div>
<div class="form-group">
  <label for"E_Mail">E-Mail:</label>
  <input type="text"value= <?php echo   $fila['E_Mail']; ?>  class="form-control" id="e_mail">
</div>

<table class="table table-striped table-bordered  table-responsive-sm m-5s">
  <thead  class="thead-dark">
    <tr>
      <th style="width: 15%">Nombre de aula</th>
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
      <td>
      <?php
        $idaula=$fila['id_Aulas'];
        $sql2 = "SELECT * from usuarios_aulas where id_DeAula= $idaula AND id_DeUsuario = $_idDeUsuario;";
        $resultado = $dblink->query($sql2);
      //  echo "$sql2";
      if ($resultado->fetch()) {
      echo "  <input type=\"checkbox\" name=\"aula[]\" id=\"aula\"checked=\"checked\" value=\" ".$fila['id_Aulas']." \" enabled>  ";
    }else {
      echo "   <input type=\"checkbox\" name=\"aula[]\" id=\"aula\" value=\" ".$fila['id_Aulas']." \" enabled>  ";
    }
       ?>
       </td>
    </tr>
    <?php } ?>
</table>
<table class="table table-striped table-bordered  table-responsive-sm m-5s">
  <thead  class="thead-dark">
    <tr>
      <th style="width: 15%">Nombre de categoria </th>
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
    <td>
      <?php
        $idcat=$fila['id_Categorias'];
        $sql2 = "SELECT * from usuarios_categorias where id_DeCategoria= $idcat AND id_DeUsuario = $_idDeUsuario;";
        $resultado = $dblink->query($sql2);
        if ($resultado->fetch()) {
        echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" checked=\"checked\" value=\" ".$fila['id_Categorias']." \" enabled>";
      }else {
        echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" value=\" ".$fila['id_Categorias']." \" enabled>";
      }
      ?>
    </td>
  </tr>
    <?php }
    ?>
</table>
<?php }?>

  <button><a href="GestionDeUsuarios.php">Confirmar</a>  </button>
  <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>

  <?php
   $dblink->close();
   ?>
</div >
   <!-- jQuery -->
   <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

   <!-- Bootstrap JS -->
   <script src="../Booststrap/js/bootstrap.min.js" ></script>
</body>

</html>
