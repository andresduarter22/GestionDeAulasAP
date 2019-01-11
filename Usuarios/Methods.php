<?php

/**
 * Clase para editar y borrar
 */

include_once "../Config/DataBase.php";
$db= new Database();
$dblink= $db->getConnection();


$_idDeUsuario= $_GET['id'];
//echo "$_idDeUsuario";
$sql = "SELECT * FROM Reservas WHERE id_Usuario_Reserva= $_idDeUsuario AND  tipo = 0;";
$resultadoExist=$dblink->query($sql);
$resultadoExist->setFetchMode(PDO::FETCH_ASSOC);
$sqlLog = "SELECT * FROM Usuarios WHERE id_Usuario = ".$_GET['id'].";";
$result1 = $dblink->query($sqlLog);
echo var_dump($result1);
//$fila1->setFetchMode(PDO::FETCH_ASSOC);
$fila1 = $result1->fetch();
$borrado_u = $fila1['nombre'];
echo var_dump($borrado_u);

if($resultadoExist->rowCount()){
  echo "El usuario realizo reservas Automaticas en el sistema, elminarlo comprometera
        sus reservas y la integridad del sistema de informacion";
  header("Location: GestionDeUsuarios.php?err=true");
}else {
  $sql = " DELETE FROM Reservas WHERE id_Usuario_Reserva= $_idDeUsuario;";
  //echo "$sql";
  if ($dblink->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $dblink->error;
  }

  $sql = " DELETE FROM Usuarios  WHERE id_Usuario= $_idDeUsuario;";
  //echo "$sql";
  if ($dblink->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $dblink->error;
  }
  $sql_log_eu = "INSERT INTO Logs (id_Log,nombre_usuario,num_interno_usuario,correo_usuario,tipo_usuario,Accion,Fecha_Accion) VALUES (NULL,'Andres','666','ad@gmail.com','m','Se elimino un usuario llamado $borrado_u',now())";
  $dblink->query($sql_log_eu);
  echo "hi stranger";

  header("Location: GestiondeUsuarios.php?err=false");
}





?>
