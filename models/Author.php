<?php
class Author {
//DB Stuff
    private $conn;
    private $table = 'authors';

    //Properties
    public $id;
    public $author;

    //Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    //Get authors
    public function read() {
        //Create query
        $query = "SELECT
        id,
        author
        FROM 
        ".$this->table."
        ORDER BY 
        id ASC";
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        //Execute query
        $stmt->execute();
        return $stmt;
    }

    //Get Single Author
    public function read_single(){
        //Create query
        $query = "SELECT
        id,
        author
        FROM 
        ".$this->table."
        WHERE 
        id = :id";
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);
/*         //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id)); */
        //Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        // Retrieve data from query set into variables
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $numRow = $stmt->rowCount();

        if($numRow > 0){
            $this->id = $row['id'];
            $this->author = $row['author'];
    } return $numRow;
}

    //Create Author       
    public function create() {
        $query = "INSERT INTO 
        ".$this->table." 
        (author) 
        VALUES
        (:author)";

        //Prepare statement
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));
        //Bind data
        $stmt->bindParam(':author', $this->author);
        //Execute query
        if ($stmt->execute()) { 
            $this->id = $this->conn->lastInsertId();
            return true;
        } else {
            printf("Error: %s. \n", $stmt->error);
            return false;
        }     
    }

    //Update Author
	public function update() {
        //Create query
        $query ="UPDATE 
        ".$this->table." 
        SET 
        author = :author 
        WHERE 
        id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //Bind data
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);
        //Execute query
        if ($stmt->execute()) {  
            return true;
        } else {
            printf("Error: %s. \n", $stmt->error);
            return false;
        }   
    }

    //Delete Author
	public function delete() {
        //Create query
        $query ="DELETE 
        FROM 
        ".$this->table." 
        WHERE 
        id = :id";
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        //Bind data
        $stmt->bindParam(':id', $this->id);
        //Execute query
        if ($stmt->execute()) { 
            return true;
        } else {
            printf("Error: %s. \n", $stmt->error);
            return false;
        }                     
    }
}
?>