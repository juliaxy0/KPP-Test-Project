<?php


require_once "pdo.php";

$stmt = $pdo->query("SELECT questions.question, chooseans.ans1, chooseans.ans2, chooseans.ans3 FROM questions
  inner join chooseans on chooseans.question_no = questions.question_no where questions.question_no = ".$_GET['question_no']);

while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

  $q = $row["question"];
  $a1 = $row["ans1"];
  $a2 = $row["ans2"];
  $a3 = $row["ans3"];


}
  $content = '

                <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Update Questions</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                      <div class="box-body">
                      <div class="form-group">
                        <label for="question">Question No</label>
                        <input type="text" class="form-control" id="question_no" name="question" value="'.$_GET['question_no'].'" placeholder="Enter Question" readonly>
                        <label for="question">Question</label>
                        <input type="text" class="form-control" id="question" name="question" value="'.$q.'" placeholder="Enter Question">
                        <label for="ans1">Real answer</label>
                        <input type="text" class="form-control" id="ans1" name="ans1" value="'.$a1.'"  placeholder="Enter Answer">
                        <label for="ans2">Other option</label>
                        <input type="text" class="form-control" id="ans2" name="ans2" value="'.$a2.'"  placeholder="Enter Option 2">
                        <label for="ans3">Other option</label>
                        <input type="text" class="form-control" id="ans3" name="ans3" value="'.$a3.'"placeholder="Enter Option 3">
                      </div>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <input type="button" class="btn btn-primary" onClick="UpdateQuestion()" value="Update"></input>
                      </div>
                    </form>
                  </div>
                  <!-- /.box -->
                </div>
              </div>';

  include('./master.php');



?>
<script>

    function UpdateQuestion(){
        $.ajax(
        {
            type: "POST",
            url: './api/question/update.php',
            dataType: 'json',
            data: {
                question_no: $('#question_no').val(),
                question: $("#question").val(),
                ans1 : $('#ans1').val(),
                ans2 : $('#ans2').val(),
                ans3 : $('#ans3').val(),
            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Successfully Updated Question!");
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
</script>
