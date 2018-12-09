<?php

/**
 * Clase para editar y borrar
 */

include_once "../Config/Database.php";
$db= new Database();
$dblink= $db->getConnection();


$_idDeUsuario= $_GET['id'];
//echo "$_idDeUsuario";
$sql = "SELECT * FROM reservas WHERE id_Usuario_Reserva= $_idDeUsuario AND  tipo = 0;";
$resultadoExist=$dblink->query($sql);
$resultadoExist->setFetchMode(PDO::FETCH_ASSOC);
if($resultadoExist->rowCount()){
  echo "El usuario realizo reservas Automaticas en el sistema, elminarlo comprometera
        sus reservas y la integridad del sistema de informacion";
  header("Location: GestionDeUsuarios.php?err=true");
}else {
  $sql = " DELETE FROM reservas WHERE id_Usuario_Reserva= $_idDeUsuario;";
  //echo "$sql";
  if ($dblink->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $dblink->error;
  }

  $sql = " DELETE FROM usuarios  WHERE id_Usuario= $_idDeUsuario;";
  //echo "$sql";
  if ($dblink->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $dblink->error;
  }
  echo "hi stranger";

  header("Location: GestionDeUsuarios.php?err=false");
}





?>
