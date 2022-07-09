<?php
// include database and object files
include_once './config/database.php';
include_once './objects/question.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare doctor object
$question = new Question($db);

// query doctor
$stmt = $question->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){

    // doctors array
    $question_arr=array();
    $question_arr["question"]=array();

    while ($qrow = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($qrow);
        $question_item=array(
          "question_no" => $question_no,
          "question" => $question,
        );
        /*while ( $arow = $answerstmt->fetch(PDO::FETCH_ASSOC) ) {
          $answer_item=array(
            "answer_id" => $answer_id,
            "answer" => $answer,
          )
          array_push($answer_arr["answer"], $answer_item);
        }*/
        array_push($question_arr["question"], $question_item);
    }

    echo json_encode($question_arr["question"]);
}
else{
    echo json_encode(array());
}
?>
