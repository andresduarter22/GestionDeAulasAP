<?php


  class search
  {

    public $_tipoDeReserva=false; //$_POST['tipores'];
    // FALSE Dias especificos
    // TRUE Dias seguidos
    //array para dias seguidos
    //public $_fechasArray= array('fechaini'=>'2018-8-15 ','fechafin'=>'2018-9-28'); //$_POST['fechas'];
    //array para dias especificos
    public $_fechasArray= array('2018-8-2','2018-8-15','2018-8-20'); //$_POST['fechas'];
    public $_horario= "A";
    public $_aulaEspecifica=50; //$_POST['aulaEspecifica']
    public $_esAula=false; //$_POST['esAula'];
    // true aula aulaEspecifica
    // false sin aula
    public $_ReqcantidadAlumnos=true; //$_POST['reqcantAlumno'];
    // true requiere preveer la cantidad de alumnos
    // false no importa cantdad de alumnos
    public $_cantidadAlumnos= 10; //$_POST['cantAlumno'];
    public $_categoriasArrays=array(2,1); //$_POST['categorias'];
    public $dblink=0;

    public $_AulasDisponibles=array();
    public $_AulasNoDisponibles=array();


    function __construct() {
      include_once '../Config/Database.php';
      $db= new Database();
      $this->dblink = $db->getConnection();
      //$_tipoDeReserva=0; //$_POST['tipores'];
      //$_fechasArray=0; //$_POST['fechas'];
      //$_aulaEspecifica=0; //$_POST['aulaEspecifica']
      //$_esAula=true; //$_POST['esAula'];
      //$_ReqcantidadAlumnos=0; //$_POST['reqcantAlumno'];
      //$_horario="A" // $_POST['horario']
      $_cantidadAlumnos= $_POST['cantalumnos'];
      //$_categoriasArrays=0;
      //$_cantidadAlumnos= $_POST['cantalumnos'];
  }

    public function busca(){
      $this->ListaDeAulas();

      //echo "Disponibles " . implode(",",$this->_AulasDisponibles) . "<br>";
      //echo "No disponibles " . implode(",",$this->_AulasNoDisponibles[5]);
      //echo $this->_AulasNoDisponibles[0][0];
      /*
      if($this->_tipoDeReserva==0){
        $this->reservDiasEspecificos();
      }else {
        $this->reservDiasSeguidos();
      }*/
      //echo implode(",",$this->_AulasDisponibles[0
          //  echo implode("|",$this->_AulasDisponibles[0]);
      //echo "$this->_AulasNoDisponibles[1]";
      return  array($this->_AulasDisponibles, $this->_AulasNoDisponibles);
/*      $queryDisponibles = http_build_query(array('disp' => $this->_AulasDisponibles));
      $queryNoDisponibles = http_build_query(array('nodisp' => $this->_AulasNoDisponibles));
      echo implode(",",$this->_AulasDisponibles) . "<br>";
      echo implode(",",$this->_AulasNoDisponibles);
      //echo "$query";
      header("Location: Resultados.php?" . $queryDisponibles . $queryNoDisponibles);
*/      //Buscar que devuelva los 2 arreglos
    }

    public funCtion ListaDeAulas(){
      if($this->_esAula==1){
        $this->verificarDisponibilidadAulaEspecificos($this->_aulaEspecifica );
      }else{
        $varArregloDeCategorias1=$this->_categoriasArrays;
        $sql="";
        if($this->_ReqcantidadAlumnos==1){
          $sql= "SELECT DISTINCT id_Aula FROM aulas_categoria AC  INNER JOIN aulas A ON AC.id_Aula=A.id_Aulas WHERE (AC.id_Categoria= $varArregloDeCategorias1[0] ";
          for ($i=1; $i < count($varArregloDeCategorias1); $i++) {
              $sql = $sql .  " OR AC.id_Categoria= $varArregloDeCategorias1[$i] ";
          }
          $sql = $sql . ") AND A.cantidad_alumnos >=  $this->_cantidadAlumnos ; ";
        }else {
          $sql= "SELECT id_Aula FROM aulas_categoria WHERE id_Categoria= $varArregloDeCategorias1[0] ";
          for ($i=1; $i < count($varArregloDeCategorias1); $i++) {
              $sql = $sql .  " OR id_Categoria= $varArregloDeCategorias1[$i] ";
          }
          $sql= $sql . ";";
        }
        //echo $sql;
        $result = $this->dblink->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        //echo $this->_tipoDeReserva;
        while ($fila = $result->fetch()){

          $this->verificarDiponibilidad($fila['id_Aula']);

        }

      }
    }

    private function verificarDiponibilidad($id_AulaEspecifica){
      $_AulaDisponible=true;
      if($this->_tipoDeReserva==0){

        //reserva especifica
        $varArregloDeCategorias1= $this->_fechasArray;
        $hora= $this->_horario;
        $sql= "SELECT * FROM reservas WHERE id_Aula_Reservada= $id_AulaEspecifica AND horario= '$hora' AND";
        $sql= $sql . "( '$varArregloDeCategorias1[0]' BETWEEN fecha_inicio AND fecha_final   ";
        for ($i=1; $i <count($varArregloDeCategorias1) ; $i++) {
          $sql= $sql . "OR '$varArregloDeCategorias1[$i]' BETWEEN fecha_inicio AND fecha_final ";
        }
        $sql= $sql . " );";
       // echo $sql . "<br>";
        $result = $this->dblink->query($sql);

      //  echo $id_AulaEspecifica;
        if($result->rowCount()){
            $arrayDeIdReservas=array();
            while ($q=$result->fetch()) {
            //echo  $q['id_Reservas'] . "<br>";
              array_push ($arrayDeIdReservas, $q['id_Reservas']);
            }
            array_push ($this->_AulasNoDisponibles, $arrayDeIdReservas);
        }else {
              array_push ($this->_AulasDisponibles, $id_AulaEspecifica);
        }
      }else {
        $fechainicial=  $this->_fechasArray['fechaini'];
        $fechafinal=  $this->_fechasArray['fechafin'];
        //busca en la tabla reserva
        $sql= "SELECT * FROM reservas WHERE id_Aula_Reservada= '$id_AulaEspecifica' AND horario= '$this->_horario'
                AND ((fecha_inicio BETWEEN '$fechainicial' AND '$fechafinal' )
                 OR (fecha_final BETWEEN '$fechainicial' AND '$fechafinal' )); ";
        //echo "$sql <br>";
        $result = $this->dblink->query($sql);
        //$q=$result->fetch();
        if($result->rowCount()){
          $arrayDeIdReservas=array();
          while ($q=$result->fetch()) {
            //echo  $q['id_Reservas'] . "<br>";
            array_push ($arrayDeIdReservas, $q['id_Reservas']);
          }
        //  echo implode(",", $arrayDeIdReservas) . "<br>";

          array_push ($this->_AulasNoDisponibles, $arrayDeIdReservas);
        }else {
          array_push ($this->_AulasDisponibles, $id_AulaEspecifica);
        }

      }
    }
  }
    //implode("|",$type); to char array




 ?>
