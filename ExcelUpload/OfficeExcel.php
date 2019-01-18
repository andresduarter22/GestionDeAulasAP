<?php
session_start();

/**
 * Created by PhpStorm.
 * User: luisfer
 * Date: 22/12/2018
 * Time: 15:12
 */


if (isset($_SESSION['idUsuario'])) {


$_idDeUsuario = $_SESSION['idUsuario'];

require 'vendor/autoload.php';
include "ReadExcel.php";


?>
<html>
<!-- jQuery -->
<script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="../Booststrap/js/bootstrap.min.js"></script>


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
</nav>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <p class="lead">Ingrese el Nuevo documento xlsx </p>
        <div class="container">
            <form method="post" enctype="multipart/form-data" id="excelup">
                <input type="file" name="file">
                <input type='hidden' name='id' value='<?php echo "$_idDeUsuario"; ?>'/>
                <!--<input type="submit" class="btn-dark" data-target="#warningModal" data-toggle="modal" name="Reserva"  value="Reservas"> -->
                <button class="btn-dark" type="submit" name="Reserva" value="submit">Reservas</button>
                <input type="submit" name="Aulas" value="Ingresar Aulas">
            </form>
        </div>
        <span>Una vez subido el documento esperar hasta que la alerta de confirmacion aparezca </span>
        <br><br><br>
        <!--      <a class="btn btn-primary btn-lg" href="HomeLogeado.php" role="button">Log </a>-->
    </div>
</div>

<a class="btn btn-primary" href="../Homes/HomeLogeado.php">Atras</a>


</body>


<!-- Inicio boton de Informacion -->
<button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#infoA"><img
            src="../Images/iconoInfo.png" class="img-fluid float-right" alt="Responsive image" height="42" width="42"
            data-target="info"/></button>
<div class="modal fade" id="infoA" tabindex="-1" role="dialog" aria-labelledby="exampleMod  alLabel" aria-hidden="true">
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

<?php
if (isset($_POST['Aulas'])) {
    $uploadDir = "../Uploads/";
    move_uploaded_file($_FILES["file"]["tmp_name"], $uploadDir . $_FILES['file']['name']);
    $dirExcel = "../Uploads/" . $_FILES['file']['name'];

    $readClass = new ReadExcel($dirExcel, $_POST['id']);

    $readClass->import(1);
}

if (isset($_POST['Reserva'])) {


$uploadDir = "../Uploads/";
move_uploaded_file($_FILES["file"]["tmp_name"], $uploadDir . $_FILES['file']['name']);
$dirExcel = "../Uploads/" . $_FILES['file']['name'];

$readClass = new ReadExcel($dirExcel, $_POST['id']);
$readClass->checkIntegrity();
$readClass->cruzeConReservManuales();
$readClass->verificarReservaSeQuedaSinAula();
$GLOBALS['trouble'] = $readClass->anytrouble();


//echo $readClass->IntegridadDeExcel . $readClass->cruzeConReservasManuales . $readClass->materiasQuePerdieronAula;
?>

<!-- Modal de Confirmacion-->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleMod  alLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Confirmacion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Esta seguro de subir el documento
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="subirRes();">Enviar y
                    Cerrar
                </button>
                <!-- <button type="button" class="btn btn-success" data-dismiss="modal" id="UploadEx">Enviar y Cerrar -->
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de warning-->
<div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="exampleMod  alLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Se encontraron errores en el documento Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    if ($readClass->getIntegridadDeExcel()) {
                        echo "Respecto al contenido del excel <br>";
                        if ($readClass->getDatosIncompletos()) {
                            echo "Existen entradas en el documento con datos incompletos en la(s) fila(s)<br>";
                            foreach ($readClass->getArregloDeIntegridad() as $row) {
                                if ($row[1] == 0) {
                                    echo "$row[0] ";
                                }
                            }
                            echo "<br>";
                        }
                        if ($readClass->getAulaInexistentete()) {
                            echo "Se quiere ingresar un aula que no existe, por lo tanto no se realizara la reserva en la(s) fila(s)<br>";
                            foreach ($readClass->getArregloDeIntegridad() as $row) {
                                if ($row[1] == 1) {
                                    echo $row[0] . " ";
                                }
                            }
                            echo "<br>";
                        }
                    }
                    if ($readClass->getCruzeConReservasManuales()) {
                        echo "Respecto al cruce con reservas manuales:<br>";
                        echo "Las sigientes reservas seran borradas <br>";
                        $arreglsinRep = array_unique($readClass->getArregloReservasManualesAfectadas());
                        echo "<ul >";

                        foreach ($arreglsinRep as $row) {
                            echo "<li> " . $row[2] . " con el docente $row[3] en el aula $row[1] realizado por: " . $row[0] . " </li>";
                            //echo implode(" | ", $row) . "<br>";
                        }
                        echo "</ul>";
                    }
                    if ($readClass->getMateriasQuePerdieronAula()) {
                        echo "Respecto a materias que perdieron su aula<br>";
                        echo "<ul >";
                        foreach ($readClass->getArregloMateriasSinAula() as $row) {
                            $fechaArray = explode("-", $row[2]);
                            $fechaOrdenada = $fechaArray[2] . "-" . $fechaArray[1] . "-" . $fechaArray[0];
                            echo "<li> Materia: $row[0] en el horario $row[3] que inicia en la fecha $fechaOrdenada con el docente $row[1]   </li>";
                            //echo implode("|", $row) . "<br>";
                        }
                        echo "</ul>";
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <?php
                    if ($readClass->getCruzeConReservasManuales()) {
                        echo " <button type=\"button\" class=\"btn btn-dark\" id='sendEmail' onclick='sendEmail()'>Enviar correo a usuarios afectados</button> ";
                    }
                    ?>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirmModal"
                            data-dismiss="modal">Continuar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php if ($trouble) {
        echo "<script> window.onload =  $('#warningModal').modal('show'); </script>";
    } else {
        echo "<script> window.onload =  $('#confirmModal').modal('show'); </script>";
    }


    }

    ?>

    <script type="text/javascript">

        function sendEmail() {
            var exceldoc = "<?php echo $dirExcel; ?>";
            var idUs = "<?php echo $_POST['id']; ?>";
            console.log(exceldoc);
            $.ajax({
                type: "POST",
                data: {
                    "exceltmp": exceldoc,
                    "idUs": idUs
                },
                url: "SendMailHandler.php",
                datatype: "html",
                success: function (res) {
                    alert(res);
                }
            });
        }

        function subirRes() {
            var exceldoc = "<?php echo $dirExcel; ?>";
            var idUs = "<?php echo $_POST['id']; ?>";
            console.log(exceldoc);
            $.ajax({
                type: "POST",
                data: {
                    "exceltmp": exceldoc,
                    "idUs": idUs
                },
                url: "ExcelHandler.php",
                datatype: "html",
                success: function (res) {
                    alert(res);
                }
            });
        }


    </script>
    <?php
    function sendE()
    {
        $readClass = new ReadExcel($_FILES['file']['tmp_name'], $_POST[id]);
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
    }
    } else {
        echo "Por favor resgistrese";
        echo "<a  class=\"btn-dark\" href=\"../Homes/Home.php\"> Home Page</a>";
    }
    ?>
</html>
