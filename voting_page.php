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
                <div class="col s12 m12 l4">
                    <h5 class="title">ELECTION VOTING DATES</h5>

                    <div class="col s12">
                        <div class="card horizontal">
                            <div class="card-image schedule_img">
                                <!--<img src="http://lorempixel.com/100/190/nature/6">-->
                                <div class="wrap_schedule_date">
                                    
                                </div>
                            </div>
                            <div class="card-stacked">
                                <!--<div class="card-content">
                                    <p>School Opens on nov 13</p>

                                    <p>School Opens on nov 13</p>

                                    <p>School Opens on nov 13</p>
                                </div> -->
                                <!--PHP script-->
                                <div class="card-content">
                                    <?php
                                        
                                   $query = "SELECT * FROM election_date";
                                       //$print = $query;
                                         $result = mysqli_query($con, $query);
                                         if (!$result) {
                                          # code...
                                          echo"record not fetch";
                                         }
                                         
                                        $n = mysqli_num_rows($result);
                                        if($n>0){
                                            echo '<table >';
                                                            echo '<thead>';
                                                            echo '<th style="font-size:0.8em;">'.'Start Date'.'</th>';
                                                            echo '<th style="font-size:0.8em;">'.'End Date'.'</th>';
                                                            echo '</thead>';

                                                            while ($row =mysqli_fetch_assoc($result)) {
                                                              # code...
                                                              echo '<tr>
                                                                    <td style="font-size:0.8em;">' . $row['start_date'] . '</td>
                                                                     <td style="font-size:0.8em;">' . $row['end_date'].'</td>

                                                                     
                                                                    </tr>';
                                                                }
                                                                    echo '</table>';
                                                                }
                                        
                                    ?>
                                    
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col s12 m12 l8">
                                <!--php script -->
                        <?php 

                                 
                            
                                $query = mysqli_query($con, "select start_date, end_date, post_id from election_date");
                                $result = mysqli_num_rows($query);
                                if ($result > 0) {
                                    while ($rows = mysqli_fetch_assoc($query)) {
                                        $post_id = $rows['post_id'];
                                        $valid_date_end = $rows['end_date'];

                                        //get post id name
                                $sql = mysqli_query($con, "select post_name from post where sn = '$post_id'");
                                $res = mysqli_num_rows($sql);
                                $data = mysqli_fetch_assoc($sql);
                                $post_name_get = $data['post_name'];
                                 //get today date
                                 $get_todays_date = date('Y-m-d');
                                // echo $post_id;

                                        if ($get_todays_date <= $rows['end_date']){
                                    
                                
                           ?> 
                        
                    <div style="padding:50px 20px;text-align: center">
                        
                        
                        <h4> <?php echo $post_name_get;?> Voting  is on !!!!</h4>
                        <form action="voting.php" method="POST">
                            <input type="hidden" id="pid" name="pid" value="<?= $post_id; ?>">
                            <input type="hidden" id="ptname" name="ptname" value="<?= $post_name_get ?>">
                            <button type="submit" class="btn waves-effect waves-light" style="height: 90px;">Vote Now</button>
                             
                        </form>
                        <?php }
                        else{
                                echo "<h4> $post_name_get Voting Date has been closed!!!.";
                            }
                       
                    }
                     
                }
                            
                         ?>
                    </div>
                    

                </div>

            </div>

        </div>
    </div>
</div>


<?php include('home_inc/foot.php');?>



    
</script>

<!--script-->
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
<script src="PgwSlider-master/pgwslider.min.js"></script>

</body>
</html>

