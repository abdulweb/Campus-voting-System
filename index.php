<?php
// echo md5('12345678');
session_start();
if (isset($_SESSION['isadmin']) || isset($_SESSION['isstaff'])) {
    header('Location:./admin/index.php');
}
require('admin/inc/connect.inc.php');
$issuper = 'Admin';
$issuper_pass = 'pass3word';
$voter_supperPassword = "12345678";

if (isset($_POST['login_btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username == $issuper && $password == $issuper_pass) {

        session_start();
        $_SESSION['isadmin'] = 'Admin';
        header('Location:./admin/index.php');
    }
    // if ($password==$voter_supperPassword) {
    //             $qury = mysqli_query($con, "select * from registeration where voter_id = '$username'");
    //             $result = mysqli_num_rows($qury);
    //             if($result==1){
    //                 $row = mysqli_fetch_assoc($qury);
    //                 $_SESSION['isvoter'] = $row['voter_id'];
    //                 //header('Location:index.php');
    //             }
                

    // } 
    if ($username != '' && $password != '') {
        //staff account
        $md5pass = md5($password);
        $sql = mysqli_query($con, "Select * from users where username='$username' and password='$md5pass'");
        if (mysqli_num_rows($sql) == 1) {
            //loggin
            //A staff or a voter has logged in successfully. Check the privilege on the users table to confirm
            //what type of user this person is.
            $p_result = mysqli_query($con, "select privilege from users where username='$username'");
            $p_row = mysqli_fetch_assoc($p_result);
            $privilege = $p_row['privilege'];
            session_start();
            if ($privilege == 'STAFF') {
                $row = mysqli_fetch_assoc($sql);
                $_SESSION['isstaff'] = $row['username'];
                header('Location:./admin/index.php');
            } else if ($privilege == 'VOTER') {
                $row = mysqli_fetch_assoc($sql);
                $_SESSION['isvoter'] = $row['username'];
                header('Location:./admin/index.php');

            }


        } else {
            $invalid_credentials = true;
        }
    } else {
        $invalid_credentials = true;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <title>E-VOTING SYSTEM</title>
    <!-- Image slider plugin styles-->
    <!-- CSS  -->
    <link href="css/icon.css" rel="stylesheet">
    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="PgwSlider-master/pgwslider.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <style>
        body {
            font-size: 1rem;
            font-family: 'Roboto Condensed', sans-serif;
        }

        p {
            line-height: 24px !important;
        }
    </style>
    <style>
        .card-icon {
            width: 100px;
            height: 100px;
            background-color: #ef9a9a;
            border-radius: 50px;
            border: 2px solid #f05a66;
            text-align: center;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.4);
            line-height: 130px;
            margin: -70px auto 0px;
        }

        .top-card {
            margin-top: 50px;
            border: 2px solid #ef9a9a;
            border-radius: 5px;
            text-align: center;
            height: 320px;
        }

        .card-icon img {
            width: 50px;
            height: 50px;

        }

        .flip img {
            width: 95%;
            height: 95%;
        }

        .flip .back {
            text-align: center;
        }
        .invalid_danger{
            color: red;
            margin-left: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include('home_inc/head.php');?>
<div class="fix-header"></div>

<div class="full-width content_height">
    <div class="half-width content_height">
        <img src="images/campus4.jpg" class="content_height">
    </div>
    <div class="half-width content_height">
        <div class="container container-extended margin-top-20">

            <div class="row">

                <div class="col s12">

                    <div class="card">
                        <div class="card-content">
                            <div class="card-title"><h5 style="text-align: center">Login To Access The System</h5></div>

                            <div class="row">
                            <div>
                                    <?php 
                                    if (isset($invalid_credentials)) {?>
                                        <div class ="alert invalid_danger"> Wrong Username or Password </div>
                                    <?php 
                                    }
                                    ?>
                                </div>
                                <form class="col s12" method="post" action="">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="first_name" name="username" type="text" class="validate">
                                            <label for="first_name" data-error="Please enter a username"
                                                   data-success="ok">Username</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input type="password" id="password" name="password" type="text"
                                                   class="validate">
                                            <label for="password" data-error="Enter your last name" data-success="ok">Password</label>
                                        </div>

                                        <button class="btn waves-effect waves-light" style="float: right" type="submit"
                                                name="login_btn">Submit
                                        </button>
                                        <p class="pull-right">Not a Member? <a href="signUp.php"> Click Here</a><p>

                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                   
                </div>

            </div>

        </div>
    </div>
</div>

<?php include('home_inc/foot.php');?>

<!--  Scripts-->
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
<script src="PgwSlider-master/pgwslider.min.js"></script>
<script>
    $(document).ready(function () {
        $('.pgwSlider').pgwSlider({
            transitionEffect: 'sliding',
            displayControls: true,
            adaptiveHeight: true,
            intervalDuration: 5000
        });
    });
</script>
<script src="js/jquery.flip.min.js"></script>
<script>
    $(function () {
        $(".flip-x").flip({
            trigger: 'hover',
            axis: 'x'
        });
        $(".flip-y").flip({
            trigger: 'hover'
        });
    });
</script>

</body>
</html>

