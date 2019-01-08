<?php
/**
 * Created by PhpStorm.
 * User: luisfer
 * Date: 7/1/2019
 * Time: 23:18
 */

require_once 'ReadExcel.php';

$nombreTemp = $_REQUEST['exceltmp'];
$idUsuario = $_REQUEST['idUs'];


$readClass = new ReadExcel($nombreTemp, $idUsuario);
$readClass->cruzeConReservManuales();
$arreglsinRep = array_unique($readClass->getArregloReservasManualesAfectadas());

echo "Se enviaron correos a los usuarios Afectados ";

// the message
$msg = "Estimado usuario debido al cronograma del siguiente modulo su reserva que usted realizo sera borrada";
// use wordwrap() if lines are longer than 70 characters
$msg1 = wordwrap($msg, 70);
// send email
foreach ($arreglsinRep as $row) {
    echo $row[4];
    mail($row[4], "Prueba", $msg1);

}