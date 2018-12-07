<?php


  class search
  {

    public $_tipoDeReserva=false; //$_POST['tipores'];
    // FALSE Dias especificos
    // TRUE Dias seguidos
    //array para dias seguidos
    //public $_fechasArray= array('fechaini'=>'2018-8-15 ','fechafin'=>'2018-9-28'); //$_POST['fechas'];
    //array para dias variados
    public $_fechasArray= array('2018-8-2','2018-8-15','2018-8-20'); //$_POST['fechas'];

    public $_aulaEspecifica=50; //$_POST['aulaEspecifica']
    public $_esAula=false; //$_POST['esAula'];
    // true aula aulaEspecifica
    // false sin aula
    public $_ReqcantidadAlumnos=false; //$_POST['reqcantAlumno'];
    // true requiere preveer la cantidad de alumnos
    // false no importa cantdad de alumnos
    public $_cantidadAlumnos= 30; //$_POST['cantAlumno'];
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
      $_cantidadAlumnos= $_POST['cantalumnos'];
      //$_categoriasArrays=0;
      //$_cantidadAlumnos= $_POST['cantalumnos'];
  }

    public function busca(){
      if($this->_tipoDeReserva==0){
        $this->reservDiasEspecificos();
      }else {
        $this->reservDiasSeguidos();

      }
//      echo implode(",",$this->_AulasDisponibles);

      $queryDisponibles = http_build_query(array('disp' => $this->_AulasDisponibles));
      $queryNoDisponibles = http_build_query(array('nodisp' => $this->_AulasNoDisponibles));

      echo implode(",",$this->_AulasDisponibles) . "<br>";
      echo implode(",",$this->_AulasNoDisponibles);
      //echo "$query";
      header("Location: Resultados.php?" . $queryDisponibles . $queryNoDisponibles);

    }

    public function reservDiasEspecificos(){
        //se tiene uno o varios dias, por ende un array en $_fechasArray
      if($this->_esAula==1){
        $this->verificarDisponibilidadAulaEspecificos($this->_aulaEspecifica );
      }else{
        $varArregloDeCategorias1=$this->_categoriasArrays;

        if($this->_ReqcantidadAlumnos==1){
          //busca por categoria y por cantidad de alumnos
          $sql= "SELECT id_Aula FROM aulas_categoria AC  INNER JOIN aulas A ON AC.id_Aula=A.id_Aulas WHERE (AC.id_Categoria= $varArregloDeCategorias1[0] ";

          for ($i=1; $i < count($varArregloDeCategorias1); $i++) {
                $sql = $sql .  " OR AC.id_Categoria= $varArregloDeCategorias1[$i] ";
          }
          $sql = $sql . ") AND A.cantidad_alumnos >=  $this->_cantidadAlumnos ; ";
          //El resultado es una lista de id's de aula que cumplen la categoria y la cantidad de Alumnos
          $result = $this->dblink->query($sql);
          $result->setFetchMode(PDO::FETCH_ASSOC);
          while ($fila = $result->fetch()){
            $this->verificarDisponibilidadAulaEspecificos($fila['id_Aula']);
            echo "<br>";
          }
        }else{
          //busca por categoria
          $sql= "SELECT id_Aula FROM aulas_categoria WHERE id_Categoria= $varArregloDeCategorias1[0]";
          for ($i=1; $i < count($varArregloDeCategorias1); $i++) {
              $sql = $sql .  " OR id_Categoria= $varArregloDeCategorias1[$i] ";
          }
          $sql= $sql . ";";
          echo "$sql <br>";
          $result = $this->dblink->query($sql);
          $result->setFetchMode(PDO::FETCH_ASSOC);
          while ($fila = $result->fetch()){
            //echo $fila['id_Aula'] . "<br>";
            $this->verificarDisponibilidadAulaEspecificos($fila['id_Aula']);
            echo "<br>";
          }
        }
      }
    }

    public function reservDiasSeguidos(){
        // se tiene 2 fechas intervalo en el cual buscar en $_fechasArray
        if($this->_esAula==1){
            // tiene un aula especifica para la busqueda
            $this->verificarDisponibilidadAulaSeguidos($this->_aulaEspecifica );
        }else{
          $varArregloDeCategorias1=$this->_categoriasArrays;

          if($this->_ReqcantidadAlumnos==1){
            //busca por categoria y por cantidad de alumnos
            $sql= "SELECT id_Aula FROM aulas_categoria AC  INNER JOIN aulas A ON AC.id_Aula=A.id_Aulas WHERE (AC.id_Categoria= $varArregloDeCategorias1[0] ";

            for ($i=1; $i < count($varArregloDeCategorias1); $i++) {
                  $sql = $sql .  " OR AC.id_Categoria= $varArregloDeCategorias1[$i] ";
            }
            $sql = $sql . ") AND A.cantidad_alumnos >=  $this->_cantidadAlumnos ; ";
            $result = $this->dblink->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            while ($fila = $result->fetch()){
              $this->verificarDisponibilidadAulaSeguidos($fila['id_Aula']);
              echo "<br>";
            }
          }else{
            //busca por categoria
            $sql= "SELECT id_Aula FROM aulas_categoria WHERE id_Categoria= $varArregloDeCategorias1[0]";
            for ($i=1; $i < count($varArregloDeCategorias1); $i++) {
                $sql = $sql .  " OR id_Categoria= $varArregloDeCategorias1[$i] ";
            }
            $sql= $sql . ";";
            //echo "$sql";
            $result = $this->dblink->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            while ($fila = $result->fetch()){
              //echo $fila['id_Aula'] . "<br>";
              $this->verificarDisponibilidadAulaSeguidos($fila['id_Aula']);
              echo "<br>";
            }
          }
        }

      }

    private function verificarDisponibilidadAulaEspecificos($id_AulaEspecifica){
      $sql= "SELECT nombre FROM aulas WHERE id_Aulas= $id_AulaEspecifica ; ";
      $result = $this->dblink->query($sql);
      $nombreAula=$result->fetch();
      // Arreglo que marca la disponibilidad de un aula
      $_disponibilidad= array('nombreDeAula'=>$nombreAula[0] ,
                              'A'=>true,
                              'B'=>true,
                              'C'=>true,
                              'D'=>true,
                              'E'=>true,
                              'Dates'=> $this->_fechasArray,
                              'idAula'=> $id_AulaEspecifica
                            );
      //echo  implode("|",$_disponibilidad);
      $fechainicial=  $this->_fechasArray['fechaini'];
      $fechafinal=  $this->_fechasArray['fechafin'];
      $varArregloDeCategorias1=$this->_fechasArray;

      $sql= "SELECT horario FROM reservas WHERE id_Aula_Reservada= $id_AulaEspecifica AND ";
      $sql= $sql . "( '$varArregloDeCategorias1[0]' BETWEEN fecha_inicio AND fecha_final ";
      for ($i=1; $i <count($varArregloDeCategorias1) ; $i++) {
        $sql= $sql . "OR '$varArregloDeCategorias1[$i]' BETWEEN fecha_inicio AND fecha_final ";
      }
      $sql= $sql . ");";
      //echo "$sql";
      $result = $this->dblink->query($sql);
      while ($fila = $result->fetch()) {
        switch ($fila[0]) {
          case 'A':
              $_disponibilidad['A']=false;
            break;
          case 'B':
                $_disponibilidad['B']=false;
            break;
          case 'C':
                $_disponibilidad['C']=false;
          break;
          case 'D':
                $_disponibilidad['D']=false;
          break;
          case 'E':
                $_disponibilidad['E']=false;
          break;

          default:
            break;
        }
      }
      // echo implode("|",$_disponibilidad) ;
      if($_disponibilidad['A']==1 || $_disponibilidad['B']==1 || $_disponibilidad['C']==1|| $_disponibilidad['D']==1|| $_disponibilidad['E']==1){
        array_push ($this->_AulasDisponibles, $_disponibilidad);
        $this->imprimirResultados($_disponibilidad);
      }else {
        array_push ($this->_AulasNoDisponibles, $_disponibilidad);
      }

    }

    private function verificarDisponibilidadAulaSeguidos($id_AulaEspecifica){
        //busca nombre de aula
        $sql= "SELECT nombre FROM aulas WHERE id_Aulas= $id_AulaEspecifica ; ";
      //  echo "$sql";
        $result = $this->dblink->query($sql);
        $nombreAula=$result->fetch();

        // Arreglo que marca la disponibilidad de un aula
        $_disponibilidad= array('nombreDeAula'=>$nombreAula[0] ,
                                'A'=>true,
                                'B'=>true,
                                'C'=>true,
                                'D'=>true,
                                'E'=>true,
                                'Dates'=> $this->_fechasArray,
                                'idAula'=> $id_AulaEspecifica
                                  );
        //echo  implode("|",$_disponibilidad);
        $fechainicial=  $this->_fechasArray['fechaini'];
        $fechafinal=  $this->_fechasArray['fechafin'];

        //busca en la tabla reserva
        $sql= "SELECT horario FROM reservas WHERE id_Aula_Reservada= '$id_AulaEspecifica'
                AND ((fecha_inicio BETWEEN '$fechainicial' AND '$fechafinal' )
                 OR (fecha_final BETWEEN '$fechainicial' AND '$fechafinal' )); ";
        //echo "$sql";
        $result = $this->dblink->query($sql);
        while ($fila = $result->fetch()) {
          switch ($fila[0]) {
            case 'A':
                $_disponibilidad['A']=false;
              break;
            case 'B':
                  $_disponibilidad['B']=false;
              break;
            case 'C':
                  $_disponibilidad['C']=false;
            break;
            case 'D':
                  $_disponibilidad['D']=false;
            break;
            case 'E':
                  $_disponibilidad['E']=false;
            break;

            default:
              break;
          }
        }
        $this->resultados= $_disponibilidad;
    //    echo implode("|",$_disponibilidad);
        if($_disponibilidad['A']==1 || $_disponibilidad['B']==1 || $_disponibilidad['C']==1|| $_disponibilidad['D']==1|| $_disponibilidad['E']==1){
          array_push ($this->_AulasDisponibles, $_disponibilidad);
          $this->imprimirResultados($_disponibilidad);
        }else {
          array_push ($this->_AulasNoDisponibles, $_disponibilidad);
        }
      }

      private function imprimirResultados($disp){
          //echo  implode("|",$disp);
          echo "El aula: ". $disp['nombreDeAula'] ." se encuentra disponible en Los Horarios: ";
          foreach ($disp as $key=>$valor) {
            if($valor=='1'){
              echo $key . "  ";
            }
        }

      }
  }
    //implode("|",$type); to char array




 ?>
