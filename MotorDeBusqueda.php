<html>
<head>
<link href="Style.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
  <body>
    <form>
      <div class="container">
        <input type="checkbox" enabled>Dias Especificos</input>
        <input type="checkbox" enabled>Dias Seguidos</input>
      </div>
    </form>
    <button type="button" class="btn btn-danger">Cerrar sesión</button>
    <form>

      <?php
      include 'FuncionCalendario.php';

      $calendar = new Calendar();

      echo $calendar->show();
      ?>
    </form>


<!-- jQuery -->
<script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="../Booststrap/js/bootstrap.min.js" ></script>
</body>
</html>
