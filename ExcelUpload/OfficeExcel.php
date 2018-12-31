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
    /*$readClass->checkIntegrity();
    $readClass->cruzeConReservManuales();
    $readClass->verificarReservaSeQuedaSinAula();
    $readClass->anytrouble();
    $readClass->deleteManualReserv();
    $readClass->import(0);*/
}


?>

<html>
<head>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Upload Excel</title>
</head>
<body>

<!-- jQuery -->
<script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="../Booststrap/js/bootstrap.min.js"></script>


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
                <input type="submit" class="btn-dark" data-target="#warningMod" data-toggle="modal" name="Reserva"
                       value="Reservas">
                <input type="submit" name="Aulas" value="Ingresar Aulas">
                <button class="btn-block" data-target="#warningMod" data-toggle="modal">ASDF</button>

            </form>
        </div>
        <br><br><br>
        <!--      <a class="btn btn-primary btn-lg" href="HomeLogeado.php" role="button">Log </a>-->
    </div>
    <button class="btn-block" data-target="#warningMod" data-toggle="modal">ASDF</button>
</div>

<a class="btn btn-primary" href="../Homes/HomeLogeado.php">Atras</a>
<!-- Modal de warning-->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="modal" id="warningMod">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"> Advertencias!!!!!!</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3>En esta pagina se ingresa el documento .xlsx para ingresar las materias que se realizan
                                en el semestre</h3>
                            Recordatorio: <br> El documeto debe contener unicamente una hoja con la lista de materias
                            del semestre
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Inicio boton de Informacion -->
<button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#infoA"><img
            src="../Images/iconoInfo.png" class="img-fluid float-right" alt="Responsive image" height="42" width="42"
            data-target="info"/></button>
<div class="modal fade" id="infoA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>En esta pagina se ingresa el documento .xlsx para ingresar las materias que se realizan en el
                    semestre</h3>
                Recordatorio: <br> El documeto debe contener unicamente una hoja con la lista de materias del semestre
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Final boton de Informacion -->

</body>
</html>

