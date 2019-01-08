<html>
<head>
  <!-- jQuery -->
  <script src="../Booststrap/js/jquery-3.3.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="../Booststrap/js/bootstrap.min.js" ></script>
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
  include_once "../Config/Database.php";
  $db= new Database();
  $dblink= $db->getConnection();
    //echo $_SERVER['REQUEST_METHOD']
    $aulas = array("Hola");
    $aulas1 = array("Hola");
    $contador=0;
    $sql = "SELECT * FROM Categorias WHERE id_Categorias =".$_GET['id']." ;";
    $nombre_categoria = $dblink->query($sql);
    $nombre_catego = $nombre_categoria->fetch();
  ?>
    <div class="container">
    <input type="text" name="id1" value= "Desea borrar la categoria: <?php echo  $nombre_catego['nombre_categoria'];?> ?" class="form-control" disabled/>
    <!--tabla 1 -->
    <?php
    $sql2 = "SELECT * FROM Aulas_Categoria WHERE id_Categoria = ".$_GET['id'].";";
    $res=$dblink->query($sql2);
    $comprobacion = $res->fetch();
    //echo var_dump($fila4);
    if($comprobacion){ ?>
    <table class="table table-striped table-bordered  table-responsive-sm m-5s">
      <thead  class="thead-dark">
      <tr>
        <th style="width: 15%">Lista de Aulas afectadas</th>
      </tr>
    </thead>
    <tbody>
      <?php
          //Primer elemento de la tabla
          $aulas[0] = $comprobacion['id_Aula'];
          $sql3 = "SELECT * FROM  aulas WHERE id_Aulas =".$aulas[0].";";
                    $res1=$dblink->query($sql3);
                    $fila1 = $res1->fetch();
         ?>
        <tr>
          <td><?php echo $fila1['nombre'] ; ?></td>
        </tr>
      <?php
      while ($fila = $res->fetch()){
          $aulas[$contador] = $fila['id_Aula'];
          $sql3 = "SELECT * FROM  aulas WHERE id_Aulas =".$aulas[$contador].";";
                    $res1=$dblink->query($sql3);
                    $fila1 = $res1->fetch();
         ?>
        <tr>
          <td><?php echo $fila1['nombre'] ; ?></td>
        </tr>
      <?php $contador = $contador + 1;
    }
   ?>
    </tbody>
  </table>
    </table>
    <!--tabla 2 -->
    <?php
    foreach($aulas as $aula){
        $sql4 = "SELECT count(id_Aula) AS num FROM aulas_categoria WHERE id_Aula =".$aula." ;";
        $res4=$dblink->query($sql4);
        $fila4 = $res4->fetch();
        if($fila4){
          echo $fila4['num'];
          if($fila4['num'] == 1){
            $sql5 = "SELECT * FROM Aulas WHERE id_Aulas =".$aula.";";
            $res5=$dblink->query($sql5);
            $fila5 = $res5->fetch();

              ?>
    <table class="table table-striped table-bordered  table-responsive-sm m-5s">
      <thead  class="thead-dark">
      <tr>
        <th style="width: 15%">Lista de Aulas que se que quedan sin categoria</th>
      </tr>
    </thead>
    <tbody>
                <tr>
                  <td><?php echo $fila5['nombre'] ; ?></td>
                </tr>
        <?php
      }else{
        echo "Ningun aula se quedara sin categoria";
          }
        }
      }
    }else{
      echo "Ningun Aula sera afectada";
    }
         ?>

    </tbody>
  </table>
    </table>
    <form method="post" action=<?php echo '"EliminiarCategoria.php?id='.$_GET['id'].'"' ?>>
        <input type="hidden" value="<?php echo $_GET['id'] ;?>" name="id1" class="form-control"/>
        <input type="submit" name="submit" class="btn btn-primary" value="Confirmar" />
    </form>
    </div>
    <?php
    if(isset($_POST['id1'])){
      $_id=$_POST['id1'];
      $sql_nombre= "SELECT * from Categorias WHERE id_Categorias = ".$_id;
      $res_n = $dblink->query($sql_nombre);
      $_aux = $res_n->fetch();
      $_nombre = $_aux['nombre_categoria'];
      $sql1= "DELETE from Categorias WHERE id_Categorias = ".$_id;
      //echo var_dump($sql1);
      $dblink->query($sql1);
      $sql_log_ec = "INSERT INTO Logs (id_Log,nombre_usuario,num_interno_usuario,correo_usuario,tipo_usuario,Accion,Fecha_Accion) VALUES (NULL,'Andres','666','ad@gmail.com','m','Se elimino una categoria llamada $_nombre',now())";
      $dblink->query($sql_log_ec);
      header("Location: GestionDeCategorias.php");
    }
     ?>
<!-- Boton para ir Atras -->
<a class="btn btn-primary" href="GestionDeCategorias.php">Atras</a>
<!-- Inicio boton de informacion -->
<button type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#infoA"><img  src="../Images/iconoInfo.png"  class="img-fluid float-right" alt="Responsive image" height="42" width="42"  data-target="info"/></button>
<div class="modal fade" id="infoA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Esta es la pantalla donde se puede eliminar el aula seleccionada.

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
</body>

</html>
