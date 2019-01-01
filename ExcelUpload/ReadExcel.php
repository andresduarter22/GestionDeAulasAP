<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

include "../Config/Database.php";

class ReadExcel
{
    //variables que contienen la conexion con la base, id del usuario que sube el documento y el documento excel
    public $db;
    public $dblink;
    public $idUploader;
    public $sheet;

    //flags
    public $IntegridadDeExcel;
    public $cruzeConReservasManuales;
    public $materiasQuePerdieronAula;

    //arreglos que contienen los conflictos en el proceso  de subir excel
    private $arregloReservasManualesAfectadas = array();
    private $arregloMateriasSinAula = array();

    public function __construct($fileName, $idUploader)
    {
        $this->db = new Database();
        $this->dblink = $this->db->getConnection();
        $this->idUploader = $idUploader;


        //librerias de PHPspreadsheet
        //se lee el archivo excel
        try {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spread = $reader->load($fileName);
            $this->sheet = $spread->getActiveSheet();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    /**
     * funcion que ingresa las reservas a la base de datos
     */
    public function import($tipoDeUpload)
    {
        //variable que habilita lectura de excel
        $read = false;

        $this->borrarReservasPrevias();
        foreach ($this->sheet->getRowIterator() as $row) {
            $_cadenaDeDatos = array(
                $this->sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue(),
                $this->sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getFormattedValue(),
                $this->sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getFormattedValue(),
                $this->sheet->getCellByColumnAndRow(4, $row->getRowIndex()),
                $this->sheet->getCellByColumnAndRow(5, $row->getRowIndex()),
                $this->sheet->getCellByColumnAndRow(8, $row->getRowIndex())
            );
            //echo implode(" | ", $_cadenaDeDatos) . "<br>";

            //flag para detener lectura
            if ($_cadenaDeDatos[0] == 'Total Materias') {
                break;
            }

            if ($read) {
                //echo implode(" | ", $_cadenaDeDatos) . "<br>";
                if ($tipoDeUpload == 0) {
                    $this->AgregarReservasAutomaticas($_cadenaDeDatos, $this->idUploader);
                } else {
                    $this->AgregarAulas($_cadenaDeDatos);
                }
            }

            //flag para iniciar ingreso de datos
            if ($_cadenaDeDatos[0] == 'Materia') {
                $read = true;
            }
        }
    }


    /**
     * Funcion que borra las reservas automaticas en la base de datos
     */
    public function borrarReservasPrevias()
    {
        //borrar todas las reservas automaticas previas
        $sql = "DELETE FROM reservas WHERE tipo=0;";
        $this->dblink->query($sql);
        $dblink = null;
    }


    /**
     * Funcion que agrega las reservas en la base de datos
     */
    public function AgregarReservasAutomaticas($cadena, $idUploader)
    {
        $_Materia = $cadena[0];
        $_FechaInicio = $cadena[1];
        $_FechaFinal = $cadena[2];
        $_Horario = $cadena[3];
        $_Aula = $cadena[4];
        $_Docente = $cadena[5];

        //echo "$_Materia $_FechaInicio $_FechaFinal $_Horario $_Aula $_Docente </br>";

        // Verificar si exite aula
        $sql = "SELECT * FROM aulas WHERE nombre= '$_Aula';";
        //echo $sql . "<br>";
        $result = $this->dblink->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        //si no contiene al menos materia, fecha inicial, fecha final y horario no la inserta
        if ($_Materia != "" && $_FechaInicio != "" && $_FechaFinal != "" && $_Horario != "") {
            // solo si el aula esta en blanco o existe en la base de datos la inserta
            if (($result->rowCount() || $_Aula == "")) {
                $_IdMateria = 2;
                $sql = "SELECT * FROM materias WHERE nombre_materia= '$_Materia';";
                $result = $this->dblink->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                //busca el id de materia o ingresa la materia en la base de datos
                if ($result->rowCount()) {
                    //echo "ya existio";
                    $sql = "SELECT id_Materias FROM materias WHERE nombre_materia= '$_Materia';";
                    $result2 = $this->dblink->query($sql);
                    $result2->setFetchMode(PDO::FETCH_ASSOC);
                    $_IdMateria = $result2->fetchColumn();
                } else {
                    $sql = "INSERT INTO materias values(NULL,'$_Materia');";
                    //      echo "$sql <br>";
                    $this->dblink->query($sql);
                    $_IdMateria = $this->dblink->lastInsertId();

                }

                //obteniendo id de Aula
                $sql = "SELECT id_Aulas from aulas WHERE nombre='$_Aula';";
                $result = $this->dblink->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $_IdAula = $result->fetchColumn();

                //ordenando fechas
                $ArregloFechaIni = explode('/', $_FechaInicio);
                $ArregloFechaFin = explode('/', $_FechaFinal);

                $_FInicial = $ArregloFechaIni[2] . '-' . $ArregloFechaIni[0] . '-' . $ArregloFechaIni[1];
                $_FFinal = $ArregloFechaFin[2] . '-' . $ArregloFechaFin[0] . '-' . $ArregloFechaFin[1];
                //echo "$_FInicial";
                //echo "$_FFinal ";

                //si el aula esta vacia la ingresa a la base como null
                if ($_Aula == "") {
                    $sql3 = "INSERT INTO reservas values(NULL,NULL,$idUploader,$_IdMateria,'$_FInicial','$_FFinal',0,'$_Horario','$_Docente');";
                    if ($this->dblink->query($sql3) === FALSE) {
                        echo "Error: " . $sql3 . "<br>" . $this->dblink->error;
                    }
                } else {
                    //insertando en la base
                    $sql3 = "INSERT INTO reservas values(NULL,$_IdAula,$idUploader,$_IdMateria,'$_FInicial','$_FFinal',0,'$_Horario','$_Docente');";

                    if ($this->dblink->query($sql3) == FALSE) {
                        echo "Error: " . $sql3 . "<br>" . $this->dblink->error;
                    }
                }
            } else {
                echo "$_Aula esta aula no existe en la base de Datos por lo tanto no sera ingrsada<br>";
            }
        }

    }

    /**
     *
     * Funcion que agrega solo aulas a la base de datos
     */
    function AgregarAulas($cadena)
    {
        $_Aula = $cadena[4];
        if ($_Aula != '') {
            $sql = "SELECT * FROM aulas WHERE nombre= '$_Aula';";
            $result = $this->dblink->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            if ($result->rowCount()) {
                //echo "no se inserto";
            } else {
                $sql = "INSERT INTO aulas values(NULL,'$_Aula',35);";
                $result = $this->dblink->query($sql);
                //echo "insertada";
            }
            $dblink = null;
        }
    }

    /**
     * verifica que el contenido del documento excel sea integro
     * lo que significa que cada entrada debe poseer al menos materia, ambas fechas y el horario en que se realiza esa reserva
     *
     * si alguna entrada no cumple esta condicion se levanta la bandera
     *    $this->IntegridadDeExcel con el valor de false
     */
    function checkIntegrity()
    {
        //variable que habilita lectura de excel
        $read = false;

        //flag estado del excel
        $this->IntegridadDeExcel = true;

        foreach ($this->sheet->getRowIterator() as $row) {
            $_cadenaDeDatos = array(
                $this->sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue(),
                $this->sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getFormattedValue(),
                $this->sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getFormattedValue(),
                $this->sheet->getCellByColumnAndRow(4, $row->getRowIndex()),
                $this->sheet->getCellByColumnAndRow(5, $row->getRowIndex()),
                $this->sheet->getCellByColumnAndRow(8, $row->getRowIndex())
            );
            //flag para detener lectura
            if ($_cadenaDeDatos[0] == 'Total Materias') {
                break;
            }
            if ($read) {
                if ($_cadenaDeDatos[0] == "" || $_cadenaDeDatos[1] == "" || $_cadenaDeDatos[2] == "" || $_cadenaDeDatos[3] == "") {
                    $this->IntegridadDeExcel = false;
                }
            }
            //flag para iniciar ingreso de datos
            if ($_cadenaDeDatos[0] == 'Materia') {
                $read = true;
            }
        }/*
        if (!$this->contenidoExcel) {
            echo "El contenido del documento excel contiene conflictos como falta de materias fechas y horarios, estas reservas no seran anadidas a la base";
        } else {
            echo "Estado excel ... Ok";
        }*/
    }

    /**
     * Funcion que verifica si existe alguna reserva manual previa que cruze con las nuevas reservas automaticas levantando la bandera
     *
     * $this->cruzeConReservasManuales a true
     *
     * Si la reserva manual se realiza durante fin de semana como ser sabado o domingo no sera eliminada ya que las reservas automaticas
     * son estrictamente de lunes a viernes
     *
     */
    function cruzeConReservManuales()
    {
        //variable que habilita lectura de excel
        $read = false;

        $this->cruzeConReservasManuales = false;
        foreach ($this->sheet->getRowIterator() as $row) {
            $_cadenaDeDatos = array(
                $this->sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue(),
                $this->sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getFormattedValue(),
                $this->sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getFormattedValue(),
                $this->sheet->getCellByColumnAndRow(4, $row->getRowIndex()),
                $this->sheet->getCellByColumnAndRow(5, $row->getRowIndex()),
                $this->sheet->getCellByColumnAndRow(8, $row->getRowIndex())
            );
            //flag para detener lectura
            if ($_cadenaDeDatos[0] == 'Total Materias') {
                break;
            }
            if ($read && $_cadenaDeDatos[4] != "") {
                //obteniendo id de Aula
                $sql = "SELECT id_Aulas from aulas WHERE nombre='$_cadenaDeDatos[4]';";
                $result = $this->dblink->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                if ($result->rowCount() >= 1) {
                    $_IdAula = $result->fetchColumn();

                    //ordenando fechas
                    $ArregloFechaIni = explode('/', $_cadenaDeDatos[1]);
                    $ArregloFechaFin = explode('/', $_cadenaDeDatos[2]);

                    $_FInicial = $ArregloFechaIni[2] . '-' . $ArregloFechaIni[0] . '-' . $ArregloFechaIni[1];
                    $_FFinal = $ArregloFechaFin[2] . '-' . $ArregloFechaFin[0] . '-' . $ArregloFechaFin[1];
                    //query que busca similitud de entrada que tenga la misma aula, horario, y cruze de horarios.ademas de asegurarse de que es dia de semana
                    $sql = "SELECT * FROM reservas WHERE  (tipo=1)  AND (dayofweek(fecha_inicio)>1 AND dayofweek(fecha_inicio)<7)
                                            AND (dayofweek(fecha_final)>1 AND dayofweek(fecha_final)<7)
                                            AND (id_Aula_Reservada = $_IdAula)AND (horario = '$_cadenaDeDatos[3]')
                                            AND (('$_FInicial'  BETWEEN fecha_inicio AND  fecha_final) OR ('$_FFinal' BETWEEN fecha_inicio AND fecha_final)
                                            OR (fecha_inicio BETWEEN '$_FInicial' AND '$_FFinal') OR (fecha_final BETWEEN '$_FInicial' AND '$_FFinal'));";
                    //echo $sql . "<br>";
                    $result = $this->dblink->query($sql);
                    $result->setFetchMode(PDO::FETCH_ASSOC);
                    if ($result->rowCount()) {
                        $this->cruzeConReservasManuales = true;
                        while ($fila = $result->fetch()) {
                            //echo implode(" | ", $fila) . "<br>";
                            array_push($this->arregloReservasManualesAfectadas, $fila);
                        }
                    }
                }
            }


            //flag para iniciar ingreso de datos
            if ($_cadenaDeDatos[0] == 'Materia') {
                $read = true;
            }
        }
        /*if ($this->cruzeConReservasManuales) {
            //echo "Las sigientes reservas seran borradas";
            $arreglsinRep = array_unique($this->arregloReservasManualesAfectadas);
            foreach ($arreglsinRep as $row) {
               //     echo implode(" | ", $row) . "<br>";
            }
        }*/
    }

    /**
     * Funcion que verifica que reservas automaticas pasadas que tenian una aula asignada sean reincertadas
     * en la base sin aula asignada mostrando la bandera
     *
     *  $this->materiasQuePerdieronAula a true
     */
    function verificarReservaSeQuedaSinAula()
    {
        $this->materiasQuePerdieronAula = false;

        //variable que habilita lectura de excel
        $read = false;

        foreach ($this->sheet->getRowIterator() as $row) {
            $_cadenaDeDatos = array(
                $this->sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue(),
                $this->sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getFormattedValue(),
                $this->sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getFormattedValue(),
                $this->sheet->getCellByColumnAndRow(4, $row->getRowIndex()),
                $this->sheet->getCellByColumnAndRow(5, $row->getRowIndex()),
                $this->sheet->getCellByColumnAndRow(8, $row->getRowIndex())
            );
            //flag para detener lectura
            if ($_cadenaDeDatos[0] == 'Total Materias') {
                break;
            }
            if ($read) {
                $sql = "SELECT id_Materias FROM materias WHERE nombre_materia= '$_cadenaDeDatos[0]';";
                $result = $this->dblink->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $_IdMateria = $result->fetchColumn();

                if ($_cadenaDeDatos[4] == "" && $_IdMateria != null) {
                    //echo "sin aula <br>";
                    //ordenando fechas
                    $ArregloFechaIni = explode('/', $_cadenaDeDatos[1]);
                    $ArregloFechaFin = explode('/', $_cadenaDeDatos[2]);
                    //echo $_cadenaDeDatos[5];

                    $_FInicial = $ArregloFechaIni[2] . '-' . $ArregloFechaIni[0] . '-' . $ArregloFechaIni[1];
                    $_FFinal = $ArregloFechaFin[2] . '-' . $ArregloFechaFin[0] . '-' . $ArregloFechaFin[1];
                    $sql2 = "SELECT * FROM reservas WHERE  horario = '$_cadenaDeDatos[3]' AND fecha_inicio = '$_FInicial' AND fecha_final = '$_FFinal' AND tipo=0 
                            AND docente = '$_cadenaDeDatos[5]'
                            AND id_Materia_Reserva = $_IdMateria ;";
                    $result2 = $this->dblink->query($sql2);
                    $result2->setFetchMode(PDO::FETCH_ASSOC);
                    while ($fila = $result2->fetch()) {
                        ;
                        if (is_numeric($fila['id_Aula_Reservada'])) {
                            $this->materiasQuePerdieronAula = true;
                            array_push($this->arregloMateriasSinAula, $fila);
                            //  echo "Existe una materia que perdio su aula";
                        }
                    }
                }
            }
            //flag para iniciar ingreso de datos
            if ($_cadenaDeDatos[0] == 'Materia') {
                $read = true;
            }
        }
        /*
        if($this->materiasQuePerdieronAula){
            foreach ($this->arregloMateriasSinAula as $row){
                echo implode(";",$row). "<br>";
            }
        }*/


    }


    /**
     * Funcion que avisa si es que existe algun conflicto durante la lectura del documento excel
     */
    function anytrouble(){
        if ($this->IntegridadDeExcel == 0 || $this->cruzeConReservasManuales == 1 || $this->materiasQuePerdieronAula == 1) {
            if ($this->IntegridadDeExcel == 0) {
                echo "Existen problemas respecto al contenido del excel <br>";
            }
            if ($this->cruzeConReservasManuales == 1) {
                echo "Existen problemas respecto al cruce con reservas manuales<br>";
            }
            if ($this->materiasQuePerdieronAula == 1) {
                echo "Existen problemas respecto a materias que perdieron su aula<br>";
            }
            return true;
        }else{
            return false;
        }
    }

    function sendmail()
    {

    }

    /**
     * Funcion que borra las reservas manuales que entran en conflicto con las nuevas reservas automaticas
     */
    function deleteManualReserv()
    {
        foreach ($this->arregloReservasManualesAfectadas as $row) {
            $reserv = array_values($row);
            $sql = "DELETE FROM reservas where id_Reservas = $reserv[0]";
            $this->dblink->query($sql);
        }
    }
}
