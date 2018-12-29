<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

include "../Config/Database.php";

class ReadExcel
{
    public $db;
    public $dblink;
    public $idUploader;
    public $sheet;

    //flags
    private $contenidoExcel;
    private $cruzeConReservasManuales;
    private $materiasQuePerdieronAula;

    private $arregloReservasManualesAfectadas = array();
    private $arregloMateriasSinAula= array();

    public function __construct($fileName, $idUploader)
    {
        $this->db = new Database();
        $this->dblink = $this->db->getConnection();
        $this->idUploader = $idUploader;


        //librerias de PHPspreadsheet
        try {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spread = $reader->load($fileName);
            $this->sheet = $spread->getActiveSheet();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

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


    public function borrarReservasPrevias()
    {
        //borrar todas las reservas automaticas previas
        $sql = "DELETE FROM reservas WHERE tipo=0;";
        $this->dblink->query($sql);
        $dblink = null;
    }


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
        if ($_Materia != "" && $_FechaInicio != "" && $_FechaFinal != "" && $_Horario != "") {
            if (($result->rowCount() || $_Aula == "")) {
                $_IdMateria = 2;
                $sql = "SELECT * FROM materias WHERE nombre_materia= '$_Materia';";
                $result = $this->dblink->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
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
                echo "$sql  ";
                echo "no existe Aula en la base de Datos<br>";
            }
        }

    }

    //funcion que agrega solo aulas
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

    function checkIntegrity()
    {
        //variable que habilita lectura de excel
        $read = false;

        //flag estado del excel
        $this->contenidoExcel = true;

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
                    $this->contenidoExcel = false;
                }
            }
            //flag para iniciar ingreso de datos
            if ($_cadenaDeDatos[0] == 'Materia') {
                $read = true;
            }
        }
        if (!$this->contenidoExcel) {
            echo "El contenido del documento excel contiene conflictos como falta de materias fechas y horarios, estas reservas no seran anadidas a la base";
        } else {
            echo "Estado excel ... Ok";
        }
    }

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
                $_IdAula = $result->fetchColumn();

                //ordenando fechas
                $ArregloFechaIni = explode('/', $_cadenaDeDatos[1]);
                $ArregloFechaFin = explode('/', $_cadenaDeDatos[2]);

                $_FInicial = $ArregloFechaIni[2] . '-' . $ArregloFechaIni[0] . '-' . $ArregloFechaIni[1];
                $_FFinal = $ArregloFechaFin[2] . '-' . $ArregloFechaFin[0] . '-' . $ArregloFechaFin[1];
                $sql = "SELECT * FROM reservas WHERE  (tipo=1) AND (id_Aula_Reservada = $_IdAula)AND (horario = '$_cadenaDeDatos[3]') AND (('$_FInicial'  BETWEEN fecha_inicio AND  fecha_final) OR ('$_FFinal' BETWEEN fecha_inicio AND fecha_final));";
                //echo $sql . "<br>";
                $result = $this->dblink->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                if ($result->rowCount()) {
                    $this->cruzeConReservasManuales = true;
                    while ($fila = $result->fetch()) {
                       // echo implode(" | ", $fila) . "<br>";
                        array_push($this->arregloReservasManualesAfectadas, $fila);
                    }
                }
            }
            //flag para iniciar ingreso de datos
            if ($_cadenaDeDatos[0] == 'Materia') {
                $read = true;
            }
        }
        if ($this->cruzeConReservasManuales){
            echo "Las sigientes reservas seran borradas";
            foreach ($this->arregloReservasManualesAfectadas as $row){
           //     echo implode(" | ", $row) . "<br>";
            }
        }
    }

    function verificarReservaSeQuedaSinAula(){
        $this->materiasQuePerdieronAula=false;

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
                $result=$this->dblink->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $_IdMateria = $result->fetchColumn();

                if($_cadenaDeDatos[4]=="" && $_IdMateria != null ){
                    //echo "sin aula <br>";
                    //ordenando fechas
                    $ArregloFechaIni = explode('/', $_cadenaDeDatos[1]);
                    $ArregloFechaFin = explode('/', $_cadenaDeDatos[2]);

                    $_FInicial = $ArregloFechaIni[2] . '-' . $ArregloFechaIni[0] . '-' . $ArregloFechaIni[1];
                    $_FFinal = $ArregloFechaFin[2] . '-' . $ArregloFechaFin[0] . '-' . $ArregloFechaFin[1];
                    $sql2 ="SELECT id_Aula_Reservada FROM reservas WHERE  horario = '$_cadenaDeDatos[3]' AND fecha_inicio = '$_FInicial' AND fecha_final = '$_FFinal' AND tipo=0 AND docente = '$_cadenaDeDatos[5]'
                      AND id_Materia_Reserva = $_IdMateria ;";
                    $result2=$this->dblink->query($sql2);
                    $aulsAnterior= $result2->fetchColumn();
                    if( is_numeric($aulsAnterior)){
                        $this->materiasQuePerdieronAula=true;
                        /**
                         * obtener id de reserva para guardar nombre de reserva que perdio el aula
                         * Apurate pendejo
                         */
                        echo "Existe un que perdio su aula";
                    }
                }
            }
            //flag para iniciar ingreso de datos
            if ($_cadenaDeDatos[0] == 'Materia') {
                $read = true;
            }
        }


    }

    function deleteManualReserv(){
        foreach ($this->arregloReservasManualesAfectadas as $row){
            $reserv= array_values($row);
            $sql  = "DELETE FROM reservas where id_Reservas = $reserv[0]";
            $this->dblink->query($sql);
        }
    }
}
