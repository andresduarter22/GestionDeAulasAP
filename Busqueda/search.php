<?php


class search
{
    // FALSE Dias especificos
    // TRUE Dias seguidos
    public $_tipoDeReserva; //=true; //$_POST['tipores'];

    //array para dias seguidos
    //public $_fechasArray = array('fechaini' => '2018-8-15 ', 'fechafin' => '2018-9-28'); //$_POST['fechas'];
    //array para dias especificos
    //public $_fechasArray= array('2018-8-2','2018-8-15','2018-8-20'); //$_POST['fechas'];
    public $_fechasArray = array();

    // true aula aulaEspecifica
    // false sin aula
    public $_esAula; //= false ; //$_POST['esAula'];

    public $_aulaEspecifica; // = 23; //$_POST['aulaEspecifica']
    public $_categoriasArrays; //= array(2, 1, 3); //$_POST['categorias'];


    public $_horario; //= "A";
    public $_ReqcantidadAlumnos; // = false; //$_POST['reqcantAlumno'];
    // true requiere preveer la cantidad de alumnos
    // false no importa cantdad de alumnos
    public $_cantidadAlumnos; // = 10; //$_POST['cantAlumno'];
    public $dblink;
    public $_AulasDisponibles = array();
    public $_AulasNoDisponibles = array();


    function __construct()
    {
        include_once '../Config/DataBase.php';
        $db = new Database();
        $this->dblink = $db->getConnection();
        // Declaracion de variables
        $this->_tipoDeReserva = $_POST['TipoDeBusqueda'];
        if ($this->_tipoDeReserva == 0) {
            $fechasSinOrdenar = explode(',', $_POST['fechasEspecificas']);
            foreach ($fechasSinOrdenar as $fecha) {
                //ordenando fechas
                $ArregloFechaIni = explode('/', $fecha);
                $_fechaOrdenada = $ArregloFechaIni[2] . '-' . $ArregloFechaIni[0] . '-' . $ArregloFechaIni[1];
                //quitandole espacios inecesarios
                $_fechaSinEspacios = str_replace(" ", "", $_fechaOrdenada);
                array_push($this->_fechasArray, $_fechaSinEspacios);
            }
        } else {
            //ordenando fechas
                $FechaIni = explode('/', $_POST['fechasSeguidasInicio']);
            $FechaFin = explode('/', $_POST['fechasSeguidasFin']);

            $_fechaIniOrdenada = $FechaIni[2] . '-' . $FechaIni[0] . '-' . $FechaIni[1];
            $_fechaFinOrdenada = $FechaFin[2] . '-' . $FechaFin[0] . '-' . $FechaFin[1];
            //quitandole espacios inecesarios
            $_fechaIniSinEsp = str_replace(" ", "", $_fechaIniOrdenada);
            $_fechaFinSinEsp = str_replace(" ", "", $_fechaFinOrdenada);

            $this->_fechasArray = array('fechaini' => $_fechaIniSinEsp, 'fechafin' => $_fechaFinSinEsp);
        }

        if ($_POST['BuscaAulaEsp'] === 'on') {
            $this->_esAula = true;
            $this->_aulaEspecifica = $_POST['idDeAula'];
        } else {
            $this->_esAula = false;
            $this->_categoriasArrays = $_POST['cat'];
        }
        //echo implode(";",$this->_categoriasArrays);

        if ($_POST['requiereAlumnos'] === 'on') {
            $this->_ReqcantidadAlumnos = true;
            $this->_cantidadAlumnos = $_POST['cantalumnos'];
        } else {
            $this->_ReqcantidadAlumnos = false;
        }
        $this->_horario=$_POST['horario'];
    }

    /**
     * @return array funcion que devuelve 2 arreglos uno con las aulas disponivles y
     * otro ccn las aulas que cumplen con las condiciones pero estan ocupadas
     */
    public function busca()
    {
        $this->ListaDeAulas();


        //echo "Disponibles " . implode(",",$this->_AulasDisponibles) . "<br>";
        // echo "No disponibles " . implode(",",$this->_AulasNoDisponibles);
        //echo $this->_AulasNoDisponibles[0][0];

        return array($this->_AulasDisponibles, $this->_AulasNoDisponibles);

    }

    /**
     * Funcion que llama a la funcion @verificarDiponibilidad que requiere id de aula
     * la llama dependindo si es un aula especifica o busqueda por categoria
     */
    public funCtion ListaDeAulas()
    {
        if ($this->_esAula == 1) {
            //Si busca por un aula especifica ejecuta la busqueda solo del aula especifica

            $this->verificarDiponibilidad($this->_aulaEspecifica);
        } else {
            //Si busca por categoria, obtiene el arreglo y buscara id por a ID de aula
            $varArregloDeCategorias1 = $this->_categoriasArrays;
            $sql = "";

            if ($this->_ReqcantidadAlumnos == 1) {
                //Si requiera cantidad de aulas especificas
                //Query que busca el id_Aula de la tabla aulas_categoria, seleccionando valores sin repetir andemas de
                // agregar la cantidad de alumnos a la busqueda
                $sql = "SELECT DISTINCT id_Aula FROM Aulas_Categoria AC  INNER JOIN aulas A ON AC.id_Aula=A.id_Aulas WHERE (AC.id_Categoria= $varArregloDeCategorias1[0] ";
                for ($i = 1; $i < count($varArregloDeCategorias1); $i++) {
                    $sql = $sql . " OR AC.id_Categoria= $varArregloDeCategorias1[$i] ";
                }
                $sql = $sql . ") AND A.cantidad_alumnos >=  $this->_cantidadAlumnos ; ";
            } else {
                //Si no requiere cant de alumnos
                //Query que busca el id_Aula de la tabla Aculas_categoria, seleccionando valores sin repetir
                $sql = "SELECT DISTINCT id_Aula FROM aulas_categoria WHERE id_Categoria= $varArregloDeCategorias1[0] ";
                for ($i = 1; $i < count($varArregloDeCategorias1); $i++) {
                    $sql = $sql . " OR id_Categoria= $varArregloDeCategorias1[$i] ";
                }
                $sql = $sql . ";";
            }
            //echo $sql;
            $result = $this->dblink->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            //echo $this->_tipoDeReserva;
            //Busqueda por cada id_Aula encontrado
            while ($fila = $result->fetch()) {
                $this->verificarDiponibilidad($fila['id_Aula']);
            }
        }
    }

    /**
     * @param $id_AulaEspecifica
     * Funcion que recibe id_AulaEspecifica, y llena los arreglos de aulas disponnible y no disponibles
     *
     */
    private function verificarDiponibilidad($id_AulaEspecifica)
    {


        if ($this->_tipoDeReserva == 0) {
            //reserva de dias especifico
            //recibe el arreglo de fechas y horario
            $varArregloDeCategorias1 = $this->_fechasArray;
            $hora = $this->_horario;

            //query que busca en reservas si existe un reserva
            $sql = "SELECT * FROM reservas WHERE id_Aula_Reservada= $id_AulaEspecifica AND horario= '$hora' AND";
            $sql = $sql . "( '$varArregloDeCategorias1[0]' BETWEEN fecha_inicio AND fecha_final   ";
            for ($i = 1; $i < count($varArregloDeCategorias1); $i++) {
                $sql = $sql . "OR '$varArregloDeCategorias1[$i]' BETWEEN fecha_inicio AND fecha_final ";
            }
            $sql = $sql . " ) ORDER BY fecha_inicio;";
            // echo $sql . "<br>";
            $result = $this->dblink->query($sql);

            //  echo $id_AulaEspecifica;
            if ($result->rowCount()) {
                $arrayDeIdReservas = array();
                while ($q = $result->fetch()) {
                    //echo  $q['id_Reservas'] . "<br>";
                    array_push($arrayDeIdReservas, $q['id_Reservas']);
                }
                array_push($this->_AulasNoDisponibles, $arrayDeIdReservas);
            } else {
                array_push($this->_AulasDisponibles, $id_AulaEspecifica);
            }
        } else {
            //reserva de dias seguidos
            $fechainicial = $this->_fechasArray['fechaini'];
            $fechafinal = $this->_fechasArray['fechafin'];
            //busca en la tabla reserva si tiene la misma aula y mismo horario si existe cruces con los param de busqueda
            $sql = "SELECT * FROM reservas WHERE id_Aula_Reservada= '$id_AulaEspecifica'  AND (dayofweek(fecha_inicio)>1) AND  (dayofweek(fecha_inicio)<7) AND horario= '$this->_horario'
                AND ((fecha_inicio BETWEEN '$fechainicial' AND '$fechafinal' )
                 OR (fecha_final BETWEEN '$fechainicial' AND '$fechafinal' )) ORDER BY  fecha_inicio; ";
            //echo "$sql <br>";
            $result = $this->dblink->query($sql);
            //$q=$result->fetch();
            if ($result->rowCount()) {
                //si existen resultados de la busqeuda anade esos resultados a aulas no disponibles
                $arrayDeIdReservas = array();
                while ($q = $result->fetch()) {
                    // echo  $q['id_Reservas'] . "<br>";
                    array_push($arrayDeIdReservas, $q['id_Reservas']);
                }
                // echo implode(",", $arrayDeIdReservas) . "<br>";

                array_push($this->_AulasNoDisponibles, $arrayDeIdReservas);
            } else {
                // si no existen resultados se anade el id del aula a aulas disponibles
                array_push($this->_AulasDisponibles, $id_AulaEspecifica);
            }

        }
        //echo $sql . "<br>";

    }
}

//implode("|",$type); to char array


?>
