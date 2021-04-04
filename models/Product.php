<?php

class Product{

    private $conn;
    private $table = 'products';

    //Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $description;
    public $creation_date;

    //Database connection constructor
    public function __construct($db){
        $this->conn = $db;
    }

    //Get Products
    public function read(){
        //Create query
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.description, p.creation_date  FROM' . $table . 'LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.creation_date DESC';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute statement
        $stmt->execute();
        return $stmt;
    }

    //Get one Product
    public function read_one(){
        //Create query
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.description, p.creation_date  FROM' . $table . 'LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind parameters
        $stmt->bindParam(1, $this->id);

        //Execute statement
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->description = $row['description'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
        $this->creation_date = $row['creation_date'];
    }

    //Create new Product
    public function create(){
        //Create query
        $query = 'INSERT INTO' . $this->table . '(title, description, category_id)VALUE(:title, :description, :category_id)';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //Bind parameters
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);

        //Execute statement
        if($stmt->execute()){
            return true;
        }
        printf('Error $s.\n', $stmt->error);
        return false;

}

//Update Product
public function update(){
    //Create query
    $query = 'UPDATE' . $this->table . 'SET title = :title, description = :description, category_id = :category_id WHERE id = :id';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    //Clean data
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->description = htmlspecialchars(strip_tags($this->description));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->id = htmlspecialchars(strip_tags($this->id));

    //Bind parameters
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':id', $this->id);

    //Execute statement
    if($stmt->execute()){
        return true;
    }
    printf('Error $s.\n', $stmt->error);
    return false;

}


//Delete Product
public function delete(){
    //Create query
    $query = 'DELETE FROM' . $this->table . 'WHERE id = :id';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    //Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    //Bind parameters
    $stmt->bindParam('id', $this->id);

    //Execute statement
    if($stmt->execute()){
        return true;
    }
    printf('Error $s.\n', $stmt->error);
    return false;

}
}