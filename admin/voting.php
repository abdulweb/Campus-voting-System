<?php
require_once('inc/ensure_login.php');
    require('inc/connect.inc.php');
    $getPostID = $_POST['postID'];
    if (getPostID == '' || empty(getPostID) || getPostID == null) {
        header('Location:cast_vote.php');
    }
$session_Username = $_SESSION['isvoter'];
$candidtate_sql = mysqli_query($con, "select * from aspirant where post_id = '$getPostID'");

if (isset($_POST['castBtn'])) {
     $vID = $_POST['vID'];
    $candidateID = $_POST['candidateID'];
     $postID = $_POST['postID'];
     $voter_id = $_POST['voter_id'];
    if (empty($vID)) {
        echo "<script>alert('Verification Code field cant be empty')</script>";
    }
    elseif (empty($candidateID) || empty($postID)) {
        echo "<script>alert('Internal Error occur Please try again by re-login in')</script>";
    }
    else{
        $candidtate_rows_fetch = mysqli_query($con, "select * from registeration where email_id = '$voter_id'") or die(mysqli_error($con));
        $candidtate_rows = mysqli_fetch_assoc($candidtate_rows_fetch);
        if ($vID != $candidtate_rows['voter_id']) {
            echo "<script>alert('Wrong Verification Code')</script>";
        }
        else{
            $insert = mysqli_query($con, "INSERT INTO vote(post_id,candidate_id,voter_id,date_vote) Values('$postID','$candidateID','$voter_id','date_vote')") or die(mysqli_error($con));
            if (insert) {
                $_SESSION['Success_vote_message'] = "Vote casted Successful";
                header('Location:cast_vote.php');
            }
            else{
                $_SESSION['error_vote_message'] = "Vote casting Fail, Please again";
                header('Location:cast_vote.php');
            }
        }
    } 

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Voter Registration</title>

    <!-- Bootstrap -->
    <link href="./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="./vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="./vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="./vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="./vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="./vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="./vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="./build/css/custom.min.css" rel="stylesheet">
    <style>
        .control-label{
            text-align:left !important;
        }
    </style>
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">

        <?php
        include('inc/left_panel.inc.php');

        include('inc/top_nav.inc.php');



        ?>

        <div class="right_col" role="main">
            <div class="row">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Cast Your for Vote <?=$getPostID?></h2>
                        <br><hr>
                        <div class="clearfix"></div>


                        <div class="row">
                        <?php
                            if (mysqli_num_rows($candidtate_sql) < 1) {?>
                                <p class="text-danger text-center">No candidtae Register for this post. Contact Admin for more info</p>       
                         <?php 
                           }
                           else{ 
                                while ($rows = mysqli_fetch_assoc($candidtate_sql)) {?>
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <?=$rows['full_name']?>
                                        <form>
                                            <input type="hidden" name="postID" value="<?=getPostID?>">
                                            <input type="hidden" name="postID" value="<?=rows['sn']?>">
                                           <button class="btn btn-success btn-xs pull-right" type="button" data-toggle="modal"
                                                data-target="#myModal" onclick="preload_modal('<?= $rows['sn']?>', '<?= $getPostID?>','<?= $session_Username?>')">Vote</button>
                                        </form>
                                        
                                    </div>
                                    <div class="panel-body">
                                        <?php $passport = $rows['passport']; ?>
                                        <img src="<?=$passport?>" class="img img-circle" height="70">
                                        <div class="row">
                                            <div class="col-md-4"><strong>Full-Name</strong></div>
                                            <div class="col-md-8"><?=$rows['full_name']?></div>
                                            <div class="col-md-4"><strong>Faculty</strong></div>
                                            <div class="col-md-8"><?=$rows['faculty']?></div>
                                            <div class="col-md-4"><strong>Department</strong></div>
                                            <div class="col-md-8"><?=$rows['full_name']?></div>
                                            <div class="col-md-4"><strong>Course of Study</strong></div>
                                            <div class="col-md-8"><?=$rows['course_of_study']?></div>
                                            <div class="col-md-4"><strong>Level</strong></div>
                                            <div class="col-md-8"><?=$rows['level']?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                         }
                     }
                        ?>
                            
                        </div>
                    </div> 
                </div>
            </div>
        </div>

        <!-- Modal start here -->
          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title ">Verification Code</h4>
                </div>
                <div class="modal-body">
                 <form method="post" action="voting.php">
                     <div class="form-group">
                        <label class="control-label col-xs-12" for="first-name">Voter Identification code:</label>
                        <div class="col-xs-12">
                            <input type="text" name="vID" class="form-control col-xs-12" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="hidden" id="postID" name="postID" class="form-control col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="hidden" id="candidateID" name="candidateID" class="form-control col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="hidden" id="voterID" name="voter_id" class="form-control col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                         <div class="col-xs-12">
                             <button class="btn btn-success" type="submit" name="castBtn">Cast Vote</button>
                         </div>
                        
                    </div>

                 </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
              
            </div>
          </div>
          <!-- Modal start here -->
        <?php
        include('inc/footer.inc.php');
        ?>
    </div>
</div>

<!-- jQuery -->
<script src="./vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="./vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="./vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="./vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="./vendors/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="./vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="./vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="./vendors/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="./vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="./vendors/Flot/jquery.flot.js"></script>
<script src="./vendors/Flot/jquery.flot.pie.js"></script>
<script src="./vendors/Flot/jquery.flot.time.js"></script>
<script src="./vendors/Flot/jquery.flot.stack.js"></script>
<script src="./vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="./vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="./vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="./vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="./vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="./vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="./vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="./vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="./vendors/moment/min/moment.min.js"></script>
<script src="./vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="./vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="./vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="./vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="./vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="./vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="./vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="./vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="./vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="./vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="./vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="./vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="./vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="./vendors/jszip/dist/jszip.min.js"></script>
<script src="./vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="./vendors/pdfmake/build/vfs_fonts.js"></script>

<!-- Custom Theme Scripts -->
<script src="./build/js/custom.min.js"></script>
<script type="text/javascript">
    function preload_modal(id,postID,voter_id) {
        $('#postID').attr('value', postID);
        $('#candidateID').attr('value', id);
        $('#voterID').attr('value', voter_id);
    }
</script>
</body>
</html>