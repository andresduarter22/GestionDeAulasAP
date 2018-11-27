<?php

/**
 * Clase para editar y borrar
 */

 include_once "../Config/Database.php";
$db= new Database();
$dblink= $db->getConnection();


$_idDeUsuario= $_GET['id'];
echo "$_idDeUsuario";
$sql = " DELETE FROM reservas WHERE id_Usuario_Reserva= $_idDeUsuario;";
//echo "$sql";
if ($dblink->query($sql) === FALSE) {
  echo "Error: " . $sql . "<br>" . $dblink->error;
}

$sql = " DELETE FROM usuarios_aulas WHERE  id_DeUsuario= $_idDeUsuario;";
//echo "$sql";
if ($dblink->query($sql) === FALSE) {
  echo "Error: " . $sql . "<br>" . $dblink->error;
}

$sql = " DELETE FROM usuarios_categorias WHERE  id_DeUsuario= $_idDeUsuario;";
//echo "$sql";
if ($dblink->query($sql) === FALSE) {
  echo "Error: " . $sql . "<br>" . $dblink->error;
}


$sql = " DELETE FROM usuarios  WHERE id_Usuario= $_idDeUsuario;";
//echo "$sql";
if ($dblink->query($sql) === FALSE) {
  echo "Error: " . $sql . "<br>" . $dblink->error;
}

//header("Location: GestionDeUsuarios.php");


?>
