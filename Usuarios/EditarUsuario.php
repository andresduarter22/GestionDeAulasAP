<?php
  if (!empty($_POST["submit"])) {
  //  echo "string <br>";
    actua();
  }
  function actua(){
    include_once "../Config/Database.php";
    $db= new Database();
    $dblink= $db->getConnection();
    $_categoriaUsuario= $_POST['Categoria'];
    $_nombre= $_POST['nombre'];
    $_interno= $_POST['numInt'];
    $_Email= $_POST['correo'];
    $_aulas= $_POST['aula'];
    $_categorias= $_POST['categoria'];
    $_idUsAEditar= $_POST['idUs'];
//    echo "$_categoriaUsuario";
    $sql = " UPDATE usuarios SET nombre = '$_nombre', num_interno ='$_interno', E_Mail= '$_Email', Rol=$_categoriaUsuario WHERE id_Usuario=$_idUsAEditar;";
  //  echo "$sql";
    if ($dblink->query($sql) === FALSE) {
      echo "Error en la modificacion de usuarios, uno o mas campos no fueron llenados " ;
    }
    $sql2 = "DELETE FROM usuarios_aulas WHERE id_DeUsuario= $_idUsAEditar  ";
    if ($dblink->query($sql2) === FALSE) {
      echo "Error: " . $sql2 . "<br>" . $dblink->error;
    }
    //revisa todas las categorias y saca la lista de los id de aulas
    foreach ($_categorias as  $value) {
      $sql2 = "DELETE FROM usuarios_categorias WHERE id_DeCategoria= $value AND id_DeUsuario= $_idUsAEditar";
      if ($dblink->query($sql2) === FALSE) {
        echo "Error: " . $sql2 . "<br>" . $dblink->error;
      }
      $sql2 = "INSERT INTO usuarios_categorias values(NULL,'$_idUsAEditar','$value')";
      if ($dblink->query($sql2) === FALSE) {
        echo "Error: " . $sql2 . "<br>" . $dblink->error;
      }
      $sql = "SELECT id_Aula FROM aulas_categoria where id_Categoria = '$value' " ;
      if ($dblink->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $dblink->error;
      }
      $result = $dblink->query($sql);
      $result->setFetchMode(PDO::FETCH_ASSOC);
      while ($fila = $result->fetch()){
      //  echo $fila['id_Aula'];
        $valorIDDeAula= $fila['id_Aula'];
        $sql2 = "INSERT INTO usuarios_aulas(idUsuarios_Aulas,id_DeAula,id_DeUsuario) values(NULL,'$valorIDDeAula','$_idUsAEditar')";
        if ($dblink->query($sql2) === FALSE) {
          echo "Error: " . $sql2 . "<br>" . $dblink->error;
        }
      }
    }
    foreach ($_aulas as  $value) {
  //    echo "$value";
      $sql = "INSERT INTO usuarios_aulas(idUsuarios_Aulas,id_DeAula,id_DeUsuario) values(NULL,'$value','$_idUsAEditar')";
      if ($dblink->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $dblink->error;
      }
    }
    $sql_log_edu = "INSERT INTO Logs (id_Log,nombre_usuario,num_interno_usuario,correo_usuario,tipo_usuario,Accion,Fecha_Accion) VALUES (NULL,'Andres','666','ad@gmail.com','m','Se edito un usuario llamado $_nombre',now())";
    $dblink->query($sql_log_edu);
  }
?>

<html>
<head>
  <!-- jQuery -->
  <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="../Booststrap/js/bootstrap.min.js" ></script>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Editar Usuarios</title>
</head>
<body>
  <button type="button" class="btn btn-danger">Cerrar sesión</button>
  <a href="GestionDeUsuarios.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right"  alt="Responsive image" ></a>
  <?php
    session_start();
    include_once "../Config/Database.php";
      $db= new Database();
    $dblink= $db->getConnection();
   if ($dblink->connect_error) {
     die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
           . $dblink->connect_error);
   }
     //Using GET
   $_idDeUsuario = $_GET['id'];
   $sql = "select * from Usuarios where id_Usuario= $_idDeUsuario ;";
   $result = $dblink->query($sql);
   $result->setFetchMode(PDO::FETCH_ASSOC);
?>
<form action="EditarUsuario.php?id= <?php echo $_idDeUsuario ?> " method="post">
  <div class="container" >
    <select class="custom-select"  name="Categoria">
      <option selected>Categoria de Usuario</option>
      <option value="1">Administrador</option>
      <option value="2">Actualizador</option>
      <option value="3">Reservador</option>
    </select>
    <?php   while ($fila = $result->fetch()){

      ?>
      <div class="form-group">
        <label for="NombreAula">Nombre:</label>
        <input type="text" value="<?php echo $fila['nombre'] ; ?>" class="form-control" id="usr" name="nombre">
      </div>
      <div class="form-group">
        <label for="num_interno">Numero de Interno:</label>
        <input type="text" value="<?php echo $fila['num_interno'];?>" class="form-control" id="interno"  name="numInt">
      </div>
      <div class="form-group">
        <label for"E_Mail">E-Mail:</label>
        <input type="text"value="<?php echo $fila['E_Mail']; ?>" class="form-control" id="e_mail" name="correo">
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
      <table   class="table table-striped table-bordered  table-responsive-sm m-5s">
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
          <?php } ?>
        </table>
      <?php }   ?>
    </div>

      <form action="EditarUsuario.php?id= <?php echo $_idDeUsuario ?> " method="post">
        <input type="submit" name="submit" value="Actualizar">
        <input type="hidden" name="idUs" value=<?php echo "$_idDeUsuario"; ?>>
      </form>


  </form>

  <a class="btn btn-primary" href="GestionDeUsuarios.php">Atras</a>
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



  <?php
  $dblink->close();
   ?>
</div >
</body>

</html>
