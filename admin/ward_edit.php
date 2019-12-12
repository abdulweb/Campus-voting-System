<?php
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');

$get_id = $_POST['wn'];
$sql_tst = "select * from ward where sn='$get_id'";
$red = mysqli_query($con,$sql_tst)or die(mysqli_error($con));
if(mysqli_num_rows($red) ==0){
    header("Location: index.php");
    exit;
}
$red = mysqli_fetch_assoc($red);
$ward_name= $red['ward_name'];
$ward_number= $red['ward_number'];
$lga_number= $red['lga_id'];

if(isset($_POST['ward_edit_btn'])){
    $ward_name= $_POST['ward_name'];
    $ward_number= $_POST['ward_number'];

        $form_err= false;
    if($ward_name == '' || $ward_number == ''){
        $form_err= true;
    }

    $sql= "Update ward set ward_name = '$ward_name', ward_number = '$ward_number' Where sn='$red[sn]'";
    mysqli_query($con, $sql) or die(mysqli_error($con));
    $success= "$ward_name's record has been updated <a href='create_ward.php' class='btn btn-success' > Back to Ward Registration Page </a>";

}
$wards =mysqli_query($con,"select * from lga");
$sel= "SELECT * from ward order by ward_name ASC";
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

    <title>Ward Registration</title>

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
                            <h2>Edit[<?=$ward_name?>] Ward </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                <?php
                                if (isset($_POST['ward_edit_btn']) && $form_err) {
                                    echo "<p style='color:red'> The form is invalid. please review and submit again </p>";
                                }
                                if (isset($_POST['ward_edit_btn']) && $success != '') {
                                    echo "<p style='color:green'> $success </p>";
                                }
                                ?>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">LGA </label>
                                    <div class="col-xs-12">
                                        <select name="lga_id" class="form-control">
                                            <?php while($ward=mysqli_fetch_assoc($wards)) { ?>
                                                <option value="<?=$ward['sn']?>" <?php if($ward['sn'] == "$lga_number") {echo "selected"; } ?>><?php echo $ward['name'] .'-'. $ward['lga'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="first-name">Ward Name</label>
                                    <div class="col-xs-12">
                                        <input type="text" name="ward_name" class="form-control col-xs-12" value="<?= $ward_name; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="first-name">Ward Number</label>
                                    <div class="col-xs-12">
                                        <input type="number" name="ward_number" class="form-control col-xs-12" value="<?= $ward_number; ?>">
                                    </div>
                                </div>

                                <input type="hidden" name="wn" value="<?= $_POST['wn']?>">
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success" name="ward_edit_btn">Submit</button>
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
