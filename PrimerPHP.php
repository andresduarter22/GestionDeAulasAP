<html lang="en">
<head>
    <link rel="stylesheet" href="custom.css">
    <meta charset="UTF-8">
    <title>Home</title>
    <center><img src="Logo_UPB.jpg"></center>
</head>
<body>
<button class="button">Iniciar sesión</button>
<div style="text-align: center;">
    Bienvenido al sistema de gestion de reserva de aulas
</div>

<?php for($i=1;$i<=5;$i++){ ?>
    <li>Menu Item <?php echo $i; ?></li>
<?php } ?>

</body>
</html>