<?php
/**
 * Created by PhpStorm.
 * User: luisfer
 * Date: 20/1/2019
 * Time: 23:07
 */

session_start();
unset($_SESSION['idUsuario']);
unset($_SESSION['tipoDeUsuario']);
unset($_SESSION['nombreDeUsuario']);

session_destroy();


echo $_SESSION['idUsuario'] ."User correctly Log Out";


