<?php
  include "csv.php";
  include "../Config/Database.php";

  $csv=new csv();
  if(isset($_POST['sub'])){
      $csv->import($_FILES['file']['tmp_name']);
  }
?>
<html>
  <head>
    <link rel="stylesheet" href="../Booststrap/css/bootstrap.css" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Upload Excel</title>
  </head>
  <body>
    <form method="post" enctype="multipart/form-data">
      <input type="file" name="file">
      <input type="submit" name="sub" value="Import">
    </form>
  </body>
</html>
