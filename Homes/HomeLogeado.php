<?php
//    $_idDeUsuario = $_GET['id'];
$_idDeUsuario = 4;

/**
 * pedir tipo de usuario
 */
$_tipoDeUsuario = 2;
?>

<html>
<head>
    <!-- jQuery -->
    <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../Booststrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Home</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="Home.php">Log Out</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <?php
        if ($_tipoDeUsuario > 0) { ?>
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link" href="../ExcelUpload/OfficeExcel.php?id= <?php echo $_idDeUsuario ?>">Cargar
                        Archivo
                        <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        <?php } ?>
    </div>
    <?php if ($_tipoDeUsuario > 1) { ?>
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
    <?php } ?>

</nav>

<div class="jumbotron jumbotron-fluid">
    <img src="../Images/Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image">
    <div class="container">
        <h1 class="display-4">Bienvenido Usuario</h1>

        <br><br><br>
        <!--      <a class="btn btn-primary btn-lg" href="HomeLogeado.php" role="button">Log </a>-->
        <a class="btn btn-success" href="../Busqueda/MotorDeBusqueda.php" role="button">Realizar Reserva</a>
    </div>
</div>
<a class="btn btn-secondary" href="../Logs/Logs.php" role="button">Logs</a>


<!-- Inicio boton de informacion -->
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
                Esta es la pantalla donde se puede consultar toda la lista de Aulas dentro de la base de Datos

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
