<?php
session_start();
include_once "../Config/DataBase.php";
$db = new Database();
$dblink = $db->getConnection();

if (!empty($_POST["submit"])) {
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

    $IDUsuario =$_POST['idUs'];
    $sql = "SELECT * FROM Usuarios WHERE E_Mail= '$email' AND id_Usuario!= $IDUsuario ;";
    $result = $dblink->query($sql);

    if ($result->rowCount()) {
        $corrErr = "El correo ya existe en la base de datos ";
    }

    if (empty($corrErr) && empty($NombreErr)) {
        actua();
        echo '<script language="javascript">';
        echo 'alert("Usuario actualizado Correctamente")';
        echo '</script>';
    }
}
function actua()
{
    include_once "../Config/DataBase.php";
    $db = new Database();
    $dblink = $db->getConnection();
    $_categoriaUsuario = $_POST['CategUs'];
    $_nombre = $_POST['nombre'];
    $_interno = $_POST['numInt'];
    $_Email = $_POST['correo'];
    $_aulas = $_POST['aula'];
    $_categorias = $_POST['categoria'];
    $_idUsAEditar = $_POST['idUs'];
//    echo "$_categoriaUsuario";
    $sql = " UPDATE Usuarios SET nombre = '$_nombre', num_interno ='$_interno', E_Mail= '$_Email', Rol=$_categoriaUsuario WHERE id_Usuario=$_idUsAEditar;";
    //  echo "$sql";
    if ($dblink->query($sql) === FALSE) {
        echo "Error en la modificacion de usuarios, uno o mas campos no fueron llenados ";
    }

    $sql2 = "DELETE FROM Usuarios_Aulas WHERE id_DeUsuario= $_idUsAEditar  ";
    if ($dblink->query($sql2) === FALSE) {
        echo "Error: " . $sql2 . "<br>" . $dblink->error;
    }

    $sql2 = "DELETE FROM Usuarios_Categorias WHERE id_DeUsuario= $_idUsAEditar";
    if ($dblink->query($sql2) === FALSE) {
        echo "Error: " . $sql2 . "<br>" . $dblink->error;
    }

    //revisa todas las categorias y saca la lista de los id de aulas
    foreach ($_categorias as $value) {

        $sql2 = "INSERT INTO Usuarios_Categorias values(NULL,'$_idUsAEditar','$value')";
        if ($dblink->query($sql2) === FALSE) {
            echo "Error: " . $sql2 . "<br>" . $dblink->error;
        }


    }
    foreach ($_aulas as $value) {
        //    echo "$value";
        $sql = "INSERT INTO Usuarios_Aulas(idUsuarios_Aulas,id_DeAula,id_DeUsuario) values(NULL,'$value','$_idUsAEditar')";
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


    $sql_log_edu = "INSERT INTO Logs VALUES (NULL,'" . $infoUs['nombre'] . "','" . $infoUs['num_interno'] . "','" . $infoUs['E_Mail'] . "','" . $rolDeUsuario . "','Se edito un usuario llamado $_nombre',now())";
    $dblink->query($sql_log_edu);
}


if (isset($_SESSION['idUsuario'])) {
    ?>

    <html>
    <head>
        <!-- jQuery -->
        <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="../Booststrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../Booststrap/css/bootstrap.css">

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Editar Usuarios</title>
    </head>
    <body>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

      </nav>
    <a href="GestiondeUsuarios.php"><img src="../Images/Logo_UPB.png" class="img-fluid float-right"
                                         alt="Responsive image"></a>
    <?php
    include_once "../Config/DataBase.php";
    $db = new Database();
    $dblink = $db->getConnection();

    //Using GET
    $_idDeUsuario = $_GET['id'];
    $sql = "select * from Usuarios where id_Usuario= $_idDeUsuario ;";
    $result = $dblink->query($sql);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <form action="EditarUsuario.php?id= <?php echo $_idDeUsuario ?> " method="post">
        <div class="container">
            <?php while ($fila = $result->fetch()) { ?>

            <label for="Rol">Rol:</label><br>
            <select class="custom-select" name="CategUs" style="width: 300px" required>
                <option value="2" <?php if ($fila['Rol'] == 2) echo "selected"; ?>>Administrador</option>
                <option value="1" <?php if ($fila['Rol'] == 1) echo "selected"; ?>>Actualizador</option>
                <option value="0" <?php if ($fila['Rol'] == 0) echo "selected"; ?>>Reservador</option>
            </select>
            <div class="form-group" style="width: 300px">
                <label for="NombreAula">Nombre:</label>
                <input type="text" value="<?php echo $fila['nombre']; ?>" class="form-control" id="usr" name="nombre"
                       required>
                <span class="error alert-danger"> <?php echo $NombreErr; ?></span>
            </div>
            <div class="form-group" style="width: 300px">
                <label for="num_interno">Numero de Interno:</label>
                <input type="text" value="<?php echo $fila['num_interno']; ?>" class="form-control" id="interno"
                       name="numInt" required>
            </div>
            <div class="form-group" style="width: 300px">
                <label for"E_Mail">E-Mail:</label>
                <input type="text" value="<?php echo $fila['E_Mail']; ?>" class="form-control" id="e_mail" name="correo"
                       required>
                <span class="error alert-danger"> <?php echo $corrErr; ?></span>
            </div>

            <div class="row">
                <div class="scro">
                    <table class="table table-striped table-bordered  table-responsive-sm m-5s">
                        <thead class="thead-dark">
                        <tr>
                            <th style="width: 15%">Nombre de aula</th>
                            <th style="width: 15%">Check</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = 'SELECT * FROM Aulas ORDER BY nombre;';
                        $result = $dblink->query($sql);
                        while ($fila = $result->fetch()) {
                            ?>
                            <tr>
                                <td><?php echo $fila['nombre'] ?></td>
                                <td>
                                    <?php
                                    $idaula = $fila['id_Aulas'];
                                    $sql2 = "SELECT * FROM Usuarios_Aulas where id_DeAula= $idaula AND id_DeUsuario = $_idDeUsuario;";
                                    $resultado = $dblink->query($sql2);
                                    //  echo "$sql2";
                                    if ($resultado->fetch()) {
                                        echo "  <input type=\"checkbox\" name=\"aula[]\" id=\"aula\"checked=\"checked\" value=\" " . $fila['id_Aulas'] . " \" enabled>  ";
                                    } else {
                                        echo "   <input type=\"checkbox\" name=\"aula[]\" id=\"aula\" value=\" " . $fila['id_Aulas'] . " \" enabled>  ";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
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
                                <td>
                                    <?php
                                    $idcat = $fila['id_Categorias'];
                                    $sql2 = "SELECT * FROM Usuarios_Categorias WHERE id_DeCategoria= $idcat AND id_DeUsuario = $_idDeUsuario;";
                                    $resultado = $dblink->query($sql2);
                                    if ($resultado->fetch()) {
                                        echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" checked=\"checked\" value=\" " . $fila['id_Categorias'] . " \" enabled>";
                                    } else {
                                        echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" value=\" " . $fila['id_Categorias'] . " \" enabled>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <?php } ?>
                </div>
            </div>
            <br>
            <form action="EditarUsuario.php?id= <?php echo $_idDeUsuario ?> " method="post">
                <input type="submit" name="submit" value="Actualizar" class="btn btn-info">
                <input type="hidden" name="idUs" value=<?php echo "$_idDeUsuario"; ?>>
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
    </div >
    </body>

    </html>
    <?php
} else {
    echo "Por favor resgistrese";
    echo "<a  class=\"btn-dark\" href=\"../Homes/Home.php\"> Home Page</a>";
}
?>
