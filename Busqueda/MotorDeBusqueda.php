<?php
include "../Config/DataBase.php";

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

    <title>Busqueda </title>
</head>
<body>
<div>
    <button type="button" class="btn btn-danger">Cerrar sesión</button>
   <a href="../Homes/HomeLogeado.php" style="width: 300px"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right"
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
        <div class="col-sm-6">
            <label for="radio-1">Días Específicos</label>
            <input value="0" type="radio" name="TipoDeBusqueda" id="radio-1" required>
            <label for="radio-2">Días Seguidos</label>
            <input value="1" type="radio" name="TipoDeBusqueda" id="radio-2" required>
        </div>
        <a id="infoCalendarEspecificos">Elige cuantas fechas necesites</a><br>
        <a id="infoCalendarSeguidos">Elige solo 2 fechas</a><br>

        <input id="fechasEspecificas" autocomplete="off" name="fechasEspecificas" placeholder="Ingrese fechas" >
        <input id="fechasSeguidasInicio" autocomplete="off" name="fechasSeguidasInicio" placeholder="Ingrese Inicio" >
        <input id="fechasSeguidasFin" autocomplete="off" name="fechasSeguidasFin" placeholder="Ingrese Fin" >
<br>
        <!--<input type="checkbox" name="BuscaAulaEsp">Es aula-->
        <input type="checkbox" name="BuscaAulaEsp" data-toggle="toggle" data-off="Categorias" data-on="Aula especifica"  data-onstyle="success" data-offstyle="info">
        <br/>
        <br/>

        <div class="row justify-content-around">
            <select class="form-control col-xs-3" name="idDeAula" style="width: 400px" id="pickDeAula">
                <option disabled selected value> -- Seleccione una aula especifica --</option>
                <?php while ($fila = $result->fetch()) { ?>
                    <option value=<?php echo $fila['id_Aulas']; ?>><?php echo $fila['nombre']; ?></option>
                <?php } ?>
            </select>

            <div class="scro">
                <table class=" table table-striped table-bordered  table-responsive-sm m-5 scrollbar " id="pickDeCategoria">
                    <thead class="thead-dark">
                    <tr>
                        <th style="width: 30%"> Nombre de la Categoria</th>
                        <th style="width: 10%"> Check</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = 'select * from Categorias;';
                    $result = $dblink->query($sql);
                    while ($fila = $result->fetch()) { ?>
                        <tr>
                            <td><div class="tooltip"><?php echo $fila['nombre_categoria']; ?> <span class="tooltiptext"><?php echo $fila['descripcion']; ?></span></div></td>
                            <td><?php echo "<input  type=\"checkbox\" name=\"cat[]\" id=\"cat\" value=\"" . $fila['id_Categorias'] . "\" enabled>"; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br/>
        <br/>

        <div class="row justify-content-around">
          <div class="input-group-prepend">
             <div class="input-group-text">
                <input type="checkbox" aria-label="Checkbox for following text input" name="requiereAlumnos">
              </div>
            <input type="number" min="0" max="100"
            name="cantalumnos" n class="form-control" aria-label="Text input with checkbox" multiple
            placeholder="Cantidad de Alumnos" style="width: 400px">
         </div>
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
                <option value="Z">Z</option>
                <option value="Z1">Z1</option>
              </select>
             </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" name="startSearch" value="Buscar">

    </div>
</form>
<!-- boton para ir atras-->

<a href="../Homes/HomeLogeado.php" class="btn btn-primary">Atras</a>

<!--boton de informacion-->
<button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img
            src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image"
            height="42" width="42" data-target="info"/></button>
            <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Esta es la pantalla donde se especifica la busqueda que se quiere realizar, primero escoja si quiere
                            dias en espeficico para luego seleccionar cada fecha en el calendario que se desplegara o si prefiere
                            varios dias seguidos donde se desplagaran dos campos donde tendra calendarios por separados y solo podra escoger una
                            fecha para cada campo, luego si busca algun aula en especifico escoga una de la lista (opcional), luego escoja
                            las caracteristicas que desea para su aula, como en que bloque o que piso, etc. Mientras mas caracteristicas elija,
                            mas especifica sera la busqueda, luego si desea puede introducio la cantidad de alumnos minima que requiere y finalemnte el horario
                            que quiere.

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



    $('input[name="idDeAula').click(function (e) {
        if (e.target.value > 0) {
            $('#pickDeAula').hide();
        }
    });


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
