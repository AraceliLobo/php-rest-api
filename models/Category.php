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
            $stmt->bindParam(1, $this->id);

            //Execute statement
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->creation_date = $row['creation_date'];
        }

        //Create new Category
        public function create(){
            //Create query
            $query = 'INSERT INTO' . $this->table . '(name)VALUE(:name)';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->name = htmlspecialchars(strip_tags($this->name));

            //Bind parameters
            $stmt->bindParam(':name', $this->name);

            //Execute statement
            if($stmt->execute()){
                return true;
            }
            printf('Error $s.\n', $stmt->error);
            return false;

    }

    //Update Category
    public function update(){
        //Create query
        $query = 'UPDATE' . $this->table . 'SET name = :name WHERE id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        //Execute statement
        if($stmt->execute()){
            return true;
        }
        printf('Error $s.\n', $stmt->error);
        return false;

}


    //Delete Category
    public function delete(){
        //Create query
        $query = 'DELETE FROM' . $this->table . 'WHERE id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind parameters
        $stmt->bindParam(':id', $this->id);

        //Execute statement
        if($stmt->execute()){
            return true;
        }
        printf('Error $s.\n', $stmt->error);
        return false;

}
}