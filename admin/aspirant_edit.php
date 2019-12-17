<?php
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');

$get_id = $_POST['asn'];
$sql_tst = "SELECT *,ps.post_name, lg.lga from aspirant a
 JOIN  post ps on a.post_id = ps.sn join lga lg  on a.lga_id=lg.sn
  WHERE a.sn='$get_id'";
$red = mysqli_query($con,$sql_tst)or die(mysqli_error($con));
if(mysqli_num_rows($red) == 0){
    header("Location: index.php");
    exit;
}
$red = mysqli_fetch_assoc($red);
$full_name= $red['full_name'];
$gender= $red['gender'];
$admission_no= $red['admissionNo'];
$level = $red['level'];
$post = $red['post_name'];
$post_id = $red['post_id'];
$lga_id = $red['lga_id'];
$state = $red['state'];
$faculty_dpt_id = $red['faculty_dpt_id'];
$faculty = $red['faculty'];
$v_passport = $red['passport'];
$cgpa = $red['cgpa'];
$course_of_study = $red['course_of_study'];


//$ward_name  = '';
//if($ward_id != 0){
//    $getd = mysqli_fetch_assoc(mysqli_query($con, "Select ward_name from ward where sn='$ward_id'"));
//    $ward_name = $get['ward_name'];
//}
$ward = '';
if(isset($_POST['aspirant_edit_btn'])) {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $admission_no = $_POST['admission_no'];
    $level = $_POST['level'];
    echo $post = $_POST['post'];
    $lga_id = $_POST['lga'];
    $state = $_POST['state'];
    $faculty = $_POST['faculty'];
    $dept = $_POST['dept'];
    $cgpa = $_POST['cgpa'];
    $course_of_study = $_POST['course_of_study'];
    $form_err = false;
    if ($full_name == '' || $gender == '' || $admission_no == '' || $level == ''|| $faculty == ''|| $post == '' || $lga_id == '' || $dept == '' || $state == '' || $cgpa =='' || $course_of_study =='') {
        $form_err = true;
        echo  $post;
    }
    if (!$form_err) {
        // save the data
        if ($_FILES['passport']['name'] != '') {
            $upload_dir = 'uploads/aspirant_images/';
            $filename = $_FILES['passport']['name'];
            $v_passport = $upload_dir . '_' . time() . $filename;
            if (move_uploaded_file($_FILES['passport']['tmp_name'], $v_passport)) {

            } else {
                $upload_error = "Sorry, your image could not be uploaded, Please try again with another image.";
            }
        }

        $sql = "Update aspirant set full_name = '$full_name', gender = '$gender', level = '$level',cgpa ='$cgpa', faculty_dpt_id ='$dept', post_id ='$post', lga_id ='$lga_id',faculty ='$faculty',
                    course_of_study = '$course_of_study', admissionNo = '$admission_no', state='$state', passport ='$v_passport'
                    Where sn='$get_id'";
        $sql_result = mysqli_query($con, $sql) or die(mysqli_error($con));
        if ($sql_result) {
           $success = "$full_name's record has been updated <a href='aspirant_reg.php' class='btn btn-success' > Back to Aspirant Registration Page </a>";
        }
        else{
            $erro_message = 'Error Occured Please try again';
        }
        // $success = "$full_name's record has been updated <a href='aspirant_reg.php' class='btn btn-success' > Back to Aspirant Registration Page </a>";
    }
}

$post_all = mysqli_query($con, "select * from post");
$lga_all = mysqli_query($con, "select * from lga");
$state_all = mysqli_query($con, "select DISTINCT name from lga where 1");
$faculty_all = mysqli_query($con, "select DISTINCT faculty from faculty_dpt where 1");
$faculty_dept = mysqli_query($con, "select * from faculty_dpt");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Aspirant</title>

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
<!--    <style>-->
<!--        #lga_fm_g,#ward_fm_g{-->
<!--            display:none;-->
<!--        }-->
<!--    </style>-->
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
                            <h2>Aspirant[<?=$full_name?>] Details </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                <?php
                                if (isset($_POST['aspirant_edit_btn']) && $form_err) {
                                    echo "<p style='color:red'> The form is invalid. please review and submit again </p>";
                                }
                                if (isset($_POST['aspirant_edit_btn']) && $success != '') {
                                    echo "<p style='color:green'> $success </p>";
                                }
                                if (isset($_POST['aspirant_edit_btn']) && $erro_message != '') {
                                    echo "<p style='color:red'> $erro_message </p>";
                                }
                                ?>
                                <input type="hidden" name="asn" value="<?=$get_id?>" >
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Full Name</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="full_name" placeholder="Surname First" class="form-control col-md-7 col-xs-12" type="text" value="<?= $full_name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Admission Number</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="admission_no" placeholder="Admission Number" class="form-control col-md-7 col-xs-12" type="text" value="<?= $admission_no; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="gender" class="form-control">
                                            <option value="male" <?php if($gender=='male') echo 'selected' ?>>Male</option>
                                            <option value="female" <?php if($gender=='female') echo 'selected' ?>>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Level</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="level" class="form-control">
                                            <option value="100" <?php if($level=='100') echo 'selected' ?>>100</option>
                                            <option value="200" <?php if($level=='200') echo 'selected' ?>>200</option>
                                            <option value="300" <?php if($level=='300') echo 'selected' ?>>300</option>
                                            <option value="400" <?php if($level=='400') echo 'selected' ?>>400</option>
                                            <option value="500" <?php if($level=='500') echo 'selected' ?>>500</option>
                                            <option value="600" <?php if($level=='600') echo 'selected' ?>>600</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Aspirant's Image</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file"  name="passport">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">CGPA<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="cgpa" required="required" class="form-control col-md-7 col-xs-12" type="text" value="<?= $cgpa?>">
                                    </div>
                                </div>

                                <div class="form-group" id="faculty_fm_g">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Faculty</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="faculty" class="form-control" id="select_dept">
                                            <option value="">Select a Faculty</option>
                                            <?php while($srow= mysqli_fetch_assoc($faculty_all)) { ?>
                                                <option value="<?= $srow['faculty']?>" <?php if($faculty==$srow['faculty']) echo 'selected' ?>><?=$srow['faculty']?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="dept_fm_g">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Department</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="dept" class="form-control" id="select_dept">
                                            <option value="">Select Department</option>
                                            <?php while ($lrow = mysqli_fetch_assoc($faculty_dept)) { ?>
                                                <option value="<?= $lrow['sn'] ?>" <?php if($faculty_dpt_id==$lrow['sn']) echo 'selected' ?>
                                                        dir="<?= $lrow['faculty'] ?>"><?= $lrow['faculty'] . ' ' . $lrow['dept'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Course of study<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="course_of_study" required="required" class="form-control col-md-7 col-xs-12" type="text" value="<?= $course_of_study?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Post</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="post" class="form-control" id="post_select">
                                            <option value="">Select a post</option>
                                            <?php while($psrow= mysqli_fetch_assoc($post_all)) { ?>
                                                <option value="<?=$psrow['sn']?>" <?php if($post_id==$psrow['sn']) echo 'selected' ?>><?= $psrow['post_name']?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="state_fm_g">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">State of Origin</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="state" class="form-control" id="state_select">
                                            <option value="">Select a State</option>
                                            <?php while($srow= mysqli_fetch_assoc($state_all)) { ?>
                                                <option value="<?= $srow['name']?>" <?php if($state==$srow['name']) echo 'selected' ?>><?=$srow['name']?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="lga_fm_g">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">LGA</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="lga" class="form-control" id="lga_select">
                                            <option value="">Select a Local Government</option>
                                            <?php while ($lrow = mysqli_fetch_assoc($lga_all)) { ?>
                                                <option value="<?= $lrow['sn'] ?>" <?php if($lga_id==$lrow['sn']) echo 'selected' ?>
                                                        dir="<?= $lrow['name'] ?>"><?= $lrow['name'] . ' ' . $lrow['lga'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success" name="aspirant_edit_btn">Submit</button>
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
                            <h2 style="color:green;"><?= $full_name?></h2>
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
<script>
    $('#lga_fm_g').show();
    $('#lga_select option').hide();
    $('#state_select').change(function () {
        $('#lga_select option').hide();
        var this_val = $(this).val();
        $('#lga_select option[dir=' + this_val + ']').show();
        $('#lga_fm_g').show();
    })

</script>
<script>
    $('#dept_fm_g').show();
    $('#select_dept option').hide();
    $('#select_faculty').change(function () {
        $('#select_dept option').hide();
        var this_val = $(this).val();
        $('#select_dept option[dir=' + this_val + ']').show();
        $('#dept_fm_g').show();
    })
</script>

</body>
</html>
