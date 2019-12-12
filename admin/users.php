<?php
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');


if (isset($_POST['user_submit_btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $form_err = false;
    if ($username == '' && $password=='' && !isset($_FILES['user_image'])) {
        $form_err = true;
    }
    if (!$form_err) {
        {
            $upload_dir = 'uploads/users/';
            $filename = $_FILES['user_image']['name'];
            $dest = $upload_dir . time() . '_' . $filename;
            if (move_uploaded_file($_FILES['user_image']['tmp_name'], $dest)) {
                // save data to db
                $password = md5($password);
                $sql = "INSERT into users (username,password,user_image) VALUES ('$username','$password','$dest')";
                mysqli_query($con, $sql) or die(mysqli_error($con));
                $success = "Congratulations. A new user $username has been registered";
            } else {
                $upload_error = " Sorry, your image could not be uploaded. Please try with another image.";

            }
        }
    }

}
$sel = "SELECT * from users";
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

    <title>Staff Registration</title>

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
                        <strong>Deleted!</strong> The selected post was successfully deleted.
                    </div>

                <?php } ?>

                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Staff Registration </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form method="post" class="form-horizontal form-label-left" action="users.php" enctype="multipart/form-data">
                                <?php
                                if (isset($_POST['user_submit_btn']) && $form_err) {
                                    echo "<p style='color:red'> The form is invalid. please review and submit again </p>";
                                }
                                if (isset($_POST['user_submit_btn']) && $success != '') {
                                    echo "<p style='color:green'> $success </p>";
                                }
                                ?>


                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">User Name</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text"  name="username" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Password</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="password"  name="password" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">User image</label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="user_image">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success" name="user_submit_btn">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <?php if(mysqli_num_rows($result) > 0) { ?>
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>All Registered Staff</h2>

                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <p class="text-muted font-13 m-b-30">
                                    Check the list of all registered users. You can edit and delete based on need.
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
                                                    <th>Username</th>
                                                    <th>Image</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>

                                                </tbody>

                                                <?php
                                                $counter = 1;
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $counter; ?></td>
                                                        <td><?php echo $row['username']; ?></td>
                                                        <td> <img src="<?php echo $row['user_image']; ?>" width="90px" height="90px" /></td>
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

                                                                    <li><form method="post" action="user_delete.php">
                                                                            <input type="hidden" name="us" value="<?= $row['sn'] ?>">
                                                                            <button type="submit" class="btn btn-link">Delete Record</button>
                                                                        </form>

                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $counter++;
                                                }?>

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

</body>
</html>
