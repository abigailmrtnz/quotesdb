<?php
class Category {
//DB Stuff
    private $conn;
    private $table = 'categories';

    //Properties
    public $id;
    public $category;

    //Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    //Get categories
    public function readCategories() {
        //Create query
        $query = "SELECT
        id,
        category
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

    //Get Single Category
    public function read_singleCategory(){
        //Create query
        $query = "SELECT
        id,
        category
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
        $stmt->execute();
        // Retrieve data from query set into variables
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $numRow = $stmt->rowCount();

        if($numRow > 0){
            $this->id = $row['id'];
            $this->category = $row['category'];
        } return $numRow;

    }

    //Create Category        
    public function create() {
        $query = "INSERT INTO 
        ".$this->table."
        (category) 
        VALUES
        (:category)";

        //Prepare statement
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));
        //Bind data
        $stmt->bindParam(':category', $this->category);
        //Execute query
        if ($stmt->execute()) { 
            $this->id = $this->conn->lastInsertId();
            return true;
        } else {
            printf("Error: %s. \n", $stmt->error);
            return false;
        }     
    }

    //Update Category
	public function update() {
            //Create query
            $query ="UPDATE 
            ".$this->table." 
            SET 
            category = :category 
            WHERE 
            id = :id";

            //Prepare statement
            $stmt = $this->conn->prepare($query);
            //Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));
            //Bind data
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);
            //Execute query
            if ($stmt->execute()) { 
                    return true;
                } else {
                    printf("Error: %s. \n", $stmt->error);
                    return false;
                }   
            }   

    //Delete Category
	public function delete() {
        //Create query
        $query ="DELETE FROM 
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