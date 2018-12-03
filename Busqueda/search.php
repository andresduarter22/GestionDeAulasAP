<?php
  /**
   *
   */
  class search
  {
    public $_tipoDeReserva=0; //$_POST['tipores'];
    public $_fechasArray=0; //$_POST['fechas'];
    public $_aulaEspecifica=0; //$_POST['aulaEspecifica']
    public $_esAula=true; //$_POST['esAula'];
    public $_ReqcantidadAlumnos=0; //$_POST['reqcantAlumno'];
    public $_cantidadAlumnos=0; //$_POST['cantAlumno'];
    public $_categoriasArrays=0; //$_POST['categorias'];

    if(isset($_POST['submit'])){
      serch();
    }

    public function search()
    {
      $db= new Database();
      $dblink= $db->getConnection();

      // 0 Dias especificao
      // 1 Dias seguidos
      if($_tipoDeReserva){
        reservDiaEspecifico();
      }else {
        reservDiasSeguidos();
      }
    }

    public function reservDiaEspecifico(){

    }

    public function reservDiasSeguidos(){

    }

  }



 ?>
