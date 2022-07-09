<?php
class Question{

    // database connection and table name
    private $conn;
    private $table_name = "questions";
    private $table_name2 = "persons_result";

    // object properties
    public $question_no;
    public $question;
    public $ic;
    public $result;
    public $status;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read all doctors
    function read(){

        // select all query
        $query = "SELECT
                    `question_no`, `question`
                FROM
                    " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // read all doctors
    function readResult(){

        // select all query
        $query = "SELECT
                      `ic`, `result`, `status` FROM " . $this->table_name2;

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
                        (question)
                  VALUES
                        ('".$this->question."');

                  INSERT INTO ANSWERS (answer_id,answer,question_no) values (
                    (select question_no from questions where question = '".$this->question."'),
                    '".$this->ans1."',
                    (select question_no from questions where question = '".$this->question."')
                  );

                  UPDATE QUESTIONS SET answer_id = (select question_no from questions where question = '".$this->question."') where question_no = (select question_no from questions where question = '".$this->question."');

                  INSERT INTO CHOOSEANS ( ANS1, ANS2, ANS3, ANSWER_ID, QUESTION_NO )
                  VALUES ('".$this->ans1."', '".$this->ans2."', '".$this->ans3."', (select question_no from questions where question = '".$this->question."'), (select question_no from questions where question = '".$this->question."'));
                  ";
        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    // update doctor
    function update(){

        // query to insert record
        $query = "UPDATE QUESTIONS
                SET
                    question='".$this->question."'
                WHERE
                    question_no=".$this->question_no.";

                UPDATE ANSWERS
                  SET answer = '".$this->ans1."'
                  where answer_id=".$this->question_no.";

                UPDATE chooseans
                  set ans1 = '".$this->ans1."',
                  ans2 = '".$this->ans2."',
                  ans3 = '".$this->ans3."'
                    where answer_id=".$this->question_no.";

                    ";

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
        $query = "

        DELETE FROM CHOOSEANS WHERE question_no = '".$this->question_no."';
        DELETE FROM ANSWERS WHERE question_no = '".$this->question_no."';
        DELETE FROM ".$this->table_name." WHERE question_no= '".$this->question_no."'";

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
