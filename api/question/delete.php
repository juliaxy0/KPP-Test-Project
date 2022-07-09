<?php

// include database and object files
include_once '../config/database.php';
include_once '../objects/question.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare doctor object
$question = new Question($db);

// set doctor property values
$question->question_no = $_POST['question_no'];

// remove the doctor
if($question->delete()){
    $question_arr=array(
        "status" => true,
        "message" => "Successfully Removed!"
    );
}
else{
    $question_arr=array(
        "status" => false,
        "message" => "Question Cannot be deleted!"
    );
}
print_r(json_encode($question_arr));
?>
