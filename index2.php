<?php
session_start();
require "pdo.php";
if(isset($_POST['Start'])){
  header('Location: register_project.php');
  return;
}
if(isset($_POST['Login'])){
  header('Location: login_admin.php');
  return;
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr" style = "height: 100%;">
  <head>
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@700&display=swap" rel="stylesheet">
    <style>
    h1{
        text-align:center;
        color: #c93636;
        font-family: 'Titillium Web', sans-serif;
        font-size: 40px;
        margin: auto;
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

      input[type=submit]{
        box-shadow: 2px 2px 5px grey;
        border: none;
        background-color: #c93636;
        color: white;
        font-weight: bold;
        width: 200px;
        height: 40px;
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
    <meta charset="utf-8">
    <title>Login Page</title>
  </head>
  <body>
    <div class="centered" >
      <div class="form">
    <h1>Selamat Datang ke Ujian KPP 2022 </h1>
     <img src="jpj.png" alt="jpj" >
    <form method="post" >
      <table>
        <tr>
          <td> <input type="submit" name= "Login" value="Admin? Login here"></td>
          <td> <input type="submit" name = "Start" value="Mula Menjawab!"> </td>
        </tr>
      </table>
    </form>
  </div>
  </div>
  </body>
</html>
