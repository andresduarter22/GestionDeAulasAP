<?php
/**
 * Created by PhpStorm.
 * User: luisfer
 * Date: 7/1/2019
 * Time: 11:33
 */

require_once 'ReadExcel.php';

$nombreTemp = $_REQUEST['exceltmp'];
$idUsuario = $_REQUEST['idUs'];

//echo $nombreTemp;

if (isset($_POST['exceltmp'] )) {
    $myRead = new ReadExcel($nombreTemp, $idUsuario);
    echo $myRead->getCruzeConReservasManuales();
    $myRead->cruzeConReservManuales();
    $myRead->deleteManualReserv();
    $myRead->import(0);
    echo "Reservas subidas correctamente";
}
