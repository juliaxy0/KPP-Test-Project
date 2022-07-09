<?php
session_start();
require "pdo.php";
if(isset($_POST['return'])){
  // session_unset();
  $_SESSION['totalAns'] = 0;
  $_SESSION['finalResult'] = "FAIL";
  $_SESSION["ic"] = "";
  session_destroy();
  header('Location: index2.php');
}
// $totalAns = 0;
// $finalResult= "FAIL";
$stmt = $pdo->query("SELECT answer_id FROM persons_ans");
// $data1 = array();
// $data2 = array();
$ic = $_SESSION['ic'];
$stmt1 = $pdo->query("SELECT count(*) FROM answers INNER JOIN persons_ans ON answers.answer_id = persons_ans.answer_id WHERE persons_ans.ic = $ic and ans_choice = answer");
while ( $row = $stmt1->fetch(PDO::FETCH_ASSOC) ) {
  $totalAns = $row['count(*)'];
  // $data1[] = $row['answer'];
  // $data2[] = $row['ans_choice'];
}

if ($totalAns == 10){
   $finalResult = "PASS";
}
else
  $finalResult = "FAIL";


$sql = "INSERT INTO persons_result (ic, result, status) VALUES (:ic, :result, :status)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
  ':ic' => $_SESSION['ic'],
  ':result' => $totalAns,
  ':status'=> $finalResult
));
 ?>
<!DOCTYPE html>
<html style = "font-family: 'Titillium Web', sans-serif;">
   <head>
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@700&display=swap" rel="stylesheet">
      <title>KPP group kami</title>
      <script type = "text/javascript" src = "jquery.min.js">
      </script>
      <style>
      h1{
          text-align:center;
          color: white;
          text-shadow: 3px 3px gray;
  				font-family: 'Titillium Web', sans-serif;
          font-size:60px;
        }
      table {
        border-collapse: collapse;
        width: 100%;
      }
      th, td {
        text-align: left;
        padding: 8px;
      }
      .center {
        margin: auto;
        width: 50%;
        padding: 10px;
      }
      .row {
        display: flex;
        border-radius: 25px; /* equal height of the children */
      }

      .col {
        flex: 2;
        border-radius: 35px; /* additionally, equal width */
        padding: 1em;
        border: solid;
        margin:1em;
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
      }
      tr:nth-child(even){background-color:white}
      tr:nth-child(odd){background-color:#fff3f2}
      th {
        background-color:#5c0a03;
        color: white;
      }
      </style>
   </head>
   <body style="text-align:center;background-color:#c93636;">
     <h1>Total Marks / Result</h1>
       <script type = "text/javascript" src = "jquery.min.js">
       </script>
        <br>
        <div>
        <table>
          <tr>
            <th>Total Marks</th>
            <th>Pass/Fail</th>
          </tr>
          <tr>
            <td><?php echo $totalAns ?></td>
            <td><?php echo $finalResult ?></td>
          </tr>
        </table>
      </div>
      <p>Soalan ini menentukan keputusan Ujian Buta Warna anda.<br> Markah keputusan ialah 10 menandakan anda lulus!</p>
      <div class="row">
        <br>
        <br><br>
        <div class = "col" style="margin-left:18em; background-color:#e0dddc; width:300px;display:inline-block">
          <img src="jpj.png" style="width:100px; height:100px;">
                    <p><b>Hubungi Kami: </b></p>
                    <p>+60 3 8000 8000 (Umum)</p>
                    <p>+60 3 8881 0194 (Faks)</p>
                    <p>Address: </p>
                    <p>Jabatan Pengangkutan Jalan<br>
                      Aras 3-5, No. 26,<br>
                      Jalan Tun Hussien, Presint 4,<br>
                      Pusat Pentadbiran Kerajaan Persekutuan,<br>
                      62100 WP Putrajaya</p>
        </div>
        <div class = "col" style="margin-right:18em; background-color:#e0dddc; width:300px;display:inline-block">
          <br>
          <h4 style="font-size:20px;">Jabatan Pengangkutan Jalan Malaysia</h4>
          <br>
                    <p>Jabatan Pengangkutan Jalan (JPJ) telah ditubuhkan pada tahun 1937, di bawah Enakmen Lalulintas 1937. Undang-undang tentera British di Negeri-negeri Melayu Bersekutu. Pentadbirannya pada ketika itu dikenali sebagai Lembaga Pengangkutan Jalan yang berfungsi mengawal dan melesenkan perusahaan awam. Dengan wujudnya pentadbiran Tanah Melayu pada April 1946, kuasa lembaga tersebut telah diambil alih oleh Pejabat Pendaftar dan Pemeriksaan Kereta-kereta Motor yang merangkumi seluruh Tanah Melayu.</p>
        </div>

      </div>
      <br><br>
      <form method="post" >
            <input class = "button" type="submit" name= "return" value="Do Another Test" >
      </form>
   </body>
</html>
