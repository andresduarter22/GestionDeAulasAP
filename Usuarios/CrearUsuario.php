<?php
session_start();
include "../Config/DataBase.php";
$corrErr = $NumintErr = $NombreErr = $CatErr = "";


//Conexion con base
// se crea una nueva instancia de la clase
$db = new Database();
// se llama a la conexion, caulquier cosa que se quiera hacer con la base se llama a esa variable
$dblink = $db->getConnection();

if (isset($_POST['creaUsuario'])) {

    $name = $_POST["nombre"];
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $NombreErr = "Solo letras y espacios requeridos";
    }

    $email = $_POST["correo"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $corrErr = "Formato de Correo invalido ";
    }
    if (!preg_match('/@gmail.com$/', $email)) {
        $corrErr = "El correo debe ser Gmail";
    }

    $sql = "SELECT * FROM Usuarios WHERE E_Mail= '$email'";
    $result=$dblink->query($sql);

    if($result->rowCount()){
        $corrErr = "El correo ya existe en la base de datos ";
    }

    if (empty($corrErr) && empty($NombreErr)) {
        create();
        echo '<script language="javascript">';
        echo 'alert("Usuario Correctamente agregado")';
        echo '</script>';
    }
}


if (isset($_SESSION['idUsuario'])) {
    ?>

    <html xmlns:overflow="http://www.w3.org/1999/xhtml">
    <head>
        <!-- jQuery -->
        <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="../Booststrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../Booststrap/css/bootstrap.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Crear Usuarios</title>
    </head>
    <body>
    <a href="GestiondeUsuarios.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right"
                                         alt="Responsive image"></a>

    <form action="CrearUsuario.php" method="post">
        <div class="container">
            <label for="Rol">Rol:</label><br>
            <select class="custom-select" name="Categoria" style="width: 300px" required>
                <option disabled selected value> -- Seleccione una Categoria --</option>
                <option value="2">Administrador</option>
                <option value="1">Actualizador</option>
                <option value="0">Reservador</option>
            </select>
            <span class="error"> <?php echo $CatErr; ?></span>
            <div class="form-group" style="width: 300px">
                <label for="NombreUsuario">Nombre:</label>
                <input type="text" class="form-control" id="usr" name="nombre" required>
                <span class="error alert-danger"> <?php echo $NombreErr; ?></span>
            </div>
            <div class="form-group" style="width: 300px">
                <label for="num_interno">Numero de Interno:</label>
                <input type="number" class="form-control" id="interno" name="numInt" required>
                <span class="error alert-danger"> <?php echo $NumintErr; ?></span>
            </div>

            <div class="form-group" style="width: 300px">
                <label for"E_Mail">E-Mail:</label>
                <input type="text" class="form-control" id="e_mail" name="correo" required>
                <span class="error alert-danger"> <?php echo $corrErr; ?></span>
            </div>

            <div class="row">
                <div class="scro">
                    <table class="table table-fixed table-striped table-bordered  table-responsive-sm m-5s ">
                        <thead class="thead-dark">
                        <tr>
                            <th style="width: 15%">Nombre de aula</th>
                            <th style="width: 15%">Check</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // se crea el query
                        $sql = 'SELECT * FROM Aulas ORDER BY  nombre;';
                        //  $result tiene el resultado de la busqueda
                        $result = $dblink->query($sql);
                        while ($fila = $result->fetch()) {
                            ?>
                            <tr>
                                <td><?php echo $fila['nombre'] ?></td>
                                <td><?php echo "<input type=\"checkbox\" name=\"aula[]\" id=\"aula\" value=\" " . $fila['id_Aulas'] . " \" enabled>"; ?> </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <br>
                <hr>
                <div class="scro">
                    <table class="table table-striped table-bordered  table-responsive-sm m-5s">
                        <thead class="thead-dark">
                        <tr>
                            <th style="width: 15%">Nombre de categoria</th>
                            <th style="width: 15%">Check</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM Categorias;";
                        $result = $dblink->query($sql);
                        while ($fila = $result->fetch()) {
                            ?>
                            <tr>
                                <td><?php echo $fila['nombre_categoria'] ?></td>
                                <td><?php echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" value=\" " . $fila['id_Categorias'] . " \" enabled>"; ?></td>
                            </tr>
                        <?php }
                        ?>
                    </table>
                </div>
            </div>
            <br>
            <form action="CrearUsuario.php" method="post">
                <input type="submit" name="creaUsuario" value="Crear Usuario" class="btn btn-info">
            </form>
        </div>

    </form>
    <a class="btn btn-primary" href="GestiondeUsuarios.php">Atras</a>
    <!-- Inicio boton de informacion -->
    <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img
                src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image"
                height="42" width="42" data-target="info"/></button>
    <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Esta es la pantalla donde se puede consultar toda la lista de Aulas dentro de la base de Datos

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    </body>

    </html>

    <?php
} else {
    echo "Por favor resgistrese";
    echo "<a  class=\"btn-dark\" href=\"../Homes/Home.php\"> Home Page</a>";
}

function create()
{
    $db = new Database();
    $dblink = $db->getConnection();
    $_categoriaUsuario = $_POST['Categoria'];
    $_nombre = $_POST['nombre'];
    $_interno = $_POST['numInt'];
    $_Email = $_POST['correo'];
    $_aulas = $_POST['aula'];
    $_categorias = $_POST['categoria'];

    $sql = "INSERT INTO Usuarios VALUES (NULL,'$_nombre','$_interno','$_Email','$_categoriaUsuario')";
    if ($dblink->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $dblink->error;
    }
    $_idUsuarioCreado = $dblink->lastInsertId();

    //revisa todas las categorias y saca la lista de los id de aulas
    foreach ($_categorias as $value) {
        $sql2 = "INSERT INTO Usuarios_Categorias VALUES (NULL,'$_idUsuarioCreado','$value')";
        if ($dblink->query($sql2) === FALSE) {
            echo "Error: " . $sql2 . "<br>" . $dblink->error;
        }

    }

    foreach ($_aulas as $value) {
        $sql = "INSERT INTO Usuarios_Aulas VALUES (NULL,'$value','$_idUsuarioCreado')";
        if ($dblink->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $dblink->error;
        }
    }

    $idDeUsuario = $_SESSION['idUsuario'];
    $sql4 = "SELECT * FROM Usuarios where id_Usuario=$idDeUsuario";
    $resultado1 = $dblink->query($sql4);
    $infoUs = $resultado1->fetch();

    if ($infoUs['Rol'] == 0) {
        $rolDeUsuario = "Reservador";
    } else if ($infoUs['Rol'] == 1) {
        $rolDeUsuario = "Actualizador";
    } else {
        $rolDeUsuario = "Administrador";
    }


    $sql_log_cu = "INSERT INTO Logs VALUES (NULL,'" . $infoUs['nombre'] . "','" . $infoUs['num_interno'] . "','" . $infoUs['E_Mail'] . "','" . $rolDeUsuario . "','Se creo un usuario llamado $_nombre',now())";
    $dblink->query($sql_log_cu);
}


?>
