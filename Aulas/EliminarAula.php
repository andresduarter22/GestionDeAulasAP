<?php
  include_once "../Config/Database.php";
  $db= new Database();
  $dblink= $db->getConnection();
   $sql = "SELECT * FROM aulas WHERE id_Aulas=".$_GET['id'];
   $result = $dblink->query($sql);
   $fila = $result->fetch();
   //echo $_SERVER['REQUEST_METHOD']
    $sql1= "DELETE from Aulas WHERE id_Aulas = ".$_GET['id'].";";
    $dblink->query($sql1);
   header("Location: GestionDeAulas.php");
   $dblink->close();
   ?>
