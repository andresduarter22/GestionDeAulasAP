<?php
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
    $sql_log_ea = "INSERT INTO Logs (id_Log,nombre_usuario,num_interno_usuario,correo_usuario,tipo_usuario,Accion,Fecha_Accion) VALUES (NULL,'Andres','666','ad@gmail.com','m','Se elimino un aula llamada $_nombre',now())";
    $dblink->query($sql_log_ea);

   header("Location: GestionDeAulas.php");
   //$dblink->close();
   ?>
