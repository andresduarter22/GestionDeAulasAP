<html>
<head>
  <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Borrar Categoria</title>
</head>
<body>
  <div>
    <button type="button" class="btn btn-danger">Cerrar sesión</button>
      <a href="../Homes/HomeLogeado.php"><img src="../Images/Logo_UPB.jpg" class="img-fluid float-right" alt="Responsive image" ></a>
  </div>
  <br/>
  <br />
  <br />
  <br />
  <br />

  <?php
  session_start();
  $db_name = "bd_aulasperronas";
  $db_user = "root";
  $db_pass = "";
  $dblink = new mysqli('localhost', $db_user, $db_pass, $db_name);
  if ($dblink->connect_error) {
    die('Error al conectar a la Base de Datos (' . $dblink->connect_errno . ') '
          . $dblink->connect_error);

  }
  //echo $_SERVER['REQUEST_METHOD']
    //$sql = "select * from Categorias where id_Categorias = ".$_GET['id'].";" ;
    //$result = $dblink->query($sql);
    //echo var_dump($result);
    $aulas = array("Hola");
    $aulas1 = array("Hola");
    $contador=0;
  ?>

    <input type="text" name="id1" value= <?php echo  $_GET['id'] ;?> class="form-control" disabled/>
    <table class="table table-striped table-bordered  table-responsive-sm m-5s">
      <thead  class="thead-dark">
      <tr>
        <th style="width: 15%">Lista de Aulas afectadas</th>
      </tr>
    </thead>
    <tbody>
      <?php $sql2 = "SELECT * FROM Aulas_Categoria WHERE id_Categoria = ".$_GET['id'].";";
      var_dump($sql2);
      $res=$dblink->query($sql2);

      while ($fila = $res->fetch_object()){
          $aulas[$contador] = $fila->id_Aula;
          $sql3 = "SELECT * FROM  aulas WHERE id_Aulas =".$aulas[$contador].";";
                    $res1=$dblink->query($sql3);
                    $fila1 = $res1->fetch_object();
         ?>
        <tr>
          <td><?php echo "$fila1->nombre"; ?></td>
        </tr>
      <?php $contador = $contador + 1;
    } ?>
    </tbody>
  </table>
    </table>
    <!--tabla 2 -->
    <table class="table table-striped table-bordered  table-responsive-sm m-5s">
      <thead  class="thead-dark">
      <tr>
        <th style="width: 15%">Lista de Aulas que se que quedan sin categoria</th>
      </tr>
    </thead>
    <tbody>
      <?php
      echo count($aulas);
      for($i=0;$i<count($aulas);$i++){
        $sql4 = "SELECT * FROM Aulas_Categoria WHERE id_Categoria = ".$_GET['id']." AND id_Aula = ".$aulas[$i].";";
        $res4=$dblink->query($sql4);
        $fila4 = $res4->fetch_object();
        $aulas1[$i] = $fila4->id_Aula;
        echo count($aulas1[$i]);
        $sql5 = "SELECT * FROM Aulas WHERE id_Aulas =".$aulas1[$i].";";
        $res5=$dblink->query($sql5);
        $fila5 = $res5->fetch_object();
        if($res5->num_rows = 1){
          ?>
          <tr>
            <td><?php echo "$fila5->nombre"; ?></td>
          </tr>
          <?php
        }
      }
         ?>
    </tbody>
  </table>
    </table>
    <form method="post" action=<?php echo '"EliminiarCategoria.php?id='.$_GET['id'].'"' ?>>
        <input type="hidden" value="<?php echo $_GET['id'] ;?>" name="id1" class="form-control"/>
        <input type="submit" name="submit" class="btn btn-primary" value="Confirmar" />
    </form>
    <?php
    if(isset($_POST['id1'])){
      $_id=$_POST['id1'];
      $sql1= "DELETE from Categorias WHERE id_Categorias = ".$_id;
      $dblink->query($sql1);
    }
     ?>
<!-- Boton para ir Atras -->
<a class="btn btn-primary" href="GestionDeCategorias.php">Atras</a>
<!-- Inicio boton de informacion -->
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
        Esta es la pantalla donde se puede consultar toda la lista de Aulas dentro de la base de Datos

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Final boton de Informacion -->
<?php
 $dblink->close();
 ?>
 <!-- jQuery -->
 <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

 <!-- Bootstrap JS -->
 <script src="../Booststrap/js/bootstrap.min.js" ></script>
</body>

</html>
