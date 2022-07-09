<?php
session_start();
require "pdo.php";
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
if(isset($_POST['save'])){
  for($i = 1;$i<=10;$i++){
    if (!isset($_POST[$i])) {
      $_POST['invalid'] = true;
      break;
    }
  }
  if(isset($_POST['invalid'])){
    $_SESSION['message'] = "Please answer all questions";
    header('Location: Qsection1.php');
  }
  else{
    $count = $_SESSION['questionsCount'];
  for($i = 0;$i<$count;$i++){
    $m = $i+1;
    $sql = "INSERT INTO persons_ans (ic, answer_id, ans_choice) VALUES (:ic, :answer_id, :ans_choice)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':ic' => $_SESSION['ic'],
      ':answer_id' => $m,
      ':ans_choice' => $_POST[$m]
    ));
    header('Location: resultspage.php');
  }
}
}

 ?>

<html lang="en" dir="ltr">
  <head>
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@700&display=swap" rel="stylesheet">
    <style>
    h1{
        text-align:center;
        color: white;
        text-shadow: 3px 3px gray;
				font-family: 'Titillium Web', sans-serif;
        font-size: 60px;
      }
    h3{
      text-align:center;
    }
    .button{
      background-color:white;
      border-radius: 15px;
      color: black;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
      box-shadow: 2px 2px 5px grey;
    }
    body{
      font-family: 'Quicksand', sans-serif;
      font-weight: 500;
      background-color: #c93636;

    }
    .container1{
        display: grid;
        background-color: white;
        width: 600px;
        border-radius: 5px;
        margin: auto;
        padding-left: 3em;
      }

      .centered {
        position: absolute;
        left: 50%;
        top: 20%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);

      }
      .center {
  display: block;
  margin-left: 30%;
  margin-right: auto;
}
.topleft {
  position: absolute;
  top: 8px;
  left: 20px;
  font-size: 18px;
}
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script>


</script>
    <meta charset="utf-8">
    <title>Login Page</title>
  </head>

  <body>

    <h1>Answer all questions</h1>
    <img src="https://www.jpj.gov.my/documents/35811/55212/JPJLogo.png/714b179a-c90d-4b9c-aa0c-281973c47c21?t=1493397888610" class="topleft" alt="jpj logo" width="100" height="100">
    <h3 style = "color:black"><?php echo $message ?></h3>

    <form method = "post">
      <div class="container1">
        <?php
        require "pdo.php";
        // $questions = [][];
        $questionsCounter = 0;
        // $answersCounter = 0;
        $stmt = $pdo->query("SELECT * FROM questions ");
        while ( $question = $stmt->fetch(PDO::FETCH_ASSOC) ) {
          $questions[$questionsCounter] = $question['question'];
          $pic[$questionsCounter] = "<img src='data:image/png;base64,".base64_encode($question['picture'])."'>";
          $stmt1 = $pdo->query("SELECT * FROM chooseans where question_no = $questionsCounter+1");
          while ( $answer = $stmt1->fetch(PDO::FETCH_ASSOC) ) {
            $answers[$questionsCounter][0] = $answer["ans1"];
            $answers[$questionsCounter][1] = $answer["ans2"];
            $answers[$questionsCounter][2] = $answer["ans3"];
            // $answers[$questionsCounter][$answersCounter] = $answer["ans1"];
            $answersID[$questionsCounter][0] = $answer["answer_id"];
            $answersID[$questionsCounter][1] = $answer["answer_id"];
            $answersID[$questionsCounter][2] = $answer["answer_id"];
            //$answersRating[$questionsCounter][$answersCounter] = $answer["rating"];
            // ++$answersCounter;
          }
          // $answersCounter = 0;
          ++$questionsCounter;
        }
        $k = 0;
        $l = 1;
        $_SESSION['questionsCount'] = count($answers);
        echo "<br><br>";
          for($i = 0; $i < count($answers);$i++){
            $no = $i + 1;
            // $q = $questions[$i][0];
            // $pic = $questions[$i][1];
            echo "<div class=\"center\">";
            echo $pic[$i];
            echo "</div>";
            echo "<br><p>$no.   $questions[$i]</p>";
            for($j = 0; $j < count($answers[$i]); $j++){
          $value = $answers[$i][$j];
          $answerID = $answersID[$i][$j];
          //$rating = $answersRating[$i][$j];
          $k = $i+1;
          echo "<p><input type=\"radio\" name=\"$k\" value=\"$value\" </p>";
          echo "<label for=\"$value\">$value</label></p>";
        }
        echo "<br><br>";
      }
         ?>
      </div>
     <br>
     <input class = "button" type="submit" name="save" value="Submit Answer" style = "margin:auto;display:block;">
   </form>
  </body>
</html>
