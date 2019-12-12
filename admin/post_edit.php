<?php
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');

    $get_id = $_POST['pn'];
    $sql_tst = "select * from post where sn='$get_id'";
    $red = mysqli_query($con,$sql_tst)or die(mysqli_error($con));
    if(mysqli_num_rows($red) ==0){
        header("Location: index.php");
        exit;
    }
    $red = mysqli_fetch_assoc($red);
    $post_name= $red['post_name'];


if(isset($_POST['post_edit_btn'])){
    $post_name= $_POST['post_name'];
    $form_err= false;
    if($post_name == ''){
        $form_err= true;
    }

        $sql= "Update post set post_name = '$post_name 'Where sn='$red[sn]'";
        mysqli_query($con, $sql) or die(mysqli_error($con));
        $success= "$post_name's record has been updated <a href='post.php' class='btn btn-success' > Back to Post Registration Page </a>";


}
$sel= "SELECT * from registeration";
$result= mysqli_query($con,$sel);
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
                <div class="col-md-8">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Edit[<?=$post_name?>] Post </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                <?php
                                if (isset($_POST['post_edit_btn']) && $form_err) {
                                    echo "<p style='color:red'> The form is invalid. please review and submit again </p>";
                                }
                                if (isset($_POST['post_edit_btn']) && $success != '') {
                                    echo "<p style='color:green'> $success </p>";
                                }
                                ?>

                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="first-name">Post Name</label>
                                    <div class="col-xs-12">
                                        <input type="text" name="post_name" class="form-control col-xs-12" value="<?= $post_name; ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="pn" value="<?= $_POST['pn']?>">
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success" name="post_edit_btn">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>


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

<!-- Custom Theme Scripts -->
<script src="./build/js/custom.min.js"></script>

</body>
</html>
