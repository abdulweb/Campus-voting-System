<?php
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');

$get_id = $_GET['v'];
$sql_tst = "select * from registeration where sn='$get_id'";
$red = mysqli_query($con,$sql_tst)or die(mysqli_error($con));
if(mysqli_num_rows($red) ==0){
    header("Location: index.php");
    exit;
}
$red = mysqli_fetch_assoc($red);
$fname= $red['fname'];
$mname= $red['mname'];
$lname= $red['lname'];
$address= $red['address'];
$occupation= $red['occupation'];
$gender= $red['gender'];
$dob= $red['dob'];
$age= $red['age'];
$status= $red['status'];
$email_id= $red['email_id'];
$phn_no= $red['phn_no'];
//    $password= $_POST['password'];
$nationality= $red['nationality'];
$state_origin= $red['state_origin'];
$lga= $red['lga'];
$ward= $red['ward'];
$v_passport = $red['passport'];
$religion = $red['religion'];


if(isset($_POST['voter_edit_btn'])){
    $fname= $_POST['fname'];
    $mname= $_POST['mname'];
    $lname= $_POST['lname'];
    $address= $_POST['address'];
    $occupation= $_POST['occupation'];
    $gender= $_POST['gender'];
    $dob= $_POST['dob'];
    $age= $_POST['age'];
    $status= $_POST['status'];
    $email_id= mysqli_real_escape_string($con,$_POST['email_id']);
    $phn_no= $_POST['phn_no'];
//    $password= $_POST['password'];
    $nationality= $_POST['nationality'];
    $state_origin= $_POST['state_origin'];
    $lga= $_POST['lga'];
    $ward= $_POST['ward'];
    $religion= $_POST['religion'];
    $form_err= false;
    if($fname == '' || $mname == '' || $lname == '' || $address == '' || $gender == '' || $dob == '' || $age == '' || $status == '' ||
        $email_id == '' || $phn_no == '' || $nationality == '' || $state_origin == '' || $lga == '' || $ward == '' || $occupation == '' || $religion == ''){
        $form_err= true;
    }
    if(!$form_err) {
        // save the data
        if($_FILES['passport']['name'] != '') {
            $upload_dir = 'uploads/voter_images/';
            $filename = $_FILES['passport']['name'];
            $v_passport = $upload_dir . '_' . time() . $filename;
            if (move_uploaded_file($_FILES['passport']['tmp_name'], $v_passport)) {

            } else {
                $upload_error = "Sorry, your image could not be uploaded, Please try again with another image.";
            }
        }

            $sql= "Update registeration set fname = '$fname', mname='$mname', lname='$lname', address='$address', gender='$gender', dob='$dob', age=$age, status='$status', email_id='$email_id',
                    phn_no = '$phn_no', nationality='$nationality', state_origin='$state_origin',lga='$lga',ward=$ward,occupation='$occupation',passport='$v_passport',religion='$religion'
                    Where sn='$red[sn]'";
            mysqli_query($con, $sql) or die(mysqli_error($con));
            $success= "$fname's record has been updated <a href='voters_reg.php' class='btn btn-success' > Back to Registration Page </a>";
    }

}
$sel= "SELECT * from registeration";
$result= mysqli_query($con,$sel);

$ward_all = mysqli_query($con, "select * from ward");
$lga_all = mysqli_query($con, "select * from lga");
$state_all = mysqli_query($con, "select DISTINCT name from lga where 1");
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
                            <h2>Voter[<?=$fname?>] Details </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                <?php
                                if (isset($_POST['voter_edit_btn']) && $form_err) {
                                    echo "<p style='color:red'> The form is invalid. please review and submit again </p>";
                                }
                                if (isset($_POST['voter_edit_btn']) && $success != '') {
                                    echo "<p style='color:green'> $success </p>";
                                }
                                ?>

                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="first-name">First Name</label>
                                    <div class="col-xs-12">
                                        <input type="text" name="fname" class="form-control col-xs-12" value="<?= $fname; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="last-name">Middle Name</label>
                                    <div class="col-xs-12">
                                        <input type="text"  name="mname" class="form-control col-xs-12" value="<?= $mname; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-xs-12">Last Name </label>
                                    <div class="col-xs-12">
                                        <input name="lname" class="form-control col-xs-12" type="text" value="<?= $lname; ?>">
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
                                        <input name="email_id" class="form-control col-xs-12" type="email" value="<?= $email_id; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12">Phone Number</label>
                                    <div class="col-xs-12">
                                        <input name="phn_no" class="form-control col-xs-12" type="text" value="<?= $phn_no; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Address</label>
                                    <div class="col-xs-12">
                                        <input name="address" class="form-control col-xs-12" type="text" placeholder="Enter your permanent address" value="<?= $address; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Occupation</label>
                                    <div class="col-xs-12">
                                        <input name="occupation" class="form-control col-xs-12" type="text"  value="<?= $occupation; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Date of Birth</label>
                                    <div class="col-xs-12">
                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                                        <input name="dob" type="text" class="form-control has-feedback-left" id="single_cal4" placeholder="Date of birth" aria-describedby="inputSuccess2Status4"value="<?= $dob; ?>">
                                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                        <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12">Age <span class="required">*</span></label>
                                    <div class="col-xs-12">
                                        <input name="age" required="required" class="form-control col-xs-12" type="text"value="<?= $age; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Marital Status </label>
                                    <div class="col-xs-12">
                                        <select name="status" class="form-control">
                                            <option value="single" <?php if($status=='single') echo 'selected' ?>>Single</option>
                                            <option value="married" <?php if($status=='married') echo 'selected' ?>>Married</option>
                                            <option value="divorced" <?php if($status=='divorced') echo 'selected' ?>>Divorced</option>
                                            <option value="widow" <?php if($status=='widow') echo 'selected' ?>>Widow</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Religion</label>
                                    <div class="col-xs-12">
                                        <select name="religion" class="form-control">
                                            <option value="islam" <?php if($religion=='islam') echo 'selected' ?>>Islam</option>
                                            <option value="christianity" <?php if($religion=='christianity') echo 'selected' ?>>Christianity</option>
                                            <option value="other" <?php if($religion=='other') echo 'selected' ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Gender </label>
                                    <div class="col-xs-12">
                                        <select name="gender" class="form-control">
                                            <option value="male" <?php if($gender=='male') echo 'selected' ?>>Male</option>
                                            <option value="female" <?php if($gender=='female') echo 'selected' ?>>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Nationality</label>
                                    <div class="col-xs-12">
                                        <select name="nationality" class="form-control">
                                            <option value="nigerian">Nigerian</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="state_fm_g">
                                    <label class="control-label col-xs-12">State of Origin</label>
                                    <div class="col-xs-12">
                                        <select name="state_origin" class="form-control" id="state_select">
                                            <option value="">Select a State</option>
                                            <?php while($lrow= mysqli_fetch_assoc($state_all)) { ?>
                                                <option value="<?= $lrow['name']?>" <?php if($state_origin==$lrow['name']) echo 'selected' ?>><?=$lrow['name']?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="lga_fm_g">
                                    <label class="control-label col-xs-12">LGA</label>
                                    <div class="col-xs-12">
                                        <select name="lga" class="form-control" id="lga_select">
                                            <option value="">Select a Local Government</option>
                                            <?php while ($lrow = mysqli_fetch_assoc($lga_all)) { ?>
                                                <option value="<?= $lrow['sn'] ?>" <?php if($lga==$lrow['sn']) echo 'selected' ?>
                                                        dir="<?= $lrow['name'] ?>"><?= $lrow['name'] . ' ' . $lrow['lga'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="ward_fm_g">
                                    <label class="control-label col-xs-12">Ward</label>
                                    <div class="col-xs-12">
                                        <select name="ward" class="form-control" id="ward_select">
                                            <option value="">Select a Ward</option>
                                            <?php while($wrow= mysqli_fetch_assoc($ward_all)) { ?>
                                                <option value="<?= $wrow['sn']?>" <?php if($ward==$wrow['sn']) echo 'selected' ?> dir="<?=$wrow['lga_id']?>">
                                                    <?= $wrow['ward_name']?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success" name="voter_edit_btn">Submit</button>
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
                            <h2 style="color:green;"><?= $fname. ' '. $lname;?></h2>
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
    $('#state_select').change(function(){
        $('#lga_select option').hide();
        var this_val = $(this).val();
        $('#lga_select option[dir='+this_val+']').show();
        $('#lga_fm_g').show();
    })

    $('#lga_select').change(function(){
        $('#ward_select option').hide();
        var this_val = $(this).val();
        $('#ward_select option[dir='+this_val+']').show();
        $('#ward_fm_g').show();
    })
    $('#state_select').change();
    $('#lga_select').change();
</script>
</body>
</html>
