<?php
$_IDUsuarioTemporal = 3;
?>

<html>
<head>
    <!-- jQuery -->
    <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../Booststrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <!--Google    -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id"
          content="722692492660-jdifs59bsljp70543hctlv1q0mkjem0u.apps.googleusercontent.com">

    <title>Home</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="HomeLogeado.php?id=<?php echo $_IDUsuarioTemporal; ?> ">Log In</a>


    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

</nav>

<div class="jumbotron jumbotron-fluid">
    <img src="../Images/Logo_UPB.png" class="img-fluid float-right" alt="Responsive image">
    <div class="container">
        <h1 class="display-4">Bienvenido al Sistema de Reservas UPB La Paz</h1>
        <div class="container">
            <br>
            <a class="btn btn-success" href="../Busqueda/MotorDeBusqueda.php" role="button">Realizar Consulta</a>

            <!--      <a class="btn btn-primary btn-lg" href="HomeLogeado.php" role="button">Log </a>
                  <a class="btn btn-success" href="HomeLogeado.php" role="button">Consultar Reserva</a> -->
        </div>
    </div>
    <!-- Inicio boton de informacion -->
    <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img
                src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image"
                height="42" width="42" data-target="info"/></button>
    <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bienvenido al sistema de reserva de aulas UPB La Paz, en esta pagina puede iniciar sesion como
                    usuario o
                    realizar una consulta sobre la disponibilidad de un aula.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Final boton de Informacion -->

    <!-- Log In GOOGLE-->
    <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
    <script>
        function onSignIn(googleUser) {
            // Useful data for your client-side scripts:
            var profile = googleUser.getBasicProfile();
            console.log("ID: " + profile.getId()); // Don't send this directly to your server!
            console.log("Email: " + profile.getEmail());

            // The ID token you need to pass to your backend:
            var id_token = googleUser.getAuthResponse().id_token;
            console.log("ID Token: " + id_token);
            //como ya se encuentra logeado, redirige una y otra vez a home logeado
            //window.location.replace("http://skynet.lp.upb.edu/~aduarte16/GestionDeAulasAP/Homes/HomeLogeado.php");

            var email =profile.getEmail();
            $.ajax({
                type: "POST",
                data: {
                    "correoUs": email
                },
                url: "LogSession.php",
                datatype: "html",
                success: function (res) {
                    alert("Bienvenido Usuario");
                }
            });
        }
    </script>


</body>

</html>
