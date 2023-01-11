<?php
session_start();
require_once "pdo.php";
require_once "Auth.php";
require_once "Util.php";

$auth = new Auth();
$util = new Util();



//if logged in
if ($isLoggedIn) {
		header("Location: index.php?name=".urlencode($_SESSION["name"]));
}

//after submit
if(isset($_POST['login'])){
	$_SESSION['oldEmail'] = $_POST['email'];
	$email = $_POST["email"];
	$password = $_POST["password"];

  if (strlen($email) < 1) {
    $_SESSION['message'] = "Please enter your email";
  }
  elseif (strlen($password) < 1) {
    $_SESSION['message'] = "Please enter your password";
  }
  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION['message'] = "Please enter valid email";
  }
  else{

		//checking email
    $sql = "SELECT email FROM admin WHERE email = :em";
    $stmt = $pdo -> prepare($sql);
    $stmt->execute(array(':em' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

			//email exist
    if($row != 0){

        $sql1 = "SELECT password  FROM admin where email = :em";
				$stmt1 = $pdo -> prepare($sql1);
				$stmt1->execute(array(':em' => $email));
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

				//checking password
				if($row1 != 0){
					$hashed = implode("",$row1);
					if (password_verify($password, $hashed)) {

						// Set Auth Cookies if 'Remember Me' checked
						if (! empty($_POST["remember"])) {
								setcookie("admin_login", $email, $cookie_expiration_time);

								$random_password = $util->getToken(16);
								setcookie("random_password", $random_password, $cookie_expiration_time);

								$random_selector = $util->getToken(32);
								setcookie("random_selector", $random_selector, $cookie_expiration_time);

								$random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
								$random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);

								$expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);

								// mark existing token as expired
								$adminToken = $auth->getTokenByEmail($email, 0);
								if (! empty($adminToken[0]["email"])) {
										$auth->markAsExpired($adminToken[0]["email"]);
								}
								// Insert new token
								$auth->insertToken($email, $random_password_hash, $random_selector_hash, $expiry_date);
						} else {
								$util->clearAuthCookie();
						}
						//carry name and enter index
						$sql2 = "SELECT name  FROM admin where email = :em";
						$stmt2 = $pdo -> prepare($sql2);
						$stmt2->execute(array(':em' => 	$email));
						$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
						$name = implode("",$row2);

						//remember me
						$_SESSION["name"] = $name;
						header("Location: index.php?name=".urlencode($name));
					}
	        else{
	          $_SESSION['message'] = "Incorrect password";
	        }
				}
    }
		//email not exist
    else {
      $_SESSION['message'] = "This email is not registered";
    }
  }
}
else{
  session_unset();
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
        height: 25px;
        border-radius: 5px;
				margin : 10px;
				font-size: 15px;
      }
			input[type=password] {
				border-radius: 25px;
				margin: 10px;
			 text-align:center;
			 width : 300px;
			 font-size: 18px;
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
    </style>
		<link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">
		<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@700&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <title>Login Page</title>
  </head>
  <body>
	    <?php
	    $message = isset($_SESSION['message']) ? $_SESSION['message'] : "";
	    $oldEmail = isset($_SESSION['oldEmail']) ? $_SESSION['oldEmail'] : "";
	     ?>
		<div class="centered">
			<div class="form">
				<h1>Admin Log In</h1>
				<img src="jpj.png" alt="JPJ Logo" style="width:100px;height:100px;">
					<div class="error">
						<p style="color: red;"> <?php echo $message; ?> </p>
					</div>

				<form method="post">
		      <table>
		        <tr>
		          <td> <input type="text" placeholder="your email" name="email" value="<?php
		          if(isset($_COOKIE['email'])) { echo $_COOKIE['email'];}
		          echo $oldEmail ?>"> </td>
		        </tr>
		        <tr>
		          <td> <input type="password" placeholder="your password" name="password" value="<?php
		          if(isset($_COOKIE['password'])) { echo $_COOKIE['password'];}
		           ?>"> </td>
		        </tr>
		        <tr>
		          <td  style="text-align:center;margin: 10px;"> <input type="checkbox" name="remember" <?php if(isset($_COOKIE["member_login"])) { ?> checked
							<?php } ?>> Remember me</td>
						</tr>
						<tr>
		          <td  style="text-align:center;margin: 10px;"> <input class="" type="submit" name="login" value="Log In"> </td>
		        </tr>
		      </table>

						<div class="error">
									<p>New here?<a href="register_admin.php"> Sign up!</a> </p>
						</div>

		    </form>
			</div>
	</div>
  </body>
</html>
