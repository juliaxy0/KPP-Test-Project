<?php
session_start();
require_once "pdo.php";

// FORM VALIDATION
if(isset($_POST['register'])){

    $_SESSION['oldName'] = $_POST['name'];
    $_SESSION['oldEmail'] = $_POST['email'];

  if(strlen($_POST['name']) < 1){
    $_SESSION['message'] = "Insert your name.";
  }
  elseif(strlen($_POST['email']) < 1){
    $_SESSION['message'] = "Insert your email";
  }
  elseif (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "Please enter a valid email";
  }
  elseif (strlen($_POST['password']) < 1) {
    $_SESSION['message'] = "Input your password";
  }
  elseif (strlen($_POST['confirm-password']) < 1){
    $_SESSION['message'] = "Input confirm password";
  }
  elseif($_POST['password'] != $_POST['confirm-password']){
    $_SESSION['message'] = "Password not matched";
  }
  else {
    $sql = "SELECT email FROM admin WHERE email = :em";
    $stmt = $pdo -> prepare($sql);
    $stmt->execute(array(
      ':em' => $_POST['email']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row != 0){
      $_SESSION['message'] = "Email has been already registered.";
    }
    else {

      $salt = '$1$rasmusle$';
      $usersPassword = $_POST['password'];
      $hash = crypt( $usersPassword , $salt );

      $sql = "INSERT INTO admin (email, name, password) VALUES (:em, :name, :password)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':em' => $_POST['email'],
        ':name' => $_POST['name'],
        ':password' => $hash
      ));

      $_SESSION['message'] = 'Successfully registered!';
    }
  }
}
 ?>
<html lang="en" dir="ltr">
  <head>
    <style>
		h1{
        text-align:center;
        color: #c93636;
				font-family: 'Titillium Web', sans-serif;
        font-size: 40px;
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
        height: 500px;
        border-radius: 25px;
        padding : 20px;

      }
			.error{
				display: grid;
        place-items: center;
        font-size: 15px;
			}
      input[type=text] {
        border-radius: 25px;
        margin: 10px;
        text-align:center;
        width : 300px;
        font-size: 18px;
      }
      input[type=password] {
        border-radius: 25px;
        margin: 10px;
       text-align:center;
       width : 300px;
       font-size: 18px;
      }
      input[type=submit]{
        box-shadow: 2px 2px 5px grey;
        border: none;
        background-color: #c93636;
        color: white;
        font-weight: bold;
        width: 100px;
        height: 25px;
        border-radius: 5px;
        margin : 10px;
        font-size: 15px;
      }

      .centered {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);

      }

    </style>
		<link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">
		<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@700&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <title></title>
  </head>

  <body>
        <?php
        $oldName = isset($_SESSION['oldName']) ? $_SESSION['oldName'] : "";
        $oldEmail = isset($_SESSION['oldEmail']) ? $_SESSION['oldEmail'] : "";
         ?>
       <div class="centered">

        <div class="form">
        <h1>Register New Admin</h1>
        <img src="jpj.png" alt="JPJ Logo" style="width:100px;height:100px;">
          <div class="error">
            <?php
            if ( isset($_SESSION['message']) ) {
              echo '<p style="color:green">'.$_SESSION['message']."</p>\n";
              unset($_SESSION['message']);}
              ?>
          </div>

          <form method="post">
            <table>
              <tr>
                <td> <input type="text" name="name" placeholder="your name" value= "<?= htmlentities($oldName)?>"></td>
              </tr>
              <tr>
                <td> <input type="text" name="email" placeholder="your email" value="<?= htmlentities($oldEmail)?>"> </td>
              </tr>
              <tr>
                <td> <input type="password" name="password" placeholder="your password" value=""> </td>
              </tr>
              <tr>
                <td> <input type="password" name="confirm-password" placeholder="re-enter your password" value=""> </td>
              </tr>
              <tr>
                <td  style="text-align:center"> <input type="submit" name="register" value="Register"> </td>
              </tr>
            </table>

            <div style="margin:15px;">
              <p>Already have an account? <a href="login_admin.php"> Login here</a></p>
            </div>
          </form>
        </div>
      </div>
  </body>
</html>
