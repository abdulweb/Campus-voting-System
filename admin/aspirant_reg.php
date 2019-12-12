<?php
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');

$ward = '';
if (isset($_POST['aspirant_submit_btn'])) {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $qualification = $_POST['qualification'];
    $party = $_POST['party'];
    $post = $_POST['post'];
    $lga = $_POST['lga'];
    $ward = $_POST['ward'];
    $religion = $_POST['religion'];
    $address = $_POST['address'];
    $form_err = false;
    if ($full_name == '' || $gender == '' || $age == '' || $qualification == '' || $party == '' || $post == '' || $lga == '' || $religion == '' || $address == '') {
        $form_err = true;
    }
    if (!$form_err) {
        $upload_dir = 'uploads/aspirant_images/';
        $filename = $_FILES['passport']['name'];
        $dest = $upload_dir . '_' . time() . $filename;
        if (move_uploaded_file($_FILES['passport']['tmp_name'], $dest)) {
            //save data to db
            $post_check = mysqli_fetch_assoc(mysqli_query($con, "select sn from post where post_name = '$post'"));
            $sql = "INSERT into aspirant (full_name,gender,age,qualification,passport,post_id,party_id,lga_id,ward_id,religion,address)
                VALUES ('$full_name','$gender','$age','$qualification','$dest','$post_check[sn]','$party','$lga','$ward','$religion','$address')";
            mysqli_query($con, $sql) or die(mysqli_error($con));
            $success = "Congratulations, a new aspirant $full_name has been created";

        } else {
            $upload_error = "Sorry, your image could not be uploaded, Please try again with another image.";
        }
    }
}
function get_ward_name($aspirant_id)
{
    global $con;
    $df = mysqli_query($con, "Select a.sn, w.ward_name from aspirant a join ward w on a.ward_id=w.sn where a.sn='$aspirant_id'");
    $dd = mysqli_fetch_assoc($df);
    $out = $dd['ward_name'];
    return $out;
}

$sel = "SELECT *, a.sn, c.party_name, c.party_code,c.party_logo, ps.post_name, lg.lga from aspirant a   JOIN party c on a.party_id=c.sn join post ps on a.post_id = ps.sn join lga lg  on a.lga_id=lg.sn ";
$result = mysqli_query($con, $sel) or die(mysqli_error($con));

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

    <title>Aspirant Registration</title>

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
        #lga_fm_g, #ward_fm_g {
            display: none;
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

                <?php if ($_GET['vd']) { ?>

                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span>
                        </button>
                        <strong>Deleted!</strong> The selected voter was successfully deleted.
                    </div>

                <?php } ?>

                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Aspirant Registration Form </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>

                            <form method="post" action="aspirant_reg.php" class="form-horizontal form-label-left"
                                  enctype="multipart/form-data">
                                <?php
                                if (isset($_POST['aspirant_submit_btn']) && $form_err) {
                                    echo "<p style='color:red'> The form is invalid. please review and submit again </p>";
                                }
                                if (isset($_POST['aspirant_submit_btn']) && $success != '') {
                                    echo "<p style='color:green'> $success </p>";
                                }
                                ?>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Full Name</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="full_name" placeholder="Surname First"
                                               class="form-control col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="gender" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Religion</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="religion" class="form-control">
                                            <option value="islam">Islam</option>
                                            <option value="christianity">Christianity</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Home Address</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="address" class="form-control col-xs-12" type="text"
                                               placeholder="Enter your permanent address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Aspirant's Image</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="passport" col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Age<span
                                            class="required">*</span></label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="age" required="required" class="form-control col-md-7 col-xs-12"
                                               type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Highest
                                        Qualification </label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="qualification" class="form-control">
                                            <option value="ssce">SSCE</option>
                                            <option value="ond">OND</option>
                                            <option value="hnd">HND</option>
                                            <option value="nce">NCE</option>
                                            <option value="bsc">BSc.</option>
                                            <option value="msc">MSc.</option>
                                            <option value="btech">BTech.</option>
                                            <option value="mtech">MTech.</option>
                                            <option value="phd">Ph.D.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Party</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="party" class="form-control">
                                            <option value="">Select a party</option>
                                            <?php while ($prow = mysqli_fetch_assoc($party_all)) { ?>
                                                <option value="<?= $prow['sn'] ?>"><?= $prow['party_code'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Post</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="post" class="form-control" id="post_select">
                                            <option value="">Select a post</option>
                                            <?php while ($psrow = mysqli_fetch_assoc($post_all)) { ?>
                                                <option
                                                    value="<?= $psrow['post_name'] ?>"><?= $psrow['post_name'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="state_fm_g">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">State of Origin</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="state_origin" class="form-control" id="state_select">
                                            <option value="">Select a State</option>
                                            <?php while ($srow = mysqli_fetch_assoc($state_all)) { ?>
                                                <option value="<?= $srow['name'] ?>"><?= $srow['name'] ?></option>
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
                                                <option value="<?= $lrow['sn'] ?>"
                                                        dir="<?= $lrow['name'] ?>"><?= $lrow['name'] . ' ' . $lrow['lga'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                $('#lga_fm_g').show();
    $('#lga_select option').hide();
    $('#state_select').change(function () {
        $('#lga_select option').hide();
        var this_val = $(this).val();
        $('#lga_select option[dir=' + this_val + ']').show();
        $('#lga_fm_g').show();
    })

                                <div class="form-group" id="ward_fm_g">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ward</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="ward" class="form-control" id="ward_select">
                                            <option value="">Select a Ward</option>
                                            <?php while ($wrow = mysqli_fetch_assoc($ward_all)) { ?>
                                                <option value="<?= $wrow['sn'] ?>"
                                                        dir="<?= $wrow['lga_id'] ?>"><?= $wrow['ward_name'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success" name="aspirant_submit_btn">
                                            Submit
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">
                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>All Aspirants</h2>

                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <p class="text-muted font-13 m-b-30">
                                    Check the list of all registered aspirants. You can edit and delete based on need.
                                </p>

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
                                                    <th>Full Name</th>
                                                    <th>Party</th>
                                                    <th>Post</th>
                                                    <th>LGA</th>
                                                    <th>Image</th>
                                                    <th>Action</th>

                                                </tr>
                                                </thead>

                                                </tbody>

                                                <?php
                                                $counter = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $counter; ?></td>
                                                        <td><?php echo $row['full_name']; ?></td>
                                                        <td><?php echo $row['party_code']; ?></td>
                                                        <td><?php echo $row['post_name']; ?></td>
                                                        <td><?php echo $row['lga']; ?>
                                                            <?php
                                                            if ($row['post_name'] == 'Councillorship') {
                                                                $asp_id = $row['sn'];
                                                                $w_na = get_ward_name($asp_id);
                                                                echo "($w_na)";
                                                            }
                                                            ?>

                                                        </td>
                                                        <td><img src="<?php echo $row['passport']; ?>" width="100px"
                                                                 height="100px"></td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-primary">Action
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-primary dropdown-toggle"
                                                                        data-toggle="dropdown" aria-expanded="false">
                                                                    <span class="caret"></span>
                                                                    <span class="sr-only">Action Menu</span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li>
                                                                        <form method="post" action="aspirant_edit.php">
                                                                            <input type="hidden" name="asn"
                                                                                   value="<?= $row['sn'] ?>">
                                                                            <button type="submit" class="btn btn-link">
                                                                                Edit Record
                                                                            </button>
                                                                        </form>

                                                                    </li>
                                                                    <li>
                                                                        <form method="post"
                                                                              action="aspirant_delete.php">
                                                                            <input type="hidden" name="asn"
                                                                                   value="<?= $row['sn'] ?>">
                                                                            <button type="submit" class="btn btn-link">
                                                                                Delete Record
                                                                            </button>
                                                                        </form>

                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $counter++;
                                                } ?>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
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
</script>
</body>
</html>
