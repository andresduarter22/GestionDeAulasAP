<?php


  class search
  {

    public $_tipoDeReserva=true; //$_POST['tipores'];
    // 0 Dias especificos
    // 1 Dias seguidos
    public $_fechasArray= array('fechaini'=>'2018-10-1 ','fechafin'=>'2018-11-1'); //$_POST['fechas'];
    public $_aulaEspecifica="A7 (CC 35)"; //$_POST['aulaEspecifica']
    public $_esAula=0; //$_POST['esAula'];
    // true aula aulaEspecifica
    // false sin aula
    public $_ReqcantidadAlumnos=0; //$_POST['reqcantAlumno'];
    public $_cantidadAlumnos= 0; //$_POST['cantAlumno'];
    public $_categoriasArrays=array('Bloque A','Bloque L'); //$_POST['categorias'];
    public $dblink=0;

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
      // 0 Dias especificos
      // 1 Dias seguidos
      if($this->_tipoDeReserva==0){
        $this->reservDiasEspecificos();
      }else {
        $this->reservDiasSeguidos();
      }


//      header("Location MotorDeBusqueda.php");

    }

    public function reservDiasEspecificos(){
        //se tiene uno o varios dias, por ende un array en $_fechasArray

    }

    public function reservDiasSeguidos(){
        // se tiene 2 fechas intervalo en el cual buscar en $_fechasArray
        if($this->_esAula==1){
            // tiene un aula especifica para la busqueda
            $this->verificarDisponibilidadAula($this->_aulaEspecifica );
        }else{
            //busca por categoria
            echo $this->_categoriasArrays[1];
        }

      }

    private function verificarDisponibilidadAula($id_AulaEspecifica){
        // Arreglo que marca la disponibilidad de un aula
        $_disponibilidad= array('nombreDeAula'=>$id_AulaEspecifica ,
                                'A'=>true,
                                'B'=>true,
                                'C'=>true,
                                'D'=>true,
                                'E'=>true);
        //echo  implode("|",$_disponibilidad);

        // busca el id del aula
        $sql= "SELECT id_Aulas FROM aulas WHERE nombre= '$id_AulaEspecifica' ; ";
      //  echo "$sql";
        $result = $this->dblink->query($sql);
        $fila=$result->fetch();
        $fechainicial=  $this->_fechasArray['fechaini'];
        $fechafinal=  $this->_fechasArray['fechafin'];

        //busca en la tabla reserva
        $sql= "SELECT horario FROM reservas WHERE id_Aula_Reservada= '$fila[0]'
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
        $this->imprimirResultados($_disponibilidad);
      }

      private function imprimirResultados($disp){
          //echo  implode("|",$disp);
          echo "El aula: ". $disp['nombreDeAula'] ." se encuentra disponible en Los Horarios: ";
          foreach ($disp as $key=>$valor) {
            if($valor==1){
              echo $key . "  ";
            }
        }

      }
  }
  //implode("|",$type); to char array




 ?>
