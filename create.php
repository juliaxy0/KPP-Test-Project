<?php
  $content = '<div class="row">
                <!-- left column -->
                <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Add Question</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                      <div class="box-body">
                        <div class="form-group">
                          <label for="question">Question</label>
                          <input type="text" class="form-control" id="question" name="question" placeholder="Enter Question">
                          <label for="ans1">Answer 1</label>
                          <input type="text" class="form-control" id="ans1" name="ans1" placeholder="Enter Option 1">
                          <label for="ans2">Answer 2</label>
                          <input type="text" class="form-control" id="ans2" name="ans2" placeholder="Enter Option 2">
                          <label for="ans3">Answer 3</label>
                          <input type="text" class="form-control" id="ans3" name="ans3" placeholder="Enter Option 3">
                        </div>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <input type="button" class="btn btn-primary" onClick="AddQuestion()" value="Submit"></input>
                      </div>
                    </form>
                  </div>
                  <!-- /.box -->
                </div>
              </div>';
  include('./master.php');
?>
<script>
  function AddQuestion(){

        $.ajax(
        {
            type: "POST",
            url: './api/question/create.php',
            dataType: 'json',
            data: {
                question: $("#question").val(),
                ans1: $("#ans1").val(),
                ans2: $("#ans3").val(),
                ans3: $("#ans3").val(),

            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Successfully Added New Question!");
                    window.location.href = '/KPP/index.php?name=<?php echo $_GET['name'] ?>';
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
</script>
