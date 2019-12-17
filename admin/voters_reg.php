<?php
require_once('inc/ensure_login.php');
    require('inc/connect.inc.php');

function generate_voters_id()
{
    global $con;
    $prefix= "V";
    $gen = '';
    for($i=1; $i<=18; $i++){
        $gen .= rand(1,9);
    }
    return $prefix.$gen;
}
function get_lga($id)
{
    global $con;
    $get_lga = mysqli_fetch_assoc(mysqli_query($con,"Select * from lga where sn='$id'"));
    return $get_lga['lga'];
}
function get_dept($id)
{
    global $con;
    $get_lga = mysqli_fetch_assoc(mysqli_query($con,"Select * from faculty_dpt where sn='$id'"));
    return $get_lga['dept'];
}

    $session_Username = $_SESSION['isvoter'];
    //check if voter id exist in db
    $rd = mysqli_query($con,"Select * from registeration where email_id='$session_Username'");

if(isset($_POST['voter_submit_btn'])){
    $fname= $_POST['fname'];
    $mname= $_POST['mname'];
    $lname= $_POST['lname'];
    $level= $_POST['level'];
    $faculty= $_POST['faculty'];
    $gender= $_POST['gender'];
    $dept= $_POST['dept'];
    $Course_of_study= $_POST['course_of_study'];
    $email_id= mysqli_real_escape_string($con,$_POST['email_id']);
    $phn_no= $_POST['phn_no'];
    $state_origin= $_POST['state_origin'];
    $lga= $_POST['lga'];
    $form_err= false;
    if($fname == '' || $mname == '' || $lname == '' || $level == '' || $gender == '' || $dept == '' || $Course_of_study == '' ||
        $email_id == ''  || $phn_no == '' || $state_origin == '' || $lga == '' || 
        $faculty == ''){
        $form_err= true;
    }
    if(!$form_err) {
        // save the data
       $upload_dir= 'uploads/voter_images/';
        $filename= $_FILES['passport']['name'];
        $dest= $upload_dir. '_' .time(). $filename;
        if(move_uploaded_file($_FILES['passport']['tmp_name'], $dest)){
            //save data to db
            $votr_id = generate_voters_id();
            if(!empty($votr_id)){
                $sql= "INSERT into registeration (fname,mname,lname,level,gender,faculty,dept,Course_of_study,email_id,phn_no,
                    state_origin,lga,passport,voter_id) VALUES ('$fname','$mname','$lname','$level','$gender','$faculty',$dept,'$Course_of_study','$email_id','$phn_no','$state_origin','$lga','$dest','$votr_id')";
               mysqli_query($con, $sql) or die(mysqli_error($con));
                
                $success= "Congratulations, Your Profile has been Update. Here is your one time Password ".$votr_id;
            }
            else{
                $error_message = "Technical Issue Please contact Administrator";
            }

        }else {
            $upload_error= "Sorry, your image could not be uploaded, Please try again with another image.";
        }
    }

}
if (isset($_POST['update_profile'])) {
    $fname= $_POST['fname'];
    $mname= $_POST['mname'];
    $lname= $_POST['lname'];
    $level= $_POST['level'];
    $faculty= $_POST['faculty'];
    $gender= $_POST['gender'];
    $dept= $_POST['dept'];
    $course_of_study= $_POST['course_of_study'];
    $email_id= mysqli_real_escape_string($con,$_POST['email_id']);
    $phn_no= $_POST['phn_no'];
    $state_origin= $_POST['state_origin'];
    $lga= $_POST['lga'];
    $form_err= false;
    if($fname == ''  || $lname == '' || $level == '' || $gender == '' || $dept == '' || $course_of_study == ''
          || $phn_no == '' || $state_origin == '' || $lga == '' || $faculty == ''){
        $form_err= true;
    }
    if(!$form_err) {
        $update_sql = "UPDATE registeration Set fname ='$fname',mname ='$mname', lname = '$lname', level ='$level', faculty ='$faculty',
        gender ='$gender', dept ='$dept', course_of_study = '$course_of_study',phn_no ='$phn_no',state_origin ='$state_origin',lga='$lga' 
        where email_id ='$email_id' ";
        // mysqli_query($con, $update_sql) or die(mysqli_error($con));
        if (mysqli_query($con,$update_sql)) {
            $success_message = "Profile Updated successfully";
        }
        else{
            $error_message = "Sorry Error Occured!!! Please retry";
        }
    }
}

$sel= "SELECT * from registeration";
$result= mysqli_query($con,$sel);

$ward_all = mysqli_query($con, "select * from ward");
$sch_ward = mysqli_query($con, "Select* from school_ward");
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

                <?php if($_GET['vd']){ ?>

                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Deleted!</strong> The selected voter was successfully deleted.
                </div>

                <?php } 

                 if(mysqli_num_rows($rd) < 1){
                ?>

                <div class="col-md-4">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Update Profile </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form method="post" action="voters_reg.php" class="form-horizontal form-label-left" enctype="multipart/form-data">
                            <?php
                            if (isset($_POST['voter_submit_btn']) && $form_err) {
                                echo "<p style='color:red'> The form is invalid. please review and submit again </p>";
                            }
                            if (isset($_POST['voter_submit_btn']) && $success != '') {
                                echo "<p style='color:green'> $success </p>";
                            }
                            if (isset($_POST['voter_submit_btn']) && $error_message != '') {
                                echo "<p style='color:red'> $error_message </p>";
                            }
                            if (isset($_POST['voter_submit_btn']) && $upload_error != '') {
                                echo "<p style='color:red'> $upload_error </p>";
                            }
                            ?>

                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="first-name">First Name</label>
                                    <div class="col-xs-12">
                                        <input type="text" name="fname" class="form-control col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="last-name">Middle Name</label>
                                    <div class="col-xs-12">
                                        <input type="text"  name="mname" class="form-control col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-xs-12">Last Name </label>
                                    <div class="col-xs-12">
                                        <input name="lname" class="form-control col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Voter's Image</label>
                                    <div class="col-xs-12">
                                        <input name="passport" class="col-xs-12" type="file">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Email Address</label>
                                    <div class="col-xs-12">
                                        <input name="email_id" class="form-control col-xs-12" type="email" value="<?=$session_Username?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12">Phone Number</label>
                                    <div class="col-xs-12">
                                        <input name="phn_no" class="form-control col-xs-12" type="text" maxlength="11">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Levl</label>
                                    <div class="col-xs-12">
                                        <select name="level" class="form-control">
                                            <option value="">Select Current Level</option>
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="300">300</option>
                                            <option value="400">400</option>
                                            <option value="500">500</option>
                                            <option value="600">600</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Course of Study</label>
                                    <div class="col-xs-12">
                                        <input name="course_of_study" class="form-control col-xs-12" type="text">
                                    </div>
                                </div>

                                <div class="form-group" id="faculty_fm_g">
                                    <label class="control-label col-xs-12">Faculty</label>

                                    <div class="col-xs-12">
                                        <select name="faculty" class="form-control" id="select_faculty">
                                            <option value="">Select a Faculty</option>
                                            <?php while ($frow = mysqli_fetch_assoc($faculty_all)) { ?>
                                                <option value="<?= $frow['faculty'] ?>"><?= $frow['faculty'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="dept_fm_g">
                                    <label class="control-label col-xs-12">Department</label>

                                    <div class="col-xs-12">
                                        <select name="dept" class="form-control" id="select_dept">
                                            <option value="">Select a Department</option>

                                            <?php while ($drow = mysqli_fetch_assoc($faculty_dept)) { ?>
                                                <option value="<?= $drow['sn'] ?>"
                                                        dir="<?= $drow['faculty'] ?>"><?= $drow['dept'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Gender </label>
                                    <div class="col-xs-12">
                                        <select name="gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="state_fm_g">
                                    <label class="control-label col-xs-12">State of Origin</label>
                                    <div class="col-xs-12">
                                        <select name="state_origin" class="form-control" id="state_select">
                                            <option value="">Select a State</option>
                                            <?php while($lrow= mysqli_fetch_assoc($state_all)) { ?>
                                                <option value="<?= $lrow['name']?>"><?=$lrow['name']?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="lga_fm_g">
                                    <label class="control-label col-xs-12">LGA</label>
                                    <div class="col-xs-12">
                                        <select name="lga" class="form-control" id="lga_select">
                                            <option value="">Select a Local Government</option>
                                            <?php while($lrow= mysqli_fetch_assoc($lga_all)) { ?>
                                                <option value="<?= $lrow['sn']?>" dir="<?=$lrow['name']?>"><?= $lrow['name'] .' '.$lrow['lga']?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success" name="voter_submit_btn">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <?php }
                    else{
                        $profile_result = mysqli_fetch_assoc($rd);

                ?>
                <div class="col-md-8">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>My Profile.</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                           <br>
                            <form method="post" action="voters_reg.php" class="form-horizontal" enctype="multipart/form-data">
                            <?php
                            if (isset($_POST['update_profile']) && $form_err) {
                                echo "<p style='color:red'> The form is invalid. please review and submit again!!! </p>";
                            }
                            if (isset($_POST['update_profile']) && $success_message != '') {
                                echo "<p style='color:green'> $success_message </p>";
                            }
                            if (isset($_POST['update_profile']) && $error_message != '') {
                                echo "<p style='color:red'> $error_message </p>";
                            }
                            ?>

                                <div class="row">
                                    <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-xs-12" for="first-name">First Name</label>
                                        <div class="col-xs-12">
                                            <input type="text" name="fname" class="form-control col-xs-12" value="<?=$profile_result['fname']?>" >
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="last-name">Middle Name</label>
                                    <div class="col-xs-12">
                                        <input type="text"  name="mname" class="form-control col-xs-12" value="<?=$profile_result['mname']?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-xs-12">Last Name </label>
                                    <div class="col-xs-12">
                                        <input name="lname" class="form-control col-xs-12" type="text" value="<?=$profile_result['lname']?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Email Address</label>
                                    <div class="col-xs-12">
                                        <input name="email_id" class="form-control col-xs-12" type="email" value="<?=$session_Username?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12">Phone Number</label>
                                    <div class="col-xs-12">
                                        <input name="phn_no" class="form-control col-xs-12" type="text" maxlength="11" value="<?=$profile_result['phn_no']?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Levl</label>
                                    <div class="col-xs-12">
                                        <select name="level" class="form-control">
                                            <option value="<?=$profile_result['level']?>" selected> <?=$profile_result['level']?></option>
                                            <option value="">Select Current Level</option>
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="300">300</option>
                                            <option value="400">400</option>
                                            <option value="500">500</option>
                                            <option value="600">600</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Course of Study</label>
                                    <div class="col-xs-12">
                                        <input name="course_of_study" class="form-control col-xs-12" type="text" value="<?=$profile_result['course_of_study']?>">
                                    </div>
                                </div>

                                <div class="form-group" id="faculty_fm_g">
                                    <label class="control-label col-xs-12">Faculty</label>

                                    <div class="col-xs-12">
                                        <select name="faculty" class="form-control" id="select_faculty">
                                            <option value="<?=$profile_result['faculty']?>" selected> <?=$profile_result['faculty']?></option>
                                            <option value="">Select a Faculty</option>
                                            <?php while ($frow = mysqli_fetch_assoc($faculty_all)) { ?>
                                                <option value="<?= $frow['faculty'] ?>"><?= $frow['faculty'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="dept_fm_g">
                                    <label class="control-label col-xs-12">Department</label>

                                    <div class="col-xs-12">
                                        <select name="dept" class="form-control" id="select_dept">
                                            <option value="<?=$profile_result['dept']?>" selected> <?=get_dept($profile_result['dept'])?></option>
                                            <option value="">Select a Department</option>

                                            <?php while ($drow = mysqli_fetch_assoc($faculty_dept)) { ?>
                                                <option value="<?= $drow['sn'] ?>"
                                                        dir="<?= $drow['faculty'] ?>"><?= $drow['dept'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Gender </label>
                                    <div class="col-xs-12">
                                        <select name="gender" class="form-control">
                                        <option value="<?=$profile_result['gender']?>" selected> <?=$profile_result['gender']?></option>
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="state_fm_g">
                                    <label class="control-label col-xs-12">State of Origin</label>
                                    <div class="col-xs-12">
                                        <select name="state_origin" class="form-control" id="state_select">
                                        <option value="<?=$profile_result['state_origin']?>" selected> <?=$profile_result['state_origin']?></option>
                                            <option value="">Select a State</option>
                                            <?php while($lrow= mysqli_fetch_assoc($state_all)) { ?>
                                                <option value="<?= $lrow['name']?>"><?=$lrow['name']?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="lga_fm_g">
                                    <label class="control-label col-xs-12">LGA</label>
                                    <div class="col-xs-12">
                                        <select name="lga" class="form-control" id="lga_select">
                                        <option value="<?=$profile_result['lga']?>" selected> <?=get_lga($profile_result['lga'])?></option>
                                            <option value="">Select a Local Government</option>
                                            <?php while($lrow= mysqli_fetch_assoc($lga_all)) { ?>
                                                <option value="<?= $lrow['sn']?>" dir="<?=$lrow['name']?>"><?= $lrow['name'] .' '.$lrow['lga']?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-success btn-block" name="update_profile">Update</button>
                                    </div>
                                </div>
                                </form>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?=$profile_result['passport']?>" alt="..." class=" profile_img" width="200px" height="200px">
                        </div>
                        <div class="profile_info" style="clear: both">
                            <h2 style="color:green;"><?= $full_name?></h2>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
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
        $('#datatable-responsive').dataTable();
</script>
<script>
    $('#lga_fm_g').show();
    $('#lga_select option').hide();
    $('#state_select').change(function(){
        $('#lga_select option').hide();
        var this_val = $(this).val();
        $('#lga_select option[dir='+this_val+']').show();
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
