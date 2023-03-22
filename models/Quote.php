<?php
class Quote {
    //DB stuff
    private $conn;
    private $table = 'quotes';

    //Quote propeties
    public $id;
    public $quote;
    public $category_id;
    public $author_id;
    public $author;
    public $category;
    //Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    //Get Quote
    public function readQuotes() {
        $query = "SELECT
        p.id,
        p.quote,
        p.category_id,
        p.author_id,
        c.category AS category,
        a.author AS author_name
        FROM
        ".$this->table." p
        LEFT JOIN
        categories c ON p.category_id = c.id
        LEFT JOIN
        authors a ON p.author_id = a.id";

        if(!isset($this->author_id) && !isset($this->category_id)) {
            $query .= "WHERE
            p.author_id = :author_id
            AND
            p.category_id = :category_id";
        } else if(!isset($this->author_id)) {
            $query .= " WHERE
            p.author_id = :author_id";
        } else if(!isset($this->category_id)) {
            $query .= " WHERE
            p.category_id = :category_id";
        }
        $query .= " ORDER BY p.id";
        $stmt = $this->conn->prepare($query);

        if(!isset($this->author_id) && !isset($this->category_id)) {
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
        } else if(!isset($this->author_id)) {
            $stmt->bindParam(':author_id', $this->author_id);
        } else if(!isset($this->category_id)) {
            $stmt->bindParam(':category_id', $this->category_id);
        }
        //Execute query
        $stmt->execute();
        return $stmt;
    }


    //Get single Quote
    public function read_singleQuote(){
        //Create a query
        $query = "SELECT 
        p.id,
        p.quote,
        p.category_id,
        p.author_id,
        c.category AS category,
        a.author AS author
        FROM
        ".$this->table." p
        LEFT JOIN
        categories c ON p.category_id = c.id
        LEFT JOIN
        authors a ON p.author_id = a.id
        WHERE
        p.id = :id";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);
        // Bind Parameter to Query
        $stmt->bindParam(':id', $this->id);
        // Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $numRows = $stmt->rowCount();
        // Set Properties
        if($numRows > 0) {
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author_id = $row['author_id'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category = $row['category'];
        }
        return $numRows;
}

    //Create Quote
    public function create() {
        //Create a query
        $query = "INSERT INTO 
        ".$this->table." 
        (quote, 
        author_id, 
        category_id) 
        VALUES(:quote,
        :author_id,
        :category_id)";

        //Prepare statement
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        //Bind data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        //Execute query
        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
            } else {
                printf("Error: %s. \n", $stmt->error);
                return false;
        }   
    }

    //Update Quote
	public function update() {
        //create query
        $query ="UPDATE 
        ".$this->table." 
        SET 
        quote = :quote,
        author_id = :author_id,
        category_id = :category_id
        WHERE 
        id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        //Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        //Execute query
        if($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s. \n", $stmt->error);
            return false;
        }      
    }

    //Delete Quote
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
        if($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s. \n", $stmt->error);
            return false;
        }
    }
}
?>