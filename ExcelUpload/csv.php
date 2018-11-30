<?php


class csv
{
  public function import($file){
    $file = fopen($file, 'r');
    $_cont=0;
    $this->borrarReservasPrevias();

    while ($row = fgetcsv($file)) {
      if($_cont>4){
        $_cadenaDeDatos=$row[0];
        $primerCaracter= substr($_cadenaDeDatos, 0,1);
        if($primerCaracter ===";"){
          break;
        }
        //echo $_cadenaDeDatos   ."</br>";
          $this->AgregarReservasAutomaticas($_cadenaDeDatos);

      }
      $_cont++;
    }
  }

  public function borrarReservasPrevias(){
    include_once "../Config/Database.php";
    $db= new Database();
    $dblink= $db->getConnection();
    //borrar todas las reservas automaticas previas
    $sql = "DELETE FROM reservas WHERE tipo=0;";
    $dblink->query($sql);
    $dblink=null;
  }

  public function AgregarReservasAutomaticas($cadena){
    $myArray = explode(';', $cadena);

    $_Materia=$myArray[0];
    $_FechaInicio=$myArray[1];
    $_FechaFinal=$myArray[2];
    $_Horario=$myArray[3];
    $_Aula=$myArray[4];
    $_Docente=$myArray[7];

    //echo "$_Materia $_FechaInicio $_FechaFinal $_Horario $_Aula $_Docente </br>";
    include_once "../Config/Database.php";
    $db= new Database();
    $dblink= $db->getConnection();



    // Verificar si exite aula
    $sql = "SELECT * FROM aulas WHERE nombre= '$_Aula';";
    $result = $dblink->query($sql);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    if($result->rowCount()){
      //echo "existe Aula</br>";
      //echo "insertando... </br>";
      //obteniendo id de Materia
      $sql = "SELECT id_Materias from materias WHERE nombre_materia='$_Materia';";
      $result = $dblink->query($sql);
      $result->setFetchMode(PDO::FETCH_ASSOC);
      $_IdMateria = $result->fetchColumn();
      //echo "$_IdMateria";
      //echo "  ";
      //obteniendo id de Aula
      $sql = "SELECT id_Aulas from aulas WHERE nombre='$_Aula';";
      $result = $dblink->query($sql);
      $result->setFetchMode(PDO::FETCH_ASSOC);
      $_IdAula = $result->fetchColumn();
      //echo "$_IdAula";

      //ordenando fechas
      $ArregloFechaIni = explode('/', $_FechaInicio);
      $ArregloFechaFin = explode('/', $_FechaFinal);

      $_FInicial= $ArregloFechaIni[2].'-'.$ArregloFechaIni[1].'-'.$ArregloFechaIni[0];
      $_FFinal=$ArregloFechaFin[2].'-'.$ArregloFechaFin[1].'-'.$ArregloFechaFin[0];
      //echo "$_FInicial";
      //echo "$_FFinal";

      //insertando en la base
      $sql = "INSERT INTO reservas values(NULL,$_IdAula,2,$_IdMateria,'$_FInicial','$_FFinal',0,'$_Horario','$_Docente');";
      if ($dblink->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $dblink->error;
      }

    }else {
      echo "$sql";
      echo "no existe Aula <br>";
    }
  //  echo "</br>";
    $dblink=null;

}


  //agrega materias por excel
  public function AgregarMaterias($cadena){
    $myArray = explode(';', $cadena);
    $_Materia=$myArray[0];
//    echo "$_Materia </br>";

  if(!empty($_Materia) ){
    include_once "../Config/Database.php";
    $db= new Database();
    $dblink= $db->getConnection();
    $sql = "SELECT * FROM materias WHERE nombre_materia= '$_Materia';";
    $result = $dblink->query($sql);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    if($result->rowCount()){
  //    echo "no se inserto";
    }else {
      $sql = "INSERT INTO materias values(NULL,'$_Materia');";
      $result = $dblink->query($sql);
  //    echo "insertada";
    }
  //  echo "</br>";

  }
}



  //funcion que agrega solo aulas
 function AgregarAulas($cadena){
    $myArray = explode(';', $cadena);
    $_Aula=$myArray[4];
    //echo "$_Aula";
    if(!empty($_Aula) ){
      echo "$_Materia ";
      include_once "../Config/Database.php";
      $db= new Database();
      $dblink= $db->getConnection();
      $sql = "SELECT * FROM aulas WHERE nombre= '$_Aula';";
      $result = $dblink->query($sql);
      $result->setFetchMode(PDO::FETCH_ASSOC);
      if($result->rowCount()){
        //echo "no se inserto";
      }else {
        $sql = "INSERT INTO aulas values(NULL,'$_Aula',35);";
        $result = $dblink->query($sql);
        //echo "insertada";
      }
      //echo "</br>";
      $dblink=null;
    }
  }
}
  ?>