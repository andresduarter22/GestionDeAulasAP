<?php

class Database
{
    private $host = "localhost";
    private $db_name = "bd_aulasperronas";
    private $db_username = "root";
    private $db_password = "";
    public $connection;

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
