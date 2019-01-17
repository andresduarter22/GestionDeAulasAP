<?php
session_start();
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;


include "../Config/DataBase.php";

class ReadExcel
{
    //variables que contienen la conexion con la base, id del usuario que sube el documento y el documento excel
    public $db;
    public $dblink;
    public $idUploader;
    public $sheet;

    //flags
    private $IntegridadDeExcel;
    private $cruzeConReservasManuales;
    private $materiasQuePerdieronAula;

    //flags de integrudad
    private $DatosIncompletos;
    private $AulaInexistentete;
    //arrglo de integridad
    private $arregloDeIntegridad = array();


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

        //$reader = new Xls();
        //$spread = $reader->load($fileName);
        try {

            //$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            //echo var_dump($reader);
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

        $idDeUsuario = $_SESSION['idUsuario'];
        $sql4 = "SELECT * FROM Usuarios where id_Usuario=$idDeUsuario";
        $resultado1 = $this->dblink->query($sql4);
        $infoUs = $resultado1->fetch();

        if($infoUs['Rol']==0){
            $rolDeUsuario="Reservador";
        }else if ($infoUs['Rol']==1){
            $rolDeUsuario="Actualizador";
        }else{
            $rolDeUsuario="Administrador";
        }

        $sql_log_eu = "INSERT INTO Logs  VALUES (NULL,'" . $infoUs['nombre'] . "','" . $infoUs['num_interno'] . "','" . $infoUs['E_Mail'] . "','" .$rolDeUsuario  . "','Subio un archivo excel al sistema ',now())";
        $this->dblink->query($sql_log_eu);

    }


    /**
     * Funcion que borra las reservas automaticas en la base de datos
     */
    public function borrarReservasPrevias()
    {
        //borrar todas las reservas automaticas previas
        $sql = "DELETE FROM Reservas WHERE tipo=0;";
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
        $sql = "SELECT * FROM Aulas WHERE nombre= '$_Aula';";
        //echo $sql . "<br>";
        $result = $this->dblink->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        //si no contiene al menos materia, fecha inicial, fecha final y horario no la inserta
        if ($_Materia != "" && $_FechaInicio != "" && $_FechaFinal != "" && $_Horario != "") {
            // solo si el aula esta en blanco o existe en la base de datos la inserta
            if (($result->rowCount() || $_Aula == "")) {
                $_IdMateria = 2;
                $sql = "SELECT * FROM Materias WHERE nombre_materia= '$_Materia';";
                $result = $this->dblink->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                //busca el id de materia o ingresa la materia en la base de datos
                if ($result->rowCount()) {
                    //echo "ya existio";
                    $sql = "SELECT id_Materias FROM Materias WHERE nombre_materia= '$_Materia';";
                    $result2 = $this->dblink->query($sql);
                    $result2->setFetchMode(PDO::FETCH_ASSOC);
                    $_IdMateria = $result2->fetchColumn();
                } else {
                    $sql = "INSERT INTO Materias values(NULL,'$_Materia');";
                    //      echo "$sql <br>";
                    $this->dblink->query($sql);
                    $_IdMateria = $this->dblink->lastInsertId();

                }

                //obteniendo id de Aula
                $sql = "SELECT id_Aulas from Aulas WHERE nombre='$_Aula';";
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
                    $sql3 = "INSERT INTO Reservas values(NULL,NULL,$idUploader,$_IdMateria,'$_FInicial','$_FFinal',0,'$_Horario','$_Docente');";
                    if ($this->dblink->query($sql3) === FALSE) {
                        echo "Error: " . $sql3 . "<br>" . $this->dblink->error;
                    }
                } else {
                    //insertando en la base
                    $sql3 = "INSERT INTO Reservas values(NULL,$_IdAula,$idUploader,$_IdMateria,'$_FInicial','$_FFinal',0,'$_Horario','$_Docente');";

                    if ($this->dblink->query($sql3) == FALSE) {
                        echo "Error: " . $sql3 . "<br>" . $this->dblink->error;
                    }
                }
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
            $sql = "SELECT * FROM Aulas WHERE nombre= '$_Aula';";
            $result = $this->dblink->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            if ($result->rowCount()) {
                //echo "no se inserto";
            } else {
                $sql = "INSERT INTO Aulas values(NULL,'$_Aula',35);";
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
        $this->IntegridadDeExcel = false;

        $this->DatosIncompletos = false;
        $this->AulaInexistentete = false;

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
                    $this->IntegridadDeExcel = true;
                    $this->DatosIncompletos = true;
                    $posicion = array($row->getRowIndex(), 0);
                    array_push($this->arregloDeIntegridad, $posicion);
                }
                if ($_cadenaDeDatos[4] != "") {
                    $sql = "SELECT * FROM Aulas WHERE nombre='$_cadenaDeDatos[4]';";
                    $result = $this->dblink->query($sql);
                    $result->setFetchMode(PDO::FETCH_ASSOC);
                    if ($result->rowCount() == 0) {
                        $this->IntegridadDeExcel = true;
                        $this->AulaInexistentete = true;
                        $posicion = array($row->getRowIndex(), 1);
                        array_push($this->arregloDeIntegridad, $posicion);
                    }
                }
            }
            //flag para iniciar ingreso de datos
            if ($_cadenaDeDatos[0] == 'Materia') {
                $read = true;
            }
        }
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
                $sql = "SELECT id_Aulas from Aulas WHERE nombre='$_cadenaDeDatos[4]';";
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
                    $sql = "SELECT * FROM Reservas WHERE  (tipo=1)  AND (dayofweek(fecha_inicio)>1 AND dayofweek(fecha_inicio)<7)
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
                            $idAula = $fila['id_Aula_Reservada'];
                            $sql2 = "SELECT nombre FROM Aulas WHERE id_Aulas =   $idAula; ";
                            $result2 = $this->dblink->query($sql2);
                            $q = $result2->fetchColumn();

                            $idUsuario = $fila['id_Usuario_Reserva'];
                            $sql = "SELECT * FROM Usuarios WHERE id_Usuario =  $idUsuario; ";
                            $result = $this->dblink->query($sql);
                            $infoUsuario = $result->fetch();

                            $idMat = $fila['id_Materia_Reserva'];
                            $sql = "SELECT * FROM Materias WHERE id_Materias =  $idMat ; ";
                            $result = $this->dblink->query($sql);
                            $infoMaterias = $result->fetch();

                            $arregloInfoMateriaABorra = array($infoUsuario[1], $q, $infoMaterias[1], $fila['docente'], $infoUsuario[3], $fila['id_Reservas']);

                            //echo implode(" | ", $result2) . "<br>";
                            array_push($this->arregloReservasManualesAfectadas, $arregloInfoMateriaABorra);
                        }
                    }
                }
            }


            //flag para iniciar ingreso de datos
            if ($_cadenaDeDatos[0] == 'Materia') {
                $read = true;
            }
        }
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
                $sql = "SELECT id_Materias FROM Materias WHERE nombre_materia= '$_cadenaDeDatos[0]';";
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
                    $sql2 = "SELECT * FROM Reservas WHERE  horario = '$_cadenaDeDatos[3]' AND fecha_inicio = '$_FInicial' AND fecha_final = '$_FFinal' AND tipo=0
                            AND docente = '$_cadenaDeDatos[5]'
                            AND id_Materia_Reserva = $_IdMateria ;";
                    $result2 = $this->dblink->query($sql2);
                    $result2->setFetchMode(PDO::FETCH_ASSOC);
                    while ($fila = $result2->fetch()) {
                        if (is_numeric($fila['id_Aula_Reservada'])) {
                            $this->materiasQuePerdieronAula = true;
                            $idMat = $fila['id_Materia_Reserva'];
                            $sql = "SELECT * FROM Materias WHERE id_Materias =  $idMat ; ";
                            $result = $this->dblink->query($sql);
                            $infoMaterias = $result->fetch();

                            $arrayInfoMateriaSinAula = array($infoMaterias[1], $fila['docente'], $fila['fecha_inicio'], $fila['horario']);
                            array_push($this->arregloMateriasSinAula, $arrayInfoMateriaSinAula);
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
    }


    /**
     * Funcion que avisa si es que existe algun conflicto durante la lectura del documento excel
     */
    function anytrouble()
    {
        if ($this->IntegridadDeExcel == 1 || $this->cruzeConReservasManuales == 1 || $this->materiasQuePerdieronAula == 1) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Funcion que borra las reservas manuales que entran en conflicto con las nuevas reservas automaticas
     */
    function deleteManualReserv()
    {
        echo implode(";", $this->getArregloReservasManualesAfectadas());
        $arreglsinRep = array_unique($this->getArregloReservasManualesAfectadas());
        foreach ($arreglsinRep as $row) {
            $reserv = array_values($row);
            //echo  implode(";",$reserv);
            //echo $reserv[0];
            $sql = "DELETE FROM Reservas where id_Reservas = $reserv[5]";
            $this->dblink->query($sql);
        }
    }

    /**
     * @return mixed
     */
    public function getIntegridadDeExcel()
    {
        return $this->IntegridadDeExcel;
    }

    /**
     * @return mixed
     */
    public function getCruzeConReservasManuales()
    {
        return $this->cruzeConReservasManuales;
    }

    /**
     * @return mixed
     */
    public function getMateriasQuePerdieronAula()
    {
        return $this->materiasQuePerdieronAula;
    }

    /**
     * @return array
     */
    public function getArregloReservasManualesAfectadas()
    {
        return $this->arregloReservasManualesAfectadas;
    }

    /**
     * @return array
     */
    public function getArregloMateriasSinAula()
    {
        return $this->arregloMateriasSinAula;
    }

    /**
     * @return mixed
     */
    public function getDatosIncompletos()
    {
        return $this->DatosIncompletos;
    }

    /**
     * @return mixed
     */
    public function getAulaInexistentete()
    {
        return $this->AulaInexistentete;
    }

    /**
     * @return array
     */
    public function getArregloDeIntegridad()
    {
        return $this->arregloDeIntegridad;
    }


}
