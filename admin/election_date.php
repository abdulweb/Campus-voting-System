<?php
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');

/*echo mktime(0, 0, 0,4,4,2009);
echo "<br>";
echo mktime(15, 0, 0,4,4,2009);
echo strtotime('4/4/2009:9');*/
//$start_date = DateTime::createFromFormat('d/m/Y',$test);
//echo $start_date;

if (isset($_POST['election_date_btn'])) {
    $post_id = $_POST['post_id'];
    $start_day = $_POST['start_day'];
    $start_month = $_POST['start_month'];
    $start_year = $_POST['start_year'];
    $end_day = $_POST['end_day'];
    $end_month = $_POST['end_month'];
    $end_year = $_POST['end_year'];



    $form_err = false;

    if ($post_id == '' && $start_day == ''  && $start_month == ''  && $start_year == '' && $end_day == ''&& $end_month == ''&& $end_year == '') {
        $form_err = true;
    }
     
    $error_out ='';
    $start_d = strtotime("$start_month/$start_day/$start_year");
    $end_d = strtotime("$end_month/$end_day/$end_year");
    //echo "<h1> $start_d</h1><br>";
    //echo "<h1> $end_d</h1><br>";
    if(intval($start_d) > intval($end_d)){
        $error_out .= "Election Start date must not be higher than the end date <br>";
        $form_err = false;
    }
    else{
    if (!$form_err) {
        {
            // save data to db
            if (strlen($start_day) < 2) {
                $new_start_day = '0'.$start_day;
            }
            else{$new_start_day=$start_day;}
            if (strlen($end_day) < 2) {
                $new_end_day = '0'.$end_day;
            }
            else{$new_end_day=$end_day;}
             //
             if (strlen($start_month) < 2) {
                $new_start_month = '0'.$start_month;
            }
            else{$new_start_month=$start_month;}
            if (strlen($end_month) < 2) {
                $new_end_month = '0'.$end_month;
            }
            else{$new_end_month=$end_month;}


            $start_time = mktime(0, 0, 0,intval($start_day),intval($start_month),intval($start_year));
            $end_time = mktime(18, 0, 0,intval($end_day),intval($end_month),intval($end_year));


            //$start_date = strtotime("$start_month/$start_day/$start_year");
            $end_date = strtotime("$end_month/$end_day/$end_year");
                //start and end date
            $start_date = $start_year.'-'. $new_start_month. '-'.$new_start_day;
            $end_date = $end_year.'-'. $new_end_month. '-'.$new_end_day;
            
            //check if election data has been set be
            $sqla = mysqli_query($con, "select start_date, end_date from election_date where post_id = '$post_id'");
            $res = mysqli_num_rows($sqla);
            $rows = mysqli_fetch_assoc($sqla);
            if (!rows) {
                echo "not fecthed";
            }
            
            $check_start_date =$rows['start_date'];
            $check_end_date = $rows['end_date'];
            if (($start_date == $check_start_date) && ($end_date==$check_end_date) ){
               $error_out = "Sorry the election date you entered has already been registered!!!. Kindly choose another date" ;
            }
            elseif($post_id==0 || empty($post_id)) {
                $error_out = "Post is unknown. Please select a post";
                //$form_err = true;
            }
            else{

            $sql = "INSERT into election_date (post_id,start_date,end_date,start_time,end_time) VALUES
            ('$post_id','$start_date','$end_date','$start_time','$end_time')";
            mysqli_query($con, $sql) or die(mysqli_error($con));
            $success = "Congratulations. A new election time, $start_date to $end_date has been scheduled.";
            }
        }
    }
}

}
$posts =mysqli_query($con,"select * from post");
$sel = "SELECT * from post order by ward_name ASC";
$result = mysqli_query($con,$sel);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Election Date Setup</title>

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
        .start_date_widget{
            width:30%;
            float: left;
            margin-right: 2%;
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
                        <h2>Election Date Setup</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        <form method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" action="election_date.php">
                            <?php if(isset($error_out)) { ?>
                                <p style="color: red;"><?= $error_out ?></p>
                            <?php } ?>
                             <?php if(isset($success)) { ?>
                                <p style="color: green;"><?= $success ?></p>
                            <?php } ?>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Set Election Date For </label>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="post_id" class="form-control" id="post_select">
                                        <option value="">Select a post</option>
                                        <?php while ($psrow = mysqli_fetch_assoc($posts)) { ?>
                                            <option
                                                value="<?= $psrow['sn'] ?>"><?= $psrow['post_name'] ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group" id="">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date</label>

                                <div class=" col-md-6 col-sm-6 col-xs-12">
                                    <select name="start_day" class="form-control start_date_widget" >
                                        <option value="">Day</option>
                                        <?php for($i=1;$i<=31;$i++){ ?>
                                            <option value="<?= $i?>"><?= $i?></option>
                                        <?php } ?>
                                    </select>

                                    <select name="start_month" class="form-control start_date_widget">
                                        <option value="">Month</option>
                                        <?php for($i=1;$i<=12;$i++){ ?>
                                            <option value="<?= $i?>"><?= $i?></option>
                                        <?php } ?>
                                    </select>

                                    <select name="start_year" class="form-control start_date_widget" >
                                        <option value="">Year</option>
                                        <option value="2018">2018</option>
                                    </select>
                                </div>
                            </div>

<!--                            <div class="form-group" id="">-->
<!--                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Time</label>-->
<!---->
<!--                                <div class=" col-md-6 col-sm-6 col-xs-12">-->
<!--                                    <select name="start_hour" class="form-control start_date_widget">-->
<!--                                        <option value="">Hour</option>-->
<!--                                        --><?php //for($i=1;$i<=12;$i++){ ?>
<!--                                            <option value="--><?//= $i?><!--">--><?//= $i?><!--</option>-->
<!--                                        --><?php //} ?>
<!--                                    </select>-->
<!---->
<!--                                    <select name="start_minute" class="form-control start_date_widget">-->
<!--                                        <option value="">Minute</option>-->
<!--                                        --><?php //for($i=1;$i<60;$i++){ ?>
<!--                                            <option value="--><?//= $i?><!--">--><?//= $i?><!--</option>-->
<!--                                        --><?php //} ?>
<!--                                    </select>-->
<!---->
<!--                                    <select name="start_format" class="form-control start_date_widget" >-->
<!--                                        <option value="AM">AM</option>-->
<!--                                        <option value="PM">PM</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->

                            <div class="form-group" id="">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">End Date</label>

                                <div class=" col-md-6 col-sm-6 col-xs-12">
                                    <select name="end_day" class="form-control start_date_widget" >
                                        <option value="">Day</option>
                                        <?php for($i=1;$i<=31;$i++){ ?>
                                            <option value="<?= $i?>"><?= $i?></option>
                                        <?php } ?>
                                    </select>

                                    <select name="end_month" class="form-control start_date_widget">
                                        <option value="">Month</option>
                                        <?php for($i=1;$i<=12;$i++){ ?>
                                            <option value="<?= $i?>"><?= $i?></option>
                                        <?php } ?>
                                    </select>

                                    <select name="end_year" class="form-control start_date_widget" >
                                        <option value="">Year</option>
                                        <option value="2018">2018</option>
                                    </select>
                                </div>
                            </div>

<!--                            <div class="form-group" id="">-->
<!--                                <label class="control-label col-md-3 col-sm-3 col-xs-12">End Time</label>-->
<!---->
<!--                                <div class=" col-md-6 col-sm-6 col-xs-12">-->
<!--                                    <select name="end_hour" class="form-control start_date_widget">-->
<!--                                        <option value="">Hour</option>-->
<!--                                        --><?php //for($i=1;$i<=12;$i++){ ?>
<!--                                            <option value="--><?//= $i?><!--">--><?//= $i?><!--</option>-->
<!--                                        --><?php //} ?>
<!--                                    </select>-->
<!---->
<!--                                    <select name="end_minute" class="form-control start_date_widget">-->
<!--                                        <option value="">Minute</option>-->
<!--                                        --><?php //for($i=1;$i<60;$i++){ ?>
<!--                                            <option value="--><?//= $i?><!--">--><?//= $i?><!--</option>-->
<!--                                        --><?php //} ?>
<!--                                    </select>-->
<!---->
<!--                                    <select name="end_format" class="form-control start_date_widget" >-->
<!--                                        <option value="AM">AM</option>-->
<!--                                        <option value="PM">PM</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->


                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" class="btn btn-success" name="election_date_btn">Submit</button>
                                </div>
                            </div>


                        </form>
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
