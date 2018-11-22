<?php


class csv
{
  public function import($file){
    $file = fopen($file, 'r');
    $_cont=0;
    while ($row = fgetcsv($file)) {
      if($_cont>4){
        $numero = count($row);
        for ($c=0; $c < $numero; $c++) {
          $_cadenaDeDatos=$row[0];
    //      echo $_cadenaDeDatos   ."</br>";
         $this->AgregarMaterias($_cadenaDeDatos);
        }
      }
      $_cont++;
    }
  }

  //funcion que agrega solo aulas
  /**
    FALTA EVITAR QUE SE LEEA LA ULTIMA LINEA
  */
  //agrega materias por excel
  public function AgregarMaterias($cadena){
    $myArray = explode(';', $cadena);
    $_Materia=$myArray[0];
    echo "$_Materia </br>";

  if(!empty($_Materia) ){
    include_once "../Config/Database.php";
    $db= new Database();
    $dblink= $db->getConnection();
    $sql = "SELECT * FROM materias WHERE nombre_materia= '$_Materia';";
    $result = $dblink->query($sql);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    if($result->rowCount()){
      echo "no se inserto";
    }else {
      $sql = "INSERT INTO materias values(NULL,'$_Materia');";
      $result = $dblink->query($sql);
      echo "insertada";
    }
    echo "</br>";

  }
}



  //funcion que agrega solo aulas
  /**
    FALTA EVITAR QUE SE LEEA LA ULTIMA LINEA
  */
  public function AgregarAulas($cadena){
    $myArray = explode(';', $cadena);

    $_Materia=$myArray[0];
    $_FechaInicio=$myArray[1];
    $_FechaFinal=$myArray[2];
    $_Horario=$myArray[3];
    $_Aula=$myArray[4];
    $_Docente=$myArray[7];
  if(!empty($_Aula) ){
    echo "$_Materia ";
    include_once "../Config/Database.php";
    $db= new Database();
    $dblink= $db->getConnection();
    $sql = "SELECT * FROM aulas WHERE nombre= '$_Aula';";
    $result = $dblink->query($sql);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    if($result->rowCount()){
      echo "no se inserto";
    }else {
      $sql = "INSERT INTO aulas values(NULL,'$_Aula',35);";
      $result = $dblink->query($sql);
      echo "insertada";
    }
    echo "</br>";
    $dblink=null;
  }
 }
}
  ?>
