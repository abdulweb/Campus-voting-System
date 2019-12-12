<?php
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');

$get_id = $_POST['asn'];
$sql_tst = "SELECT *, a.sn, a.ward_id, c.party_name, c.party_code,c.party_logo, ps.post_name, lg.lga from aspirant a
 JOIN party c on a.party_id=c.sn join post ps on a.post_id = ps.sn join lga lg  on a.lga_id=lg.sn
  WHERE a.sn='$get_id'";
$red = mysqli_query($con,$sql_tst)or die(mysqli_error($con));
if(mysqli_num_rows($red) == 0){
    header("Location: index.php");
    exit;
}
$red = mysqli_fetch_assoc($red);
$full_name= $red['full_name'];
$gender= $red['gender'];
$age= $red['age'];
$qualification = $red['qualification'];
$party = $red['party_name'];
$party_id = $red['party_id'];
$post = $red['post_name'];
$post_id = $red['post_id'];
$lga_id = $red['lga_id'];
$state = $red['state'];
$ward_id = $red['ward_id'];
$v_passport = $red['passport'];
$religion = $red['passport'];
$address = $red['address'];
//$ward_name  = '';
//if($ward_id != 0){
//    $getd = mysqli_fetch_assoc(mysqli_query($con, "Select ward_name from ward where sn='$ward_id'"));
//    $ward_name = $get['ward_name'];
//}
$ward = '';
if(isset($_POST['aspirant_edit_btn'])) {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $qualification = $_POST['qualification'];
    $party = $_POST['party'];
    $post = $_POST['post'];
    $lga_id = $_POST['lga'];
    $state = $_POST['state'];
    $ward_id = $_POST['ward'];
    $religion = $_POST['religion'];
    $address = $_POST['address'];
    $form_err = false;
    if ($full_name == '' || $gender == '' || $age == '' || $qualification == ''|| $party == ''|| $post == '' || $lga_id == '' || $religion == '' || $state == '') {
        $form_err = true;
    }
    if($ward_id == ''){
        $ward_id = 0;
    }
    if (!$form_err) {
        // save the data
        if ($_FILES['passport']['name'] != '') {
            $upload_dir = 'uploads/aspirant_images/';
            $filename = $_FILES['passport']['name'];
            $v_passport = $upload_dir . '_' . time() . $filename;
            if (move_uploaded_file($_FILES['aspirant_images']['tmp_name'], $v_passport)) {

            } else {
                $upload_error = "Sorry, your image could not be uploaded, Please try again with another image.";
            }
        }

        $sql = "Update aspirant set full_name = '$full_name', gender = '$gender', age = '$age',qualification ='$qualification', party_id ='$party', post_id ='$post', lga_id ='$lga_id',ward_id ='$ward_id',
                    religion = '$religion', address = '$address', state='$state'
                    Where sn='$red[sn]'";
        mysqli_query($con, $sql) or die(mysqli_error($con));
        $success = "$full_name's record has been updated <a href='aspirant_reg.php' class='btn btn-success' > Back to Aspirant Registration Page </a>";
    }
}

function get_ward_name($aspirant_id){
    global $con;
    $df = mysqli_query($con,"Select a.sn, w.ward_name from aspirant a join ward w on a.ward_id=w.sn where a.sn='$aspirant_id'");
    $dd = mysqli_fetch_assoc($df);
    $out = $dd['ward_name'];
    return $out;
}

$post_all = mysqli_query($con, "select * from post");
$party_all = mysqli_query($con, "select * from party");
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
                                ?>
                                <input type="hidden" name="asn" value="<?=$get_id?>" >
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Full Name</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="full_name" placeholder="Surname First" class="form-control col-md-7 col-xs-12" type="text" value="<?= $full_name; ?>">
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Religion</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="religion" class="form-control">
                                            <option value="islam" <?php if($religion=='islam') echo 'selected' ?>>Islam</option>
                                            <option value="christianity" <?php if($religion=='christianity') echo 'selected' ?>>Christianity</option>
                                            <option value="other" <?php if($religion=='other') echo 'selected' ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Home Address</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="address" class="form-control col-xs-12" type="text" placeholder="Enter your permanent address" value="<?= $address?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Aspirant's Image</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file"  name="passport">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Age<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="age" required="required" class="form-control col-md-7 col-xs-12" type="text" value="<?= $age?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Highest Qualification </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="qualification" class="form-control">
                                            <option value="ssce" <?php if($qualification=='ssce') echo 'selected' ?>>SSCE</option>
                                            <option value="ond" <?php if($qualification=='ond') echo 'selected' ?>>OND</option>
                                            <option value="nce" <?php if($qualification=='nce') echo 'selected' ?>>NCE</option>
                                            <option value="hnd" <?php if($qualification=='hnd') echo 'selected' ?>>HND</option>
                                            <option value="bsc" <?php if($qualification=='bsc') echo 'selected' ?>>BSc.</option>
                                            <option value="msc" <?php if($qualification=='msc') echo 'selected' ?>>MSc.</option>
                                            <option value="btech" <?php if($qualification=='btech') echo 'selected' ?>>BTech.</option>
                                            <option value="msc" <?php if($qualification=='mtech') echo 'selected' ?>>MTech.</option>
                                            <option value="phd" <?php if($qualification=='phd') echo 'selected' ?>>Ph.D.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Party</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="party" class="form-control">
                                            <option value="">Select a party</option>
                                            <?php while($prow= mysqli_fetch_assoc($party_all)) { ?>
                                                <option value="<?= $prow['sn']?>" <?php if($party_id==$prow['sn']) echo 'selected' ?>><?= $prow['party_code']?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Post</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="post" class="form-control" id="post_select">
                                            <option value="">Select a post</option>
                                            <?php while($psrow= mysqli_fetch_assoc($post_all)) { ?>
                                                <option value="<?= $psrow['post_name']?>" <?php if($post_id==$psrow['sn']) echo 'selected' ?>><?= $psrow['post_name']?></option>
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

                                <div class="form-group" id="ward_fm_g">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ward</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="ward" class="form-control" id="ward_select">
                                            <option value="">Select a Ward</option>
                                            <?php while ($wrow = mysqli_fetch_assoc($ward_all)) { ?>
                                                <option value="<?= $wrow['sn'] ?>" <?php if($ward_id==$wrow['sn']) echo 'selected' ?>
                                                        dir="<?= $wrow['lga_id'] ?>"><?= $wrow['ward_name'] ?></option>
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

    $('#ward_select option').hide();

    $('#lga_select').change(function () {
        $('#ward_select option').hide();
        if ($('#post_select').val() == 'Councillorship') {
            var this_val = $(this).val();
            $('#ward_select option[dir=' + this_val + ']').show();
            $('#ward_fm_g').show();
        } else {
            $('#ward_select option').hide();
            $('#ward_fm_g').hide();
        }

    })
    $('#ward_fm_g').hide();
    $('select').change(function(){
        var post = $('#post_select').val();
        if(post=='Councillorship'){
            $('#ward_fm_g').show();
        }else{
            $('#ward_fm_g').hide();
        }
    })

</script>

</body>
</html>
