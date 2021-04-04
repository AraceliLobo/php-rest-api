<?php

    class Database{

    //Database parameters
    private $host = 'localhost';
    private $db_name = 'products_catalogue';
    private $user_name = 'root';
    private $password = '';
    private $conn;

    //DB Connection
    public function connect(){
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . 'dbname=' . $this->db_name, $this->user_name, $this->password);
        } catch (PDOexception $e) {
            echo 'Connection error:' . $e->getMessage();
        }
        return $this->conn;
    }
}
