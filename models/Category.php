<?php

    class Category{

        private $conn;
        private $table = 'categories';

        //Properties
        public $id;
        public $name;
        public $creation_date;

        //Database connection constructor
        public function __construct($db){
            $this->conn = $db;
        }

        //Get Categories
        public function read(){
            //Create query
            $query = 'SELECT id, name, creation_date FROM' . $table . 'ORDER BY creation_date DESC';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute statement
            $stmt->execute();
            return $stmt;
        }

                //Get one Category
                public function read_one(){
                    //Create query
                    $query = 'SELECT id, name, creation_date FROM' . $table . 'WHERE id=? LIMIT 0,1';
        
                    //Prepare statement
                    $stmt = $this->conn->prepare($query);

                    //Bind parameters
                    $stmt->bindParameter(1, $this->id);
        
                    //Execute statement
                    $stmt->execute();

                    $row = $stmt->fetch(PDP::FETCH_ASSOC);

                    $this->id = $row['id'];
                    $this->name = $row['name'];
                    $this->creation_date = $row['creation_date'];
                }
    }