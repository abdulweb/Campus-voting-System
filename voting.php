<?php
   require 'admin/inc/connect.inc.php';
   session_start();
  $get_post_name = $_POST['ptname'];

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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
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
            cursor: pointer;

        }

        .flip img {
            width: 95%;
            height: 95%;
        }

        .flip .back {
            text-align: center;
        }
        .card-title{
            font-size: 12px;
        }
        .error{
            color: red;
        }
        .content_height{
            height: auto;
        }
    </style>
</head>
<body>
<nav class="white nav-fixed" role="navigation">
    <?php include('home_inc/head.php');?>
</nav>
<div class="fix-header"></div>

<div class="full-width content_height">

    <div class="full-width content_height">
        <div class="container container-extended margin-top-20">

            <div class="row">
            <!---->
                <?php if($_GET['vd']){ ?>

                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong style="font-weight: bolder;">Thanks, Your Vote has been cast:<a href="voting_page.php">Click Here to vote for another post</a></strong> .
                    </div>
                        <div><?php echo $check;?></div>

                <?php } ?>

                <div class="col s12 m12">

                    <div class="card">
                        <div class="card-content">
                            <div class="card-title"><h5 style="text-align: center">Click on the aspirant <span style="font-weight: bold;">vote</span> button below to cast your vote for <?php echo $get_post_name;?></h5></div>
                            <div id="user_list"></div>

                            <div class="row">

                                    <?php
                                    // checking if user has voted b4
                                         $get_post_id = $_POST['pid']; 
                                        
                                    //
                                     // echo $get_post_id; 
                                    //echo $_POST['ptname'];
                                    $sql = "SELECT * FROM aspirant";
                                    $query = mysqli_query($con, $sql);
                                    $result = mysqli_num_rows($query);
                                    if ($result < 0) {
                                        echo "<p> No ASPIRANT IS AVALABLE. ASPIRANT HAS BEEN REGISTERED</p>";
                                    }
                                    else{
                                        while ($rows = mysqli_fetch_assoc($query)) {
                                            $data_id = $rows['party_id'];
                                             $dir = $rows['passport'];

                                            $queryy = mysqli_query($con, "select party_name, party_code from party where sn ='$data_id' ");
                                            $res = mysqli_num_rows($queryy);
                                            if ($res>0) {
                                                while ($dataa = mysqli_fetch_assoc($queryy)) {
                                                    $party_id = $dataa['party_code'];
                                                    $party_Name = $dataa['party_name'];
                                                }
                                            }
                                           
                                            

                                           

                                            
                                            
                                            
                                    ?>
                                            
                                      
                                <div class="col s12 m6 l3">
                                    <div class="card white top-card">
                                        <div class="card-content ">
                                            
                                            <div class="card-icon" >
                                            <form method="POST" action="vote_sql.php" class="vt_fm">
                                             <?php echo "<img src='./admin/$dir'>";?>
                                            <input type="hidden" id="fname" name="fname" value="<?= $rows['full_name'] ?>">
                                            <input type="hidden" id="post_name" name="post_name" value="<?= $get_post_name ?>">
                                            
                                            <input type="hidden" id="post_id" name="post_id" value="<?= $get_post_id ?>">
                                            
                                            <p><button type="button" class="btn btn-success submitBtn" onclick="myfunction($(this))" style="margin-top:185px;">Vote</button></p>
                                            </form>
                                            </div>
                                            <div class="card-title"  style="font-size: 17px;"> 
                                            <?php echo '<span style="font-weight:bold; ">NAME: </span>'.''.'<span>'.$rows['full_name'].'</span>' ;
                                                
                                               
                                            ?>

                                            </div>
                                            <p><?php echo '<span style="font-weight:bold;">GENDER: </span>'.''.$rows['gender'];?></p>
                                            <p><?php echo '<span style="font-weight:bold;">QUALIFICATION: </span>'.''.$rows['qualification'];?></p>
                                            <p><?php echo '<span style="font-weight:bold;">AGE: </span>'.''.$rows['age'];?></p>
                                            <p><?php echo '<span style="font-weight:bold;">PARTY: </span>'.''.$party_id;?></p>
                                            
                                            
                                            <p> <?php //echo 'id'.$rows['sn']; $_SESSION['id'];?></p>

                                            
                                        </div>
                                    </div>
                                </div> 
                                    <?php   }
                                    }
                                
                                    ?>
                               <!--Something is remove from here-->
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


<footer class="page-footer bg-rodab" style="float: left;width: 100%; padding-top: 0 !important;">
    <div class="footer-copyright">
        <div class="container">
            Made by <a class="brown-text text-lighten-3" href="http://highcontech.com">Highcon Technologies</a>
        </div>
    </div>
</footer>
   
    
<script type="text/javascript">
 function myfunction(obj){
    var r = confirm("Are u Sure You Want To Cast Your Vote");
    if(r ){
        obj.parents('form').submit();
    }
 }

</script>
<!--  Scripts-->
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
<script src="PgwSlider-master/pgwslider.min.js"></script>

</body>
</html>

