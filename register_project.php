<?php
session_start();
require "pdo.php";
$ic = isset($_POST['ic']) ? $_POST['ic'] : '';
if(isset($_POST['Cancel'])){
  header('Location: index2.php');
  return;
}
if(isset($_POST['ic']) && is_numeric($_POST['ic']) && strlen($_POST['ic'])==12 ){
  if(isset($_POST['gender'])){
     // $stmt = $pdo->query("SELECT COUNT(ic) AS ic FROM persons_data");
     // $row = $stmt->fetch(PDO::FETCH_ASSOC);
     $_SESSION['ic'] = $_POST['ic'];
     $_SESSION['gender'] = $_POST['gender'];
     $sql = "INSERT INTO persons_data (ic, gender) VALUES (:ic, :gender)";
     $stmt = $pdo->prepare($sql);
     $stmt->execute(array(
       ':ic' => $_SESSION['ic'],
       ':gender' => $_POST['gender']
     ));
     // $_SESSION['ic']=$ic;
     header('Location: Qsection1.php');
  }
  else{
    $invalid_message = "Sila pilih jantina";
  }
}
else if (isset($_POST['ic']) && (!is_numeric($_POST['ic']) || strlen($_POST['ic'])!=12)){
  $invalid_message = "Nombor IC tidak sah";
}
else{
  $invalid_message = "Sila masukkan butiran diri";
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr" style = "height: 100%;">
  <head>
      <link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@700&display=swap" rel="stylesheet">
    <style media="screen">
    h1{
        text-align:center;
        color: #c93636;
				font-family: 'Titillium Web', sans-serif;
				font-size: 38px;
      }
		body{
			background-color: #c93636;
			font-family: 'Quicksand', sans-serif;
      font-weight: 300;
			height: 100%;
		  background-position: center;
		  background-repeat: no-repeat;
		  background-size: cover;
		}
		.form{
			display: grid;
			place-items: center;
			background-color: white;
			width: 500px;
			height: 450px;
			border-radius: 25px;
			padding : 20px;
      }
			.error{
				display: grid;
        place-items: center;
				font-size: 15px;
			}
			input[type=submit]{
        box-shadow: 2px 2px 5px grey;
        border: none;
        background-color: #c93636;
        color: white;
        font-weight: bold;
        width: 100px;
        height: 30px;
        border-radius: 5px;
        margin : 10px;
        font-size: 15px;
        text-align:center;
        margin:10px;
        position: relative;
        left:20%;



      }

			input[type=text] {
				border-radius: 25px;
				margin: 10px;
				text-align:center;
				width : 300px;
				font-size: 18px;
			}
			.centered {
				position: absolute;
				left: 50%;
				top: 50%;
				-webkit-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);

			}
    img {

    width:110px;
    height:110px;
  }
    </style>

    <meta charset="utf-8">
    <title>Start Questionnaire</title>
  </head>
  <body >
    <div class="centered">
      <div class="form";>
    <h1>Selamat Datang ke Ujian KPP 2022  </h1>
    <img src="jpj.png" alt="logo JPJ" >

    <h2 class="error"><?php echo $invalid_message ?></h2>
    <form method="post" >
      <table>
        <tr>
          <td>IC Number :</td>
          <td> <input type="text" name="ic" value="<?php echo htmlentities($ic)?>"> </td>
        </tr>
        <tr>
          <td>Gender :</td>
          <td>
            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label>
          </td>
        </tr>
      <br>

      </table>

        <input type="submit" name= "Cancel" value="Cancel">
        <input type="submit" name = "Register" value="Register">

    </form>
  </div>
</div>
  </body>
</html>
