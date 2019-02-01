<?php

class Database
{
    // parametros para la conexion al SQL, nombre de host, nombre de bd
    // nombre de usuarios y password
    private $host = "localhost";
    private $db_name = "aulas";
    private $db_username = "aulas";
    private $db_password = "4ul4s2019!";
    public $connection;


    //Funcion que realiza la conexion a la base
    // la cual conecta con los parametros ya llamados
    // con un try catch por si falla algo
    // devuelve la conexion con la base
    public function getConnection()
    {
        $this->connection = null;
        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->db_username, $this->db_password);
        } catch (PDOException $e) {
            echo "Database connection error: " . $e->getMessage();
        }
        return $this->connection;
    }
}
