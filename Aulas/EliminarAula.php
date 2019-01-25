<?php
  session_start();
  if (isset($_SESSION['idUsuario'])) {
  include_once "../Config/DataBase.php";
  $db= new Database();
  $dblink= $db->getConnection();
   $sql = "SELECT * FROM Aulas WHERE id_Aulas=".$_GET['id'];
   //echo var_dump($sql);
   $result = $dblink->query($sql);
    $fila = $result->fetch();
    $_nombre = $fila['nombre'];
   //echo $_SERVER['REQUEST_METHOD']
    $sql1= "DELETE FROM Aulas WHERE id_Aulas = ".$_GET['id'].";";
     //echo var_dump($sql1);
    $dblink->query($sql1);
    $idDeUsuario = $_SESSION['idUsuario'];
    $sql_validacion_loggeo = "SELECT * FROM Usuarios where id_Usuario=$idDeUsuario";
    $info_usuario = $dblink->query($sql_validacion_loggeo);
    $infoUs = $info_usuario->fetch();

    if ($infoUs['Rol'] == 0) {
        $rolDeUsuario = "Reservador";
    } else if ($infoUs['Rol'] == 1) {
        $rolDeUsuario = "Actualizador";
    } else {
        $rolDeUsuario = "Administrador";
    }
    $sql_log_ea = "INSERT INTO Logs (id_Log,nombre_usuario,num_interno_usuario,correo_usuario,tipo_usuario,Accion,Fecha_Accion) VALUES (NULL,'" . $infoUs['nombre'] . "','" . $infoUs['num_interno'] . "','" . $infoUs['E_Mail'] . "','" . $rolDeUsuario . "','Se elimino un aula llamada $_nombre',now())";
    $dblink->query($sql_log_ea);

   header("Location: GestionDeAulas.php");

   } else {
       echo "Por favor registrese Aqui";
       ?>
       <a  class="btn btn-dark" href="../index.php"> Home Page</a>
<?php
   }
   ?>
