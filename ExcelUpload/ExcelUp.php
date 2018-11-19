<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Upload Excel</title>
  </head>
  <body>
    <?php
      //Conexion con base
      include "../Config/Database.php";
      $db= new Database();
      $dblink= $db->getConnection();
      if(isset($_POST['uploadBtn'])){
        $filename= $_FILES['myFile']['name'];
        $fileTmpName= $_FILES['myFile']['tmp_name'];

        $fileExtension = pathinfo($filename,PATHINFO_EXTENSION);
        $allowedType= array('csv');
        if(!in_array($fileExtension, $allowedType)){ ?>
          <div class="alert alert-danger">
              Tipo invalido
          </div>
        <?php } else {
          $handle = fopen($fileTmpName, 'r');// read
          while (($myData= fgetcsv($handle,1000,',')) !== FALSE) {
           $_Materia= $myData[0];
/*            $_fechaIni= $myData[1];
           $_fechaFin= $myData[2];
            $_Aula= $myData[3];
            $_Inscritos= $myData[4];
            $_Docentes= $myData[6];*/

            echo $_Materia ;


          }
        }

      }


/*    $result = $dblink->query($sql);
      $result->setFetchMode(PDO::FETCH_ASSOC);*/
    ?>

    <div class="container" >
      <form action="" method="post" enctype="multipart/form-data">
          <h3 class="text-center">
          </h3> <hr/>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="file" name="myFile" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="submit" name="uploadBtn" class="btn btn-info">
              </div>
            </div>
          </div>
      </form>
   </div>
  </body>
</html>
