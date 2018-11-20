<html>
<head>
<link href="Style.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
  <div>
    <button type="button" class="btn btn-danger">Cerrar sesión</button>
      <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image" ></a>
  </div>
  <?php
    //Conexion con base
    include "../Config/Database.php";
    //include_once "Actions.php";

    $db= new Database();
    $dblink= $db->getConnection();
  ?>
    <form>
      <div class="container">
        <input type="checkbox" enabled>Dias Especificos</input>
        <input type="checkbox" enabled>Dias Seguidos</input>
      </div>
      <div>
        <select class="form-control">
          <option value="volvo">Volvo</option>
        </select>
      </div>
    </form>

    <form>

      <?php
      include 'FuncionCalendario.php';

      $calendar = new Calendar();

      echo $calendar->show();
      ?>
    </form>

    <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>
    <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            AIUDA XD
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <?php
     $dblink->close();
     ?>
<!-- jQuery -->
<script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="../Booststrap/js/bootstrap.min.js" ></script>
</body>
</html>
