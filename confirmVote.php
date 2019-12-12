<?php
    require 'admin/inc/connect.inc.php';
    session_start();
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
    </style>
</head>
<body>
<nav class="white nav-fixed" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="website:index" class="brand-logo"><span class="rodab">E-VOTING</span>
            SYSTEM</a>
        <ul class="right hide-on-med-and-down navbar-list-ul">
            <li><a href="{% url 'website:index' %}">Home</a></li>
            <li><a href="{% url 'website:news' %}">News</a></li>
            <li><a href="{% url 'website:gallery' %}">Gallery</a></li>
            <li><a href="{% url 'website:contact' %}">Contact Us</a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
            <li><a href="{% url 'website:index' %}">Home</a></li>
            <li><a href="{% url 'website:news' %}">News</a></li>
            <li><a href="{% url 'website:gallery' %}">Gallery</a></li>
            <li><a href="{% url 'website:contact' %}">Contact Us</a></li>
        </ul>
    
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">Menu</i></a>
    </div>
</nav>
<div class="fix-header"></div>

<div class="full-width content_height">

    <div class="full-width content_height">
        <div class="container container-extended margin-top-20">

            <div class="row">

                <div class="col s12 m12">

                    <div class="card">
                        <div class="card-content">
                            <div class="card-title"><h5 style="text-align: center">Click on your aspirant choice image or party logo to vote</h5></div>
                            

                            <div class="row">
                                 <div class="card white top-card">
                                      <div class="confrim_vote">
                                          <?php
                                          session_start();
                                          
                                          $sql = "SELECT * FROM aspirant";
                                          $query = mysqli_query($con, $sql);
                                          if (!query) {
                                              echo "not selected";
                                          }
                                          $result = mysqli_num_rows($query);
                                          if ($result > 0) {
                                              
                                             echo '<table border="30" style="border:2px solid gray; border-radius:30px; margin-left:2px;"> ';
                                            echo '<thead>';
                                            echo '<th style="text-align: left; font-size: 15px;font-weight: bold;border-bottom: 2px solid gray;">'.'ASPIRANT NAME'.'</th>';
                                            echo '<th style="text-align: left; font-size: 15px;font-weight: bold;border-bottom: 2px solid gray;">'.'GENDER'.'</th>';
                                            echo '<th style="text-align: left; font-size: 15px;font-weight: bold;border-bottom: 2px solid gray;">'.'PARTY'.'</th>';
                                            echo '<th style="text-align: left; font-size: 15px;font-weight: bold;border-bottom: 2px solid gray;">'.'PARTY LOGO'.'</th>';
                                            echo '<th style="text-align: left; font-size: 15px;font-weight: bold;border-bottom: 2px solid gray;">'.'POST'.'</th>';
                                            echo '<th style="text-align: left; font-size: 15px;font-weight: bold;border-bottom: 2px solid gray;">'.'ACTION'.'</th>';
                                         
                                            echo '</thead>';

                                             while ($rows = mysqli_fetch_assoc($query)) {
                                                    if ($rows['party_id'] == 14) {
                                                        $partyName = "People's Democratic Party";
                                                        //$party_abb = 'PDP';
                                                            $sql = mysqli_query($con,"select * from party where `sn` = 14");
                                                            $result1 = mysqli_fetch_assoc($sql);
                                                            $image = $result1['party_logo']; 

                                                    }
                                                    elseif ($rows['party_id'] == 18) {
                                                        $partyName = "All Progessive Congress (APC)";
                                                           $sql = mysqli_query($con,"select * from party where `sn` = 18");
                                                            $result1 = mysqli_fetch_assoc($sql);
                                                            $image = $result1['party_logo']; 
                                                    }
                                                    elseif ($rows['party_id'] == 19) {
                                                        $partyName = "Labour Party (LP)";
                                                        $sql = mysqli_query($con,"select * from party where `sn` = 19");
                                                            $result1 = mysqli_fetch_assoc($sql);
                                                            $image = $result1['party_logo']; 
                                                    }
                                                    elseif ($rows['party_id'] == 20) {
                                                        $partyName = "Accord (ACD)";
                                                        $sql = mysqli_query($con,"select * from party where `sn` = 20");
                                                            $result1 = mysqli_fetch_assoc($sql);
                                                            $image = $result1['party_logo']; 
                                                    }
                                                    if ($rows['post_id'] == 12) {
                                                        $postName = "Chairmanship";
                                                    }
                                                    elseif ($rows['post_id'] == 14) {
                                                        $postName = "Councillorship";
                                                    }
                                                    else $postName ="UNKOWN" ;

                                                    $dir = $rows['passport'];
                                                

                                echo '<tr>
                                <td class="txtLeft" style="padding: 15px 12px;font-size: 12px;border-bottom: 2px solid gray;"">' . $rows['full_name']. '</td>
                                 <td class="txtLeft" style="padding: 5px 2px;font-size: 12px;border-bottom: 2px solid gray;">' . $rows['gender'] . '</td>
                                  <td class="txtLeft" style="padding: 5px 2px;font-size: 12px;border-bottom: 2px solid gray;">' . $partyName. '</td>
                                  <td class="txtLeft" style="padding: 5px 2px;border-bottom: 2px solid gray; ">' ."<img src='./admin/$image' style='height: 30px;'>" . '</td>
                                  <td class="txtLeft" style="padding: 5px 2px;font-size: 12px;border-bottom: 2px solid gray;">' . $postName . '</td>
                                  <td class="txtLeft" style="padding: 5px 2px;font-size: 12px;border-bottom: 2px solid gray;"><button type="button" class="btn btn-success" name ="vote_button">Vote</button></td>
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
   
    

<!--  Scripts-->
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
<script src="PgwSlider-master/pgwslider.min.js"></script>

</body>
</html>
