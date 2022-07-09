<?php
class Question{

    // database connection and table name
    private $conn;
    private $table_name = "questions";
    private $table_name2 = "answers";

    // object properties
    public $question_id;
    public $question;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read all doctors
    function read(){

        // select all query
        $query = "SELECT
                    `question_id`, `question`
                FROM
                    " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // get single doctor data
    function read_single(){

        // select all query
        $query = "SELECT
                    `question_id`, `question`
                FROM
                    " . $this->table_name . "
                WHERE
                    question_id= '".$this->question_id."'";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        return $stmt;
    }

    // create doctor
    function create(){

        if($this->isAlreadyExist()){
            return false;
        }

        // query to insert record
        $query = "INSERT INTO  ". $this->table_name ."
                        (`question_id`, `question`)
                  VALUES
                        ('".$this->question_id."', '".$this->question."')";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        if($stmt->execute()){
            $this->question_id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // update doctor
    function update(){

        // query to insert record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    question='".$this->question."'
                WHERE
                    question_id='".$this->question_id."'";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // delete doctor
    function delete(){

        // query to insert record
        $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    question_id= '".$this->question_id."'";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function isAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . "
            WHERE
                question='".$this->question."'";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}
