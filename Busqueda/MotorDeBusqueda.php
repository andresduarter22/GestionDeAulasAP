<?php

session_start();
include "../Config/DataBase.php";
$faltaAula = $faltaAula = $faltaCantidadDeAlumnos = $faltaCategoria = "";

if (isset($_GET['err'])) {
    $faltafecha = "Datos incompletos, Por favor Ingrese de nuevo";
}

if (isset($_POST['startSearch'])) {

    if ($_POST['TipoDeBusqueda'] == 0) {
        if ($_POST['fechasEspecificas'] === "") {
            $faltafecha = "No fue Ingresada la fecha";
        }
    } else {
        if (($_POST['fechasSeguidasInicio'] === "") || ($_POST['fechasSeguidasFin'] === "")) {
            $faltafecha = "Una o mas fechas no fueron ingrsadas correctamente";
        }
    }

    if ($_POST['BuscaAulaEsp'] === 'on') {
        if (!isset($_POST['idDeAula'])) {
            $faltaAula = "No selecciono el aula específica";
        }
    } else {
        if (!isset($_POST['cat'])) {
            $faltaCategoria = "No eligio al menos una categoria";
        }
    }

    if ($_POST['requiereAlumnos'] === 'on') {
        echo $_POST['cantalumnos'];
        if (($_POST['cantalumnos'] === "")) {
            $faltaCantidadDeAlumnos = "No fue ingresada la cantidad de Alumnos";
        }
    }

    if (empty($faltafecha) && empty($faltaAula) && empty($faltaCategoria) && empty($faltaCantidadDeAlumnos)) {
        header("Location: Resultados.php");

    }

}

?>
<html>
<head>
    <!-- jQuery -->
    <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>
    <script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="jquery-ui.multidatespicker.js"></script>
    <script src="../Booststrap/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../Booststrap/js/bootstrap.min.js"></script>
    <link href="../Booststrap/bootstrap-toggle-master/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="jquery-ui.multidatespicker.css">
    <link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css">


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Búsqueda </title>
</head>
<body>
<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    </nav>
    <a href="../Homes/HomeLogeado.php" style="width: 300px"><img src="../Images/Logo_UPB.png"
                                                                 class="img-fluid float-right"
                                                                 alt="Responsive image"></a>
</div>
<?php
//Conexion con base
$db = new Database();
$dblink = $db->getConnection();
$sql = 'select * from Aulas order by nombre;';
$result = $dblink->query($sql);
$result->setFetchMode(PDO::FETCH_ASSOC);
?>
<form action="Resultados.php" method="post">
    <div class="container" style="width:1200px;">
        <?php if (isset($faltafecha)) { ?>
            <span class="error alert-danger"> <?php echo $faltafecha; ?></span>
        <?php } ?>

        <h5>Ingrese la(s) fecha(s) de su reserva</h5>
        <div class="col-sm-6">
            <label for="radio-1">Días Específicos</label>
            <input value="0" type="radio" name="TipoDeBusqueda" id="radio-1" required>
            <label for="radio-2">Días Seguidos</label>
            <input value="1" type="radio" name="TipoDeBusqueda" id="radio-2" required>
        </div>
        <a id="infoCalendarEspecificos">Elige cuantas fechas necesites</a><br>
        <a id="infoCalendarSeguidos">Elige solo 2 fechas</a><br>

        <input id="fechasEspecificas" autocomplete="off" name="fechasEspecificas" placeholder="Ingrese fechas">
        <input id="fechasSeguidasInicio" autocomplete="off" name="fechasSeguidasInicio" placeholder="Ingrese Inicio">
        <input id="fechasSeguidasFin" autocomplete="off" name="fechasSeguidasFin" placeholder="Ingrese Fin">

        <?php if (isset($faltafecha)) { ?>
            <span class="error alert-danger"> <?php echo $faltafecha; ?></span>
        <?php } ?>

        <br>
        <!--<input type="checkbox" name="BuscaAulaEsp">Es aula-->
        <input type="checkbox" name="BuscaAulaEsp"  data-toggle="toggle" onchange="show(this)" data-off="Categorías" data-on="Aula específica"
               data-onstyle="success" data-offstyle="info">
        <br/>
        <br/>

        <div class="row justify-content-around">
            <select class="form-control col-xs-3" name="idDeAula" style="width: 400px" id="pickDeAula">
                <option disabled selected value> -- Seleccione una aula especifica --</option>
                <?php while ($fila = $result->fetch()) { ?>
                    <option value=<?php echo $fila['id_Aulas']; ?>><?php echo $fila['nombre']; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($faltaAula)) { ?>
                <span class="error alert-danger"> <?php echo $faltaAula; ?></span>
            <?php } ?>
            <div class="scro">
                <table class=" table table-striped table-bordered  table-responsive-sm m-5 scrollbar "
                       id="pickDeCategoria">
                    <thead class="thead-dark">
                    <tr>
                        <th style="width: 30%"> Nombre de la Categoría</th>
                        <th style="width: 10%"> Check</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = 'select * from Categorias;';
                    $result = $dblink->query($sql);
                    while ($fila = $result->fetch()) { ?>
                        <tr>
                            <td>
                                <div class="tooltip"><?php echo $fila['nombre_categoria']; ?> <span
                                            class="tooltiptext"><?php echo $fila['descripcion']; ?></span></div>
                            </td>
                            <td><?php echo "<input  type=\"checkbox\" name=\"cat[]\" id=\"cat\" value=\"" . $fila['id_Categorias'] . "\" enabled>"; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if (isset($faltaCategoria)) { ?>
                <span class="error alert-danger"> <?php echo $faltaCategoria; ?></span>
            <?php } ?>
        </div>
        <br/>
        <br/>
        <h5>Cantidad de alumnos (Opcional)</h5>

        <div class="row justify-content-around">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input" name="requiereAlumnos">
                </div>
                <input type="number" min="0" max="100"
                       name="cantalumnos" n class="form-control" aria-label="Text input with checkbox" multiple
                       placeholder="Cantidad de Alumnos" style="width: 400px">
            </div>
            <?php if (isset($faltaCantidadDeAlumnos)) { ?>
                <span class="error alert-danger"> <?php echo $faltaCantidadDeAlumnos; ?></span>
            <?php } ?>
            <div class="input-group-text">
                Horario
                <div clkass="row-fluid">
                    <select class="selectpicker" id="horario" name="horario" data-live-search="true" required>
                        <option disabled selected value> --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" name="startSearch" value="Buscar">

    </div>
</form>
<!-- boton para ir atras-->

<?php
if (isset($_SESSION['idUsuario'])) {
    echo "<a href=\"../Homes/HomeLogeado.php\" class=\"btn btn-primary\">Atrás</a>";
} else {
    echo "<a href=\"../index.php\" class=\"btn btn-primary\">Atrás</a>";
}
?>

<!--<a href="../Homes/HomeLogeado.php" class="btn btn-primary">Atras</a> -->

<!--boton de informacion-->
<button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img
            src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image"
            height="42" width="42" data-target="info"/></button>
<div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Información</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                En esta pagina se ingresa se realiza consulta de disponibilidad de aulas: <br>
                Primero se elige el tipo de fecha, si desea ciertos dias especificos o todos los dias entre 2 fechas.
                <br>
                Luego el tipo de busqueda si busca la disponibilidad de un aula especifica, o la disponibilidad de aulas
                que cumplan ciertas categorias. <br>
                Opcionalmente se puede elegir la cantidad de alumnos minima que debe cumplir el aula. (Deber seleccionar el checkbox) <br>
                Finalmente se elige el horario


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>

    $('#fechasEspecificas').multiDatesPicker({
        //beforeShowDay: $.datepicker.noWeekends,
        minDate: 0
    }).hide();

    $('#pickDeAula').hide();


    $('#fechasSeguidasInicio').multiDatesPicker({
        maxPicks: 1,
        minDate: 0,
        beforeShowDay: $.datepicker.noWeekends
    }).hide();

    $('#fechasSeguidasFin').multiDatesPicker({
        maxPicks: 1,
        minDate: 1,
        beforeShowDay: $.datepicker.noWeekends
    }).hide();
    $('#infoCalendarEspecificos').hide();
    $('#infoCalendarSeguidos').hide();

    r=1;

    function show(e){
        console.log(r );
        if(r%2==0){
            $('#pickDeAula').hide();
            $('#pickDeCategoria').show();
        }else{
            $('#pickDeAula').show();
            $('#pickDeCategoria').hide();
        }
        r++;
    }

    $('input[name="TipoDeBusqueda"]').click(function (e) {
        if (e.target.value == 0) {
            $('#infoCalendarEspecificos').show();
            $('#infoCalendarSeguidos').hide();
            $('#fechasEspecificas').show();
            $('#fechasSeguidasInicio').hide();
            $('#fechasSeguidasFin').hide();
        } else {
            $('#infoCalendarSeguidos').show();
            $('#infoCalendarEspecificos').hide();
            $('#fechasEspecificas').hide();
            $('#fechasSeguidasInicio').show();
            $('#fechasSeguidasFin').show();
        }
    })
</script>
</body>
</html>
