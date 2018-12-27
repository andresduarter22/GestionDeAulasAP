<?php
/**
 * Created by PhpStorm.
 * User: luisfer
 * Date: 22/12/2018
 * Time: 15:12
 */

$_idDeUsuario = 1;

require 'vendor/autoload.php';
include "ReadExcel.php";


use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (isset($_POST['Aulas'])) {
    //read( $_FILES['file']['tmp_name']);
    $readClass = new ReadExcel($_FILES['file']['tmp_name'], $_POST[id]);
    $readClass->import(1);
}

if (isset($_POST['Reserva'])) {
    //read( $_FILES['file']['tmp_name']);
    $readClass = new ReadExcel($_FILES['file']['tmp_name'], $_POST[id]);
    $readClass->checkIntegrity();
    $readClass->import(0);
}

function read($routa)
{
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
    $spread = $reader->load($routa);
    $sheet = $spread->getActiveSheet();
    foreach ($sheet->getRowIterator(6) as $row) {

        $mat = $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
        $ini = $sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getFormattedValue();
        $fin = $sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getFormattedValue();
        $horario = $sheet->getCellByColumnAndRow(4, $row->getRowIndex());
        $aula = $sheet->getCellByColumnAndRow(5, $row->getRowIndex());
        $docente = $sheet->getCellByColumnAndRow(8, $row->getRowIndex());
        if (!($mat[0] === 'T' && $mat[1] === 'o' && $mat[2] === 't' && $mat[3] === 'a')) {
               echo $mat . " "  . $ini . " " . $fin . " " .$horario . " " . $aula . " " .$docente . " " ."<br>";
        }
    }
}


?>

<html>
<head>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Upload Excel</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="Home.php">Log Out</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    </div>
    <a class="navbar-brand" href="../Usuarios/GestiondeUsuarios.php">Usuarios</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="../Categorias/GestionDeCategorias.php">Categorias</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="../Aulas/GestionDeAulas.php">Aulas</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <p class="lead">Ingrese el Nuevo documento xlsx </p>
        <div class="container">
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="file">
                <input type='hidden' name='id' value='<?php echo "$_idDeUsuario"; ?>'/>
                <input type="submit" name="Reserva" value="Reservas">
                <input type="submit" name="Aulas" value="Ingresar Aulas">

            </form>
        </div>
        <br><br><br>
        <!--      <a class="btn btn-primary btn-lg" href="HomeLogeado.php" role="button">Log </a>-->
    </div>
</div>


<a class="btn btn-primary" href="../Homes/HomeLogeado.php">Atras</a>

</body>
</html>

