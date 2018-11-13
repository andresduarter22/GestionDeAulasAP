<?php

class DataBase {

   private $host = "localhost";
   private $db_name = "bd_aulasperronas";
   private $db_username = "root";
   private $db_password = "";
   public $connection;



  public function getConection(){
  $this->$connection=null;
    $db_link = new mysqli($host, $db_username, $db_password, $db_name);
    if ($db_link->connect_error) {
     die('Error al conectar a la Base de Datos (' .  $db_link->connect_errno . ') '
           . $db_link->connect_error);
    }
    return $db_link;
  }
}



?>
