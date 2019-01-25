<html>
<?php

include "../Config/DataBase.php";
include "search.php";
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works

session_start();
if (isset($_SESSION['idUsuario'])){
    $idDeUsuarioReservador = $_SESSION['idUsuario'];
    $tipoDeUsuario = $_SESSION['tipoDeUsuario'];
}else {
    $idDeUsuarioReservador = 1;
    $tipoDeUsuario = -1;
}

$db = new Database();
$dblink = $db->getConnection();
$idDeUsuarioReservador = 1;
$tipoDeUsuario = 1;

$se = new search();
$arregDisp = 0;

//echo isset($_POST['startSearch']);

if (isset($_POST['startSearch'])) {
    //echo "hola";
    $arregDisp = $se->busca();
}

//echo implode(",",$data);
//echo $data;

//$_resultadosDisp = $_GET['disp'];
//$_resultadosNoDisp = $_GET['nodisp'];


$_resultadosDisp = $arregDisp[0];
$_resultadosNoDisp = $arregDisp[1];
//  echo $_resultadosDisp;

?>

<head>
    <!-- jQuery -->
    <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../Booststrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Resultados de Búsqueda</title>
</head>
<body>
<div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    </div>
</nav>
<a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.png" class="img-fluid float-right" alt="Responsive image"></a>


<div class="jumbotron jumbotron-fluid">
    <div class="container ">
        <p class="display-5">Resultados De Búsqueda </p>
        <div class="container" style="width: 800px">
            <?php if (!empty($_resultadosDisp)) { ?>
                Aulas Diponibles
                <table class="table table-striped table-bordered  table-responsive-sm m-5s">
                    <thead class="thead-dark">
                    <tr>
                        <th style="width: 40%">Nombre de aula</th>
                        <th style="width: 30%">Reservar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for ($i = 0; $i < count($_resultadosDisp); $i++) {
                        //  echo "$valor";
                        $sql = "SELECT * FROM Aulas WHERE id_Aulas= $_resultadosDisp[$i]; ";
                        $result = $dblink->query($sql);
                        $infoAulas = $result->fetch();
                        $sql = "SELECT * FROM Usuarios_Aulas WHERE id_DeAula= $_resultadosDisp[$i] AND id_DeUsuario = $idDeUsuarioReservador ;";
                        $infoUsCatego = $dblink->query($sql);
                        //  echo "$sql";

                        $sql2 = "SELECT id_Categoria FROM Aulas_Categoria WHERE id_Aula= $_resultadosDisp[$i] ;";
                        //echo $sql2;
                        $arregloCategoriasDeAula = $dblink->query($sql2);
                        $userHaveCategory = false;
                        while ($row = $arregloCategoriasDeAula->fetch()) {
                            $sqlHaveCategoria = "SELECT * FROM Usuarios_Categorias WHERE id_DeCategoria= $row[0] AND id_DeUsuario = $idDeUsuarioReservador  ;";
                            $infoCategoriasDeAula = $dblink->query($sqlHaveCategoria);
                            if ($infoCategoriasDeAula->rowCount()) {
                                $userHaveCategory = true;
                            }
                        }

                        echo "<tr>";
                        //<input type=\"hidden\" name=\"id_AulasParaReservar\" value= " . $infoAulas[0] . " >
                        if (($infoUsCatego->rowCount() || $userHaveCategory ) && $tipoDeUsuario!=-1) {
                            $_SESSION["id_UsuarioQueReserva"] = $idDeUsuarioReservador;
                            $_SESSION["fechas"] = $se->_fechasArray;
                            $_SESSION["tipoDeReserva"] = $se->_tipoDeReserva;
                            $_SESSION["horario"] = $se->_horario;

                            $sql5 = "SELECT id_Categoria FROM Aulas_Categoria WHERE id_Aula =$_resultadosDisp[$i];";
                            $result5 = $dblink->query($sql5);

                            echo "<td class=\"table-success\">" . $infoAulas[1] . "<br> ";
                            //echo var_dump($result5) . $sql5;
                            while ($fila = $result5->fetch()) {
                                $sql6 = "SELECT nombre_categoria FROM Categorias WHERE id_Categorias= $fila[0]";
                                $result6 = $dblink->query($sql6);
                                $nombresCategorias = $result6->fetch();
                                echo $nombresCategorias[0] . "  ";
                            }

                            echo "  </td> ";
                            echo "<td class=\"table-success\">
                          <form method=\"POST\" action= \"ConfrimReserva.php\">

                            <input type='hidden' value='$infoAulas[0]' name='id_AulasParaReservar'>
                            <input type=\"submit\" value=\"Realizar Reserva\" class=\"btn btn-info\"/>
                          </form>
                         </td>";
                        } else {
                            $sql5 = "SELECT id_Categoria FROM Aulas_Categoria WHERE id_Aula =$_resultadosDisp[$i];";
                            $result5 = $dblink->query($sql5);

                            echo "<td class=\"table-danger\">" . $infoAulas[1] . "<br>";
                            while ($fila = $result5->fetch()) {
                                $sql6 = "SELECT nombre_categoria FROM Categorias WHERE id_Categorias= $fila[0]";
                                $result6 = $dblink->query($sql6);
                                $nombresCategorias = $result6->fetch();
                                echo $nombresCategorias[0] . "  ";
                            }

                            echo "</td> ";
                            echo "<td class=\"table-danger\">
                                <button type=\"button\" class=\"btn btn-info btn-lg\" data-toggle=\"modal\" data-target=\"#confirmModal" . $infoAulas[0] . " \">Informacion</button>

                                <!-- Modal Not your room-->
<div class=\"modal fade\" id=\"confirmModal" . $infoAulas[0] . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleMod  alLabel\"
     aria-hidden=\"true\">
    <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h4 class=\"modal-title\"> Lo sentimos</h4>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>
            <div class=\"modal-body\">";
                            $sql3 = "SELECT * FROM Usuarios_Aulas where id_DeAula= $infoAulas[0]";
                            $cantUsuarios = $dblink->query($sql3);
                            if ($cantUsuarios->rowCount() > 5) {
                                echo "Por Favor contacte con su jefe de carrera";
                            } else if ($cantUsuarios->rowCount() > 0) {
                                echo "Usuario(s) a contactar ";
                                foreach ($cantUsuarios as $fila) {
                                    $sql4 = "SELECT * FROM Usuarios WHERE id_Usuario= $fila[2]";
                                    $res4 = $dblink->query($sql4);
                                    $infoDeUsuario = $res4->fetch();
                                    echo "<li> " . $infoDeUsuario['nombre'] . " Interno: " . $infoDeUsuario['num_interno'] . " correo: " . $infoDeUsuario['E_Mail'] . "</li>";
                                }
                            } else {
                                echo "Por favor entre en contacto con Alexis";
                            }

                            echo "
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\" >Cerrar</button>
            </div>
        </div>
    </div>
</div>


                            </td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </table>
            <?php } else {
                echo "<span>El aula no se encuentra disponible</span>";
            }
            ?>
        </div>
        <?php if ($tipoDeUsuario >= 0 && !empty($_resultadosNoDisp)) { ?>
            Aulas no disponibles
            <div class="container scroMax">

                <table class="table table-striped table-bordered  table-responsive-sm m-5s">
                    <thead class="thead-dark">
                    <tr>
                        <th style="width: 40%">Nombre de aula</th>
                        <th style="width: 30%">Información</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for ($i = 0; $i < count($_resultadosNoDisp); $i++) {
                        echo "<tr>";

                        for ($j = 0; $j < count($_resultadosNoDisp[$i]); $j++) {
                            echo "<tr>";
                            $idReserv = $_resultadosNoDisp[$i][$j];

                            $sql = "SELECT * FROM Reservas WHERE id_Reservas =  $idReserv; ";
                            $result = $dblink->query($sql);
                            $infoReserva = $result->fetch();

                            $sql = "SELECT nombre FROM Aulas WHERE id_Aulas =  $infoReserva[1] ; ";
                            $result = $dblink->query($sql);
                            $q = $result->fetch();

                            if ($j == 0) {
                                echo "<td>" . $q[0] . "</td> ";
                            } else {
                                echo "<td> </td>";
                            }
                            $sql = "SELECT * FROM Usuarios WHERE id_Usuario =  $infoReserva[2] ; ";
                            $result = $dblink->query($sql);
                            $infoUsuario = $result->fetch();

                            $sql = "SELECT * FROM Materias WHERE id_Materias =  $infoReserva[3] ; ";
                            $result = $dblink->query($sql);
                            $infoMaterias = $result->fetch();
                            echo "<td>";
                            echo "--" . $infoUsuario[1] . " Interno:" . $infoUsuario[2] . "<br> Docente: " . $infoReserva[8] . "<br> Materia: " . $infoMaterias[1] . "<br> Fechas: Del " . $infoReserva[4] . " al " . $infoReserva[5] . "<br>";
                            echo "</td>";

                            echo "</tr>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        <?php } ?>

        <br><br><br>
    </div>
    <a class="btn btn-primary" href="MotorDeBusqueda.php">Atrás</a>
    <!--boton de informacion-->
    <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img
                src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image"
                height="42" width="42" data-target="info"/></button>

    <div class="modal fade" id="info" name="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Información</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    En esta pagina se pueden ver las aulas disponibles que cumplen los parametros requeridos.
                    El color verde muestra que se puede realizar la reserva.
                    El color rojo significa que este usuario no tiene el permiso para realizar la reserva.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
