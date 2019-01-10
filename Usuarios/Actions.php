
<?php
  include "../Config/DataBase.php";


  $db= new Database();
  $dblink= $db->getConnection();
  if (isset($_POST['submit']))  {
     create();
   }
  function create(){
    $db_name = "bd_aulasperronas";
    $db_user = "root";
    $db_pass = "";
    $dblink = new mysqli('localhost', $db_user, $db_pass, $db_name);
    if ($dblink->connect_error) {
      die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '. $dblink->connect_error);
    }
    $_categoria= $_POST['Categoria'];
    $_nombre= $_POST['nombre'];
    $_interno= $_POST['numInt'];
    $_Email= $_POST['correo'];
    $_aulas= $_POST['check_list'];
    echo "$_nombre $_interno $_Email $_categoria";
    echo "$_aulas";

    $sql = "insert into Usuarios(id_Usuario,nombre,num_interno,E_Mail,Rol) values(NULL,'$_nombre','$_interno','$_Email','$_categoria')";
    if ($dblink->query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $dblink->error;
    }
  }
 ?>
