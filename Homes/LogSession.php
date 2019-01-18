<?php
/**
 * Created by PhpStorm.
 * User: luisfer
 * Date: 16/1/2019
 * Time: 15:01
 */


session_start();
include "../Config/DataBase.php";

$correoDeUusario= $_REQUEST['correoUs'];


$db = new Database();
$dblink = $db->getConnection();

$sql= "SELECT * FROM Usuarios WHERE E_Mail='$correoDeUusario';";
$resultado= $dblink->query($sql);


$infoUs=$resultado->fetch();
echo var_dump($infoUs);

if($infoUs){
    $_SESSION['idUsuario']=$infoUs[0];
    $_SESSION['tipoDeUsuario']=$infoUs[4];
    $_SESSION['nombreDeUsuario']=$infoUs[1];

    echo "Bienvenido $infoUs[1]" ;
}else{
    echo "su usuario no se encuentra registrado en el sistema";

}


