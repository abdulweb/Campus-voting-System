<?php
require_once('inc/ensure_login.php');
    require('inc/connect.inc.php');
$session_Username = $_SESSION['isvoter'];
$election_date_sql = mysqli_query($con, "select * from election_date");

function checkVote($voter_id,$post_id){
    Global $con;
    $check_vote = mysqli_query($con, "select * from vote where voter_id = '$voter_id' and post_id = '$post_id'");
    if (mysqli_num_rows($check_vote) > 0) {
        return 1;
    }
    else{
        return 0;
    }
}
function voteCasted($post_id){
    Global $con;
    $vote_casted = mysqli_query($con, "select * from vote where post_id = '$post_id'");
    if (mysqli_num_rows($vote_casted) > 0) {
        return mysqli_num_rows($vote_casted);
    }
    else{
        return 0;
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
                        <h2>Cast Vote</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        <?php
                             $currendate = date('Y-m-d');
                          $row = mysqli_fetch_assoc($election_date_sql);
                            if (mysqli_num_rows($election_date_sql) < 1) {?>
                               <p style="color: red">Sorry Election Date has not been Set</p>
                          <?php  }
                         
                          elseif (strtotime($row['end_date']) < strtotime($currendate)) {?>
                              <p style="color: red; text-align: center; font-weight: bold; ">Sorry Election Date has been closed!!!</p>
                              <marquee style="color: red">Election Closed!!!</marquee>
                          <?php
                      }
                      else{?>

                             <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Candidate Position</h2>

                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <p class="text-muted font-13 m-b-30">
                                    Check the Candidate Position to cast your vote. You can click on the vote button to cast vote for a position.
                                </p>
                                <div>
                                    <?php
                                        if (!empty($_SESSION['Success_vote_message'])) {
                                            ?>
                                            <div class="alert alert-success">
                                              <strong>Success!</strong> <?=$_SESSION['Success_vote_message']?>.
                                            </div>
                                      <?php  }
                                        if (!empty($_SESSION['error_vote_message'])) {?>
                                            <div class="alert alert-danger">
                                              <strong>Error!</strong> <?=$_SESSION['error_vote_message']?>.
                                            </div>
                                      <?php  }
                                    ?>
                                </div>

                                <div id="datatable_wrapper"
                                     class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="datatable"
                                                   class="table table-striped table-bordered dataTable no-footer"
                                                   role="grid" aria-describedby="datatable_info">
                                                <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Position Name</th>
                                                    <th>Status</th>
                                                    <th>Accredited vote</th>
                                                    <th>Action</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $post_sql = mysqli_query($con,"select * from post");
                                                    
                                                    // if (mysql_num_rows($election_date_sql >0)) {
                                                        $counter =1;
                                                        while ($post_sql_row = mysqli_fetch_assoc($post_sql)) {
                                                            ?>
                                                        <tr>
                                                        <td><?php echo $counter; ?></td>
                                                        <td><?php echo $post_sql_row['post_name']; ?></td>
                                                        <td><p style="color: green">On Going</p></td>
                                                        <td><?=voteCasted($post_sql_row['sn'])?></td>
                                                       <td>
                                                            
                                                            <?php
                                                                if (checkVote($session_Username,$post_sql_row['sn']) == 1) {?>
                                                                    <button type="button" class="btn btn-success" disabled>
                                                                    Vote Casted
                                                                </button>
                                                            <?php 
                                                               }
                                                               else{
                                                                ?>
                                                                    <form method="post" action="voting.php">
                                                                        <input type="hidden" name="postID"
                                                                               value="<?=$post_sql_row['sn']?>">
                                                                        <button type="submit" class="btn btn-primary">
                                                                            Vote
                                                                        </button>
                                                                    </form>
                                                                <?php
                                                               }
                                                            ?>
                                                            
                                                        </td>
                                                         </tr>
                                                       <?php 
                                                   $counter++;
                                               }

                                                   // }
                                                        ?>

                                                </tbody>

                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                        <?php
                    }
                        ?>
                    </div>
                </div>


            </div>


        </div>


        <?php
        include('inc/footer.inc.php');
        unset($_SESSION['Success_vote_message']);
        unset($_SESSION['error_vote_message']);
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

</body>
</html>
