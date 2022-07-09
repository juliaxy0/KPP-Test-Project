<?php
require_once "pdo.php";
//session_start();

$content = '<div class="row">
              <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Questions List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="result" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Identification Card Number</th>
                      <th>Result</th>
                      <th>Status</th>
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
          url: "./api/question/readResult.php",
          dataType: 'json',
          success: function(data) {
              var response="";
              for(var i in data){

                  response += "<tr>"+
                  "<td>"+ (parseInt(i)+1) +"</td>"+
                  "<td>"+data[i].ic+"</td>"+
                  "<td>"+data[i].result+"</td>"+
                  "<td>"+data[i].statuss+"</td>"+
                  "</tr>";
              }
              $(response).appendTo($("#result"));
          }
      });
    });
</script>
