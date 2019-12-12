<?php
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');

$get_id = $_POST['pr'];
$sql_tst = "select * from party where sn='$get_id'";
$red = mysqli_query($con,$sql_tst)or die(mysqli_error($con));
if(mysqli_num_rows($red) == 0){
    header("Location: index.php");
    exit;
}
$red = mysqli_fetch_assoc($red);
$party_name= mysqli_real_escape_string($con,$red['party_name']);
$party_code= $red['party_code'];
$motto= $red['motto'];
$v_passport = $red['party_logo'];

if(isset($_POST['party_edit_btn'])) {
    $party_name = mysqli_real_escape_string($con,$_POST['party_name']);
    $party_code = $_POST['party_code'];
    $motto = $_POST['motto'];
    $form_err = false;
    if ($party_name == '' || $party_code == '' || $motto == '') {
        $form_err = true;
    }
    if (!$form_err) {
        // save the data
        if ($_FILES['party_logo']['name'] != '') {
            $upload_dir = 'uploads/party_logos/';
            $filename = $_FILES['party_logo']['name'];
            $v_passport = $upload_dir . '_' . time() . $filename;
            if (move_uploaded_file($_FILES['party_logo']['tmp_name'], $v_passport)) {

            } else {
                $upload_error = "Sorry, your image could not be uploaded, Please try again with another image.";
            }
        }

        $sql = "Update party set party_name = '$party_name', party_code = '$party_code', motto = '$motto',party_logo ='$v_passport'
                    Where sn='$red[sn]'";
        mysqli_query($con, $sql) or die(mysqli_error($con));
        $success = "$party_name's record has been updated <a href='party_reg.php' class='btn btn-success' > Back to Party Registration Page </a>";
    }
}

$sel= "SELECT * from party";
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

    <title>Party Registration</title>

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
                            <h2>Party[<?=$party_name?>] Details </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                <?php
                                if (isset($_POST['party_edit_btn']) && $form_err) {
                                    echo "<p style='color:red'> The form is invalid. please review and submit again </p>";
                                }
                                if (isset($_POST['party_edit_btn']) && $success != '') {
                                    echo "<p style='color:green'> $success </p>";
                                }
                                ?>
                                <input type="hidden" name="pr" value="<?=$get_id?>" >
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Party
                                        Name</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="party_name" class="form-control col-md-7 col-xs-12" value="<?= $party_name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Party
                                        Code</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="party_code" class="form-control col-md-7 col-xs-12" value="<?= $party_code; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Motto/Slogan</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="motto" class="form-control col-md-7 col-xs-12" type="text" value="<?= $motto; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Party Logo</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="party_logo">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success" name="party_edit_btn">Submit</button>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?= $v_passport?>" alt="..." class=" profile_img" width="200px" height="200px">
                        </div>
                        <div class="profile_info" style="clear: both">
                            <h2 style="color:green;"><?= $party_name?></h2>
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
