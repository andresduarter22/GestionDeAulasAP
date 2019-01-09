<?php
include "../Config/Database.php";
session_start();
$db = new Database();
$dblink = $db->getConnection();

$id_DeAulaAReservar = $_POST["id_AulasParaReservar"];
$id_UsuarioQueReserva = $_SESSION['id_UsuarioQueReserva'];
$fechas = $_SESSION['fechas'];
$tipoDeReserva = $_SESSION['tipoDeReserva'];
$horario = $_SESSION['horario'];

$nombreDeMateria = $_POST['NombreMateria'];
$docente = $_POST['NombreDocente'];

//echo $id_DeAulaAReservar . $id_UsuarioQueReserva . implode(";",$fechas ). $tipoDeReserva . $horario ;


if (isset($_POST['confirmReservation'])) {
    $id_DeAulaAReservar = $_POST['idAReserv'];
    $sql = "SELECT * FROM materias WHERE nombre_materia LIKE '$nombreDeMateria' ;";
    //echo $sql;
    $result = $dblink->query($sql);
    $idDeMateria = 0;
    if ($result->rowCount()) {
        $infoMateria = $result->fetch();
        $idDeMateria = $infoMateria[0];
    } else {
        $sql = "INSERT INTO materias VALUES (NULL, '$nombreDeMateria'); ";
        $result = $dblink->query($sql);
        //$idDeMateria = $dblink->lastInsertId();
    }
    listaNombresMaterias();

    if ($tipoDeReserva == 1) {
        //seguidos
        $fechainicial = $fechas['fechaini'];
        $fechafinal = $fechas['fechafin'];
        $sql = "INSERT INTO reservas values (NULL, $id_DeAulaAReservar, $id_UsuarioQueReserva,$idDeMateria,'$fechainicial', '$fechafinal', 1, '$horario', '$docente' ) ;";
        $dblink->query($sql);

        $sql2 = "SELECT * FROM aulas WHERE id_Aulas=$id_DeAulaAReservar;";
        $result2 = $dblink->query($sql2);
        $infoAula = $result2->fetch();

        $sql3 = "SELECT * FROM materias WHERE nombre_materia LIKE '$nombreDeMateria' ;";
        $result3 = $dblink->query($sql3);
        $infoMateria = $result3->fetch();

        $sql_log_eu = "INSERT INTO Logs VALUES (NULL,'Andres','666','ad@gmail.com','m','Inserto una reserva en el aula  $infoAula[1] por la materia $infoMateria[1] De $fechainicial a $fechafinal en el horario $horario con el docente $docente ',now())";
        echo $sql_log_eu;
        $dblink->query($sql_log_eu);

    } else {
        for ($i = 0; $i < count($fechas); $i++) {
            $sql = "INSERT INTO reservas values (NULL, $id_DeAulaAReservar, $id_UsuarioQueReserva,$idDeMateria,'$fechas[$i]' ,'$fechas[$i]' , 1, '$horario', '$docente' ) ;";
            $dblink->query($sql);

            $sql3 = "SELECT * FROM aulas WHERE id_Aulas= $id_DeAulaAReservar ;";
            $result3 = $dblink->query($sql3);
            $infoAula = $result3->fetch();


            $sql_log_eu = "INSERT INTO Logs VALUES (NULL,'Andres','666','ad@gmail.com','m','Inserto una reserva en el aula  $infoAula[1] por la materia $infoMateria[1] el dia $fechas[$i]  en el horario $horario con el docente $docente ',now())";
            //echo $sql_log_eu;
            $dblink->query($sql_log_eu);
        }
    }


    //echo $sql . "<br>";
    //header("Location: MotorDeBusqueda");

}
$arrglodeMat = array();

function listaNombresMaterias()
{
    $db = new Database();
    $dblink = $db->getConnection();
    $sql = "SELECT nombre_materia FROM materias;";
    $result = $dblink->query($sql);
    $arrglodeMat = array();
    while ($fila = $result->fetch()) {
        array_push($arrglodeMat, $fila[0]);
    }
    return $arrglodeMat;
}

//echo implode(";",listaNombresMaterias());

?>

<html>
<head>
    <!-- jQuery -->
    <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../Booststrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Confirmacion de Reserva</title>
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
<div class="container">
    <form action="ConfrimReserva.php" method="post" autocomplete="off">
        <div class="form-group">
            <label for="exampleInputEmail1">Materia</label>
            <input type="text" name="NombreMateria" class="form-control" id="NombreMateria"
                   placeholder="Ingrese Materia" required>
            <small id="Materia Help" class="form-text text-muted">Ingrese el nombre de la materia a la cual se guardara
                la reserva
            </small>
        </div>
        <div class="form-group">
            <label>Nombre de Docente</label>
            <input class="form-control" name="NombreDocente" id="NombreDocente" placeholder="Nombre de docente"
                   required>
        </div>
        <input type="hidden" value="<?php echo $id_DeAulaAReservar ?>" name="idAReserv">

        <button type="submit" class="btn btn-primary" name="confirmReservation" value="submit">Submit</button>
    </form>
</div>

<!--  <a class="btn btn-primary" href="Resultados.php">Atras</a> -->
</body>
<script>
    function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function (e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*make the matching letters bold:*/
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function (e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = this.getElementsByTagName("input")[0].value;
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function (e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }

        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    /*An array containing all the country names in the world:*/
    var countries =<?php echo json_encode(listaNombresMaterias())?>
        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
        autocomplete(document.getElementById("NombreMateria"), countries);

</script>
</html>
