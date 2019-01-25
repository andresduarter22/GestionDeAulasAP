<?php
include "../Config/DataBase.php";
session_start();
$db = new Database();

//header("Refresh:200");
/*if($_err==true){
  echo "hubo un error";
  //echo "<div class= \"alert alert-danger \" role= \"alert \"> ";
  //echo "El usuario que intenta borrar realizo reservas Automaticas en el sistema, elminarlo comprometera
  //      sus reservas y la integridad de la informacion del sistema";
  //echo "</div>";
}else {

}*/


if (isset($_SESSION['idUsuario'])) {
?>

<html>
<head>
    <!-- jQuery -->
    <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../Booststrap/js/bootstrap.min.js"></script>
    <title>Gestión de Usuarios</title>

    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="GestiondeUsuarios.php">Usuarios</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="../Categorias/GestionDeCategorias.php">Categorías</a>
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

<a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.png" class="img-fluid float-right"
                                        alt="Responsive image"></a>
<?php
//Conexion con base
$dblink = $db->getConnection();
$sql = 'SELECT * FROM Usuarios;';
$result = $dblink->query($sql);
$result->setFetchMode(PDO::FETCH_ASSOC);
?>
<div class="container">
    <table class="table table-striped table-bordered  table-responsive-sm  scrollbar">
        <thead class="thead-dark">
        <tr>
            <th style="width: 15%">Nombre de usuario</th>
            <th style="width: 10%">Número de interno</th>
            <th style="width: 20%">E-Mail</th>
            <th style="width: 10%">Rol</th>
            <th style="width: 10%">Editar</th>
            <th style="width: 10%">Borrar</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($fila = $result->fetch()) { ?>
            <tr>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['num_interno']; ?></td>
                <td><?php echo $fila['E_Mail']; ?></td>
                <td><?php if ($fila['Rol'] == 0) {
                        echo "Reservador";
                    } elseif ($fila['Rol'] == 1) {
                        echo "Actualizador";
                    } else {
                        echo "Administrador";
                    }
                    ?></td>
                <td> <?php
                    $_idUs = $fila['id_Usuario'];
                    echo "<a href=\"EditarUsuario.php?id=$_idUs\" class=\"btn btn-primary\">Editar";
                    ?>
                </td>
                <td><?php echo "<button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\"data-target=\"#exampleModal" . $fila['id_Usuario'] . "\"> Borrar";
                    $idDEUSUARI = $_idUs;
                    ?></td>
            </tr>
            <div class="modal fade" id="exampleModal<?php echo $fila['id_Usuario']; ?>" ta bindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        ¿Está seguro que desea borrar el usuario, incluidas sus reservas y todo lo relacionado a este
                        usuario?
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-primary" href="Methods.php?id=<?php echo $fila['id_Usuario']; ?>"
                               value="Eliminar"> Confirmar</a>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </tbody>
    </table>
</div>
<a class="btn btn-primary" href="../Homes/HomeLogeado.php">Atrás</a>
<a href="CrearUsuario.php" class="btn btn-primary">Crear nuevo usuario</a>

<!-- Inicio boton de informacion -->
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
                    Esta es la pantalla donde se puede consultar toda la lista de Usuarios dentro de la base de Datos.

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
</body>

</html>
    <?php
} else {
    echo "Por favor resgistrese";
    echo "<a  class=\"btn-dark\" href=\"../index.php\"> Home Page</a>";
}
