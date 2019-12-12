<?php
session_start(); require 'admin/inc/connect.inc.php';
if(!isset($_SESSION['isvoter'])){
    header('Location:/evoting/admin/logout');
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
        
    </style>
</head>
<body >
<?php include('home_inc/head.php');?>
<div class="fix-header"></div>

<div class="full-width content_height" >

    <div class="full-width content_height  hsty" >
        <div class="container container-extended margin-top-20">

            <div class="row">

               
                                <!--php script -->
                       <?php
/**
 * Created by PhpStorm.
 * User: Abu Sumayyah
 * Date: 27-Mar-17
 * Time: 2:46 PM
 */
require 'admin/inc/connect.inc.php';
session_start();
//declaring an empty variable
$aspirant_Name =' ';
$postiton_Name = '';
// post from previous page
    $voter_Name = $_SESSION['isvoter'];
    //$postiton_id = $_POST['post_name'];
    // getting the name of the post
    

$get_id = $_POST['post_id'];
$ppost_nam = $_POST['post_name'];
$asp_name = $_POST['fname'];

                                                        //chechk if voter has vote before


                                         $sqls = mysqli_query($con, "SELECT * FROM vote where Voters_Name = '$voter_Name' AND post_id ='$get_id' ");
                                         //$res = mysqli_query($con, "Select * from aspirant where sn='$get_id'");
                                            $res = mysqli_num_rows($sqls);
                                            if ($res ==1) {
                                                # code...
                                                                                         
                                                //what type if aspirant post been vote b4.
                                                
                                                    echo  '<h4 style="color:red; margin:80px;"> Sorry You Can not vote an aspirant for <strong >'.$ppost_nam.'</strong> more than one time. But you can  vote an ASPIRANT for Another position.
                                                    </br> <a href ="voting_page.php">Click Here </a>to vote for another position</h4>';
                                                    //header('Location:./admin/index.php');
                                                }
                                            else{
                                                        
                                                         
                                                         $action = "Voted";
                                                  $sql =mysqli_query($con, "INSERT into `vote`(`Voters_Name`,`Aspirant`,`post_name`,`post_id`,`Action`)values('$voter_Name','$asp_name','$ppost_nam','$get_id','$action')");

                                                        
                                                       // return this if not inserted into vote  table
                                                        if (!$sql) {
                                                            echo  "voting failed!!!. Please  <a href ='voting_page.php'>Click Here</a> to re-cast your vote"; //. mysqli_error($con);
                                                        }
                                                        else{
                                                        header('Location: voting.php?vd=true');
                                                    }
                                                    }

                                            

                                                                                                
                                                                                                
                                                                                               
?>

                        
                   
                    

        

            </div>

        </div>
    </div>
</div>


<?php include('home_inc/foot.php');?>


<!--script-->
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
<script src="PgwSlider-master/pgwslider.min.js"></script>

</body>
</html>

