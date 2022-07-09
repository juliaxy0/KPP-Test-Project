<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/question.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare doctor object
$result = new Question($db);

// query doctor
$stmt = $result->readResult();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
    // doctors array
    $result_arr=array();
    $result_arr["result"]=array();

    while ($qrow = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($qrow);
        $result_item=array(
          "ic" => $ic,
          "result" => $result,
          "statuss" => $status,
        );
        array_push($result_arr["result"], $result_item);
    }

    echo json_encode($result_arr["result"]);
}
else{
    echo json_encode(array());
}
?>
