<?php
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');


if (isset($_POST['post_submit_btn'])) {
    $post_name = $_POST['post_name'];
        $form_err = false;
    if ($post_name == '') {
        $form_err = true;
    }
    if (!$form_err) {
       {
            // save data to db
            $sql = "INSERT into post (post_name) VALUES ('$post_name')";
            mysqli_query($con, $sql) or die(mysqli_error($con));
            $success = "Congratulations. A new party $post_name has been registered";
        }
        }

}
$sel = "SELECT * from post";
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

    <title>Post Registration</title>

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

                <div class="col-md-6">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Post Registration Form </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form method="post" class="form-horizontal form-label-left" action="post.php" enctype="multipart/form-data">
                                <?php
                                if (isset($_POST['post_submit_btn']) && $form_err) {
                                    echo "<p style='color:red'> The form is invalid. please review and submit again </p>";
                                }
                                if (isset($_POST['post_submit_btn']) && $success != '') {
                                    echo "<p style='color:green'> $success </p>";
                                }
                                ?>


                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Post Name</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text"  name="post_name" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success" name="post_submit_btn">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <?php if(mysqli_num_rows($result) > 0) { ?>
                    <div class="col-md-6">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>All Available Posts</h2>

                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <p class="text-muted font-13 m-b-30">
                                    Check the list of all registered posts. You can edit and delete based on need.
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
                                                    <th>Post Name</th>
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
                                                        <td><?php echo $row['post_name']; ?></td>
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
                                                                        <form method="post" action="post_edit.php">
                                                                            <input type="hidden" name="pn" value="<?= $row['sn'] ?>">
                                                                            <button type="submit" class="btn btn-link">Edit Record</button>
                                                                        </form>

                                                                    </li>
                                                                    <li><form method="post" action="post_delete.php">
                                                                            <input type="hidden" name="pn" value="<?= $row['sn'] ?>">
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

<!-- Custom Theme Scripts -->
<script src="./build/js/custom.min.js"></script>

</body>
</html>
