<?php
require_once "pdo.php";
//session_start();

if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1 ) {
  die('Please login first');
}

$content = '<div class="row">
              <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Questions List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="questions" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Question ID</th>
                      <th>Question</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
          </div>';

include('./master.php');

?>

  <script>
    $(document).ready(function(){
      $.ajax({
          type: "GET",
          url: "./api/question/read.php",
          dataType: 'json',
          success: function(data) {
              var response="";
              for(var i in data){

                  response += "<tr>"+
                  "<td>"+ (parseInt(i)+1) +"</td>"+
                  "<td>"+data[i].question+"</td>"+
                  "<td><a href='update.php?name=<?php echo $_GET['name'] ?>&question_no="+data[i].question_no+"'>Edit</a> | <a href='#' onClick=Remove('"+data[i].question_no+"')>Remove</a></td>"+
                  "</tr>";
              }
              $(response).appendTo($("#questions"));
          }
      });
    });

    function Remove(question_no){
      var result = confirm("Are you sure you want to Delete the Record?");
      if (result == true) {
          $.ajax(
          {
              type: "POST",
              url: './api/question/delete.php',
              dataType: 'json',
              data: {
                  question_no: question_no
              },
              error: function (result) {
                  alert(result.responseText);
              },
              success: function (result) {
                  if (result['status'] == true) {
                      alert("Successfully Removed Question!");
                      window.location.href = '/KPP/index.php?name=<?php echo $_GET['name'] ?>';
                  }
                  else {
                      alert(result['message']);
                  }
              }
          });
      }
    }

  </script>


<!-- echo('<table>'."\n");
$questionstmt = $pdo->query("SELECT question_no, question FROM questions");
$answerstmt = $pdo->query("SELECT answer_id, answer FROM answers, questions WHERE answers.question_no = questions.question_no");
while ( $qrow = $questionstmt->fetch(PDO::FETCH_ASSOC) ) {
  echo ('<tr><td rowspan ="5">');
  echo(htmlentities($qrow['question_no']));
  echo('</td><td rowspan="5">');
  echo(htmlentities($qrow['question']));
  echo('</td>');
  while ( $arow = $answerstmt->fetch(PDO::FETCH_ASSOC) ) {
    echo("<tr><td>");
    echo(htmlentities($arow['answer']));
    echo("</td></tr>");
  }
  echo('<td rowspan="5">');
  echo('<a href="edit.php?question_no='.$qrow['question_no'].'">Edit</a> / ');
  echo('<a href="delete.php?question_no='.$qrow['question_no'].'">Delete</a>');
  echo("</td></tr>\n");
}
?>
</table>
<a href="add.php">Add a new question and answers</a> -->
