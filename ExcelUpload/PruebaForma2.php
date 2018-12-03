<html>
  <head>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Upload Excel</title>
  </head>
  <body>
  <div class="container">
    <?php  include "../Config/Database.php";    ?>
    <?php
      if(isset($_POST['uploadBtn'])){
        $fileName= $_FILES['myFile']['name'];
        $fileTmpName= $_FILES['myFile']['tmp_name'];

        $fileExtension= pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedType= array('csv');
        $handle = fopen($fileTmpName, 'r' );
        while (($myData = fgetcsv($handle,1000,',')) !== false) {
          $materia = $myData[0];
          $curso = $myData[1];
          $fecha = $myData[2];
          echo "$materia $curso $fecha";
        }
      }
      ?>
      <form method="post" enctype="multipart/form-data">
        <h3 class="text-center" >
        </h3> <hr/>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <input type="file" name="myFile" class="form-control">
            </div>
          </div>
        </div>
        <div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="submit" name="uploadBtn" class="btn btn-info">
              <input type="date" name="chibolo pulpin" class="btn btn-info">
            </div>
          </div>
        </div>
      </form>
    </div>
    </body>
</html>
