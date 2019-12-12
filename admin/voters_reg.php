<?php
require_once('inc/ensure_login.php');
    require('inc/connect.inc.php');

function generate_voters_id(){
    global $con;
    $prefix= "V";
    $gen = '';
    for($i=1; $i<=18; $i++){
        $gen .= rand(1,9);
    }
    $proposed_v_n = $prefix.$gen;
    //setting default password for VOTERS
    $voters_def_pass = "12345678";
    //check if voter id exist in db
    $rd = mysqli_query($con,"Select voter_id from registeration where voter_id='$proposed_v_n'");
    if(mysqli_num_rows($rd) > 0){
        generate_voters_id();
    }else{
        return $proposed_v_n;
    }
}
if(isset($_POST['voter_submit_btn'])){
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
    $nationality= $_POST['nationality'];
    $state_origin= $_POST['state_origin'];
    $lga= $_POST['lga'];
    $ward= $_POST['ward'];
    $religion= $_POST['religion'];
    $form_err= false;
    if($fname == '' || $mname == '' || $lname == '' || $address == '' || $gender == '' || $dob == '' || $age == '' || $status == '' ||
        $email_id == '' || $email_id == '' || $phn_no == '' || $nationality == '' || $state_origin == '' || $lga == '' || $ward == '' ||
        $occupation == '' || $religion == ''){
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
                $sql= "INSERT into registeration (fname,mname,lname,address,gender,dob,age,status,email_id,phn_no,nationality,
                    state_origin,lga,ward,occupation,passport,voter_id,religion) VALUES ('$fname','$mname','$lname','$address','$gender','$dob',$age,'$status','$email_id',
                    '$phn_no','$nationality','$state_origin','$lga',$ward,'$occupation','$dest','$votr_id','$religion')";
                mysqli_query($con, $sql) or die(mysqli_error($con));
                $md5pass = md5('password');
                mysqli_query($con, "insert into users(username, password, privilege, user_image) VALUES ('$votr_id', '$md5pass', 'VOTER', '$dest')") or die(mysqli_error($con));
                $success= "Congratulations, a new voter $fname $mname $lname has been created. Your Password is $voters_def_pass";
            }

        }else {
            $upload_error= "Sorry, your image could not be uploaded, Please try again with another image.";
        }
    }

}

$sel= "SELECT * from registeration";
$result= mysqli_query($con,$sel);

$ward_all = mysqli_query($con, "select * from ward");
$sch_ward = mysqli_query($con, "Select* from school_ward");
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

                <?php if($_GET['vd']){ ?>

                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Deleted!</strong> The selected voter was successfully deleted.
                </div>

                <?php } ?>

                <div class="col-md-4">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Voter Registration Form </h2>

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
                                        <input name="email_id" class="form-control col-xs-12" type="email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12">Phone Number</label>
                                    <div class="col-xs-12">
                                        <input name="phn_no" class="form-control col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Home Address</label>
                                    <div class="col-xs-12">
                                        <input name="address" class="form-control col-xs-12" type="text" placeholder="Enter your permanent address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Occupation</label>
                                    <div class="col-xs-12">
                                        <input name="occupation" class="form-control col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Date of Birth</label>
                                    <div class="col-xs-12">
                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                                        <input name="dob" type="text" class="form-control has-feedback-left" id="single_cal4" placeholder="Date of birth" aria-describedby="inputSuccess2Status4">
                                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                        <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12">Age<span class="required">*</span></label>
                                    <div class="col-xs-12">
                                        <input name="age" required="required" class="form-control col-xs-12" type="text">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Marital Status </label>
                                    <div class="col-xs-12">
                                        <select name="status" class="form-control">
                                            <option value="single">Single</option>
                                            <option value="married">Married</option>
                                            <option value="divorced">Divorced</option>
                                            <option value="widow">Widow</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Religion</label>
                                    <div class="col-xs-12">
                                        <select name="religion" class="form-control">
                                            <option value="islam">Islam</option>
                                            <option value="christianity">Christianity</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12">Gender </label>
                                    <div class="col-xs-12">
                                        <select name="gender" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
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

                                <div class="form-group" id="ward_fm_g">
                                    <label class="control-label col-xs-12">Ward</label>
                                    <div class="col-xs-12">
                                        <select name="ward" class="form-control" id="ward_select">
                                            <option value="">Select a Ward</option>
                                            <?php while($wrow= mysqli_fetch_assoc($sch_ward)) { ?>
                                                <option value="<?= $wrow['sn']?>" dir="<?=$wrow['lga_id']?>"><?= $wrow['ward_Name']?></option>
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
                <div class="col-md-8">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>All Registered Voters</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                                Check the list of all registered voters. You can edit and delete based on need.
                            </p>

                            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="datatable"
                                               class="table table-striped table-bordered dataTable no-footer"
                                               role="grid" aria-describedby="datatable_info">
                                            <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Full Name</th>
                                                <th>Voter's ID</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                            <?php
                                            $counter = 1;
                                            while($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo $row['fname']. ' '.$row['mname'].' '. $row['lname']; ?></td>
                                                    <td><?php echo $row['voter_id']; ?></td>
                                                    <td> <img src="<?php echo $row['passport']; ?>" width="90px" height="90px" /></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary">Action</button>
                                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                <span class="caret"></span>
                                                                <span class="sr-only">Action Menu</span>
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu">
                                                                <li><a href="voter_edit.php?v=<?= $row['sn'] ?>">Edit Record</a>
                                                                </li>
                                                                <li><a href="voter_delete.php?v=<?= $row['sn'] ?>">Delete Record</a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                                $counter++;
                                            } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">

                                </div>
                            </div>
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


    $('#ward_select option').hide();
    $('#lga_select').change(function(){
        $('#ward_select option').hide();

            var this_val = $(this).val();
            $('#ward_select option[dir='+this_val+']').show();
            $('#ward_fm_g').show();
    })

</script>
</body>
</html>
