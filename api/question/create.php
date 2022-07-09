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
$question->question = $_POST['question'];
$question->ans1 = $_POST['ans1'];
$question->ans2 = $_POST['ans2'];
$question->ans3 = $_POST['ans3'];

// create the doctor
if($question->create()){
    $question_arr=array(
        "status" => true,
        "message" => "Successfully Added!",
        "question" => $question->question,
        "ans1" => $question->ans1,
        "ans2" => $question->ans2,
        "ans3" => $question->ans3,
    );
}
else{
    $question_arr=array(
        "status" => false,
        "message" => "Question already exists!"
    );
}
print_r(json_encode($question_arr));
?>
