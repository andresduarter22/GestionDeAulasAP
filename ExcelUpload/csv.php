<?php


class csv
{

  public function import($file){
    $file = fopen($file, 'r');
    $_cont=0;
    while ($row = fgetcsv($file)) {
      if($_cont>0){
        $numero = count($row);
        for ($c=0; $c < $numero; $c++) {
          $_cadenaDeDatos=$row[0];
    //      echo $_cadenaDeDatos   ."</br>";
    //      $this->CrearCaracter($_cadenaDeDatos);
        }
      }
      $_cont++;
    }
  }

  public function CrearCaracter($cadena){
    //echo $cadena   ."</br>";
    $myArray = explode(';', $cadena);

    $_Materia=$myArray[0];
    $_FechaInicio=$myArray[1];
    $_FechaFinal=$myArray[2];
    $_Horario=$myArray[3];
    $_Aula=$myArray[4];
    $_Docente=$myArray[7];
    /*print_r($myArray);
    echo "</br>";*/


    include "../Config/Database.php";
    $db= new Database();
    $dblink= $db->getConnection();
    $sql = 'select * from usuarios;';
    $result = $dblink->query($sql);
    $result->setFetchMode(PDO::FETCH_ASSOC);
 }
}
  ?>
