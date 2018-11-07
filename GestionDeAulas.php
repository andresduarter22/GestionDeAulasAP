<html>
<head>
  <link href="Style.css" type="text/css" rel="stylesheet" />
  <?php
    $mysqli = new mysqli("localhost", "root", "", "bd_aulasperronas");
    ?>
</head>
<body>
  <p>
    <?php $result = $mysqli->query("SELECT * FROM aulas");  ?>
  </p>

  <nav>

  </nav>
</body>

</html>
