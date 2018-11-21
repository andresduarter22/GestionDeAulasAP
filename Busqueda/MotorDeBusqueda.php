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
    session_start();
    $db= new Database();
    $dblink= $db->getConnection();
    $sql = 'select * from Aulas;';
    $result = $dblink->query($sql);
    $result->setFetchMode(PDO::FETCH_ASSOC);
  ?>
    <form>
      <div class="container">
        <input type="checkbox" enabled>Dias Especificos</input>
        <input type="checkbox" enabled>Dias Seguidos</input>
      </div>
      <div class="container">
        <select class="form-control">
          <?php   while ($fila = $result->fetch()){  ?>
          <option value="volvo"><?php echo $fila['nombre']; ?></option>
          <?php } ?>
        </select>
      </div>


      <?php
      include 'FuncionCalendario.php';

      $calendar = new Calendar();

      echo $calendar->show();
      ?>

  <div class="input-group mb-3 container">
   <div class="input-group-prepend">
    <div class="input-group-text">
      <input type="checkbox" aria-label="Checkbox for following text input">
    </div>
  </div>
  <input type="text" class="form-control" aria-label="Text input with checkbox" placeholder="Cantidad de Alumnos">
</div>
  <div class="container">
    <table class=" table table-striped table-bordered  table-responsive-sm m-5 scrollbar " >
      <thead  class="thead-dark">
        <tr>
          <th style="width: 30%"> Nombre de la Categoria</th>
          <th style="width: 10%"> Check </th>
        </tr>
      </thead>
       <tbody>
        <?php
        $sql = 'select * from Categorias;';
        $result = $dblink->query($sql);
         while ($fila = $result->fetch()){  ?>
         <tr>
            <td><?php echo $fila['nombre_categoria']; ?></td>
            <td><?php echo "<input  type=\"checkbox\" name=\"categoria[]\" id=\"categoria\" value=\" ".$fila['id_Categorias']." \" enabled>";?></td>
           </tr>
        <?php } ?>

      </tbody>
    </table>
  </div>
    </form>

    <button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#info"><img  src="../Images/iconoInfo.png" onclick="info" class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>
    <div class="modal fade" id="info" name="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
