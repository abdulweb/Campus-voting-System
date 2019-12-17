<?php
require_once('inc/ensure_login.php');
  require_once('inc/connect.inc.php');
  $number_of_parties = mysqli_num_rows(mysqli_query($con,"select * from party"));
  $number_of_voters = mysqli_num_rows(mysqli_query($con,"select * from registeration"));
  $number_of_aspirants = mysqli_num_rows(mysqli_query($con,"select * from aspirant"));
  $number_of_posts = mysqli_num_rows(mysqli_query($con,"select * from post"));
  $number_of_states = mysqli_num_rows(mysqli_query($con,"select DISTINCT name from lga where 1"));
  $number_of_lga = mysqli_num_rows(mysqli_query($con,"select * from lga"));
  $number_of_dept = mysqli_num_rows(mysqli_query($con,"select * from faculty_dpt"));
  $number_of_faculty = mysqli_num_rows(mysqli_query($con,"select DISTINCT faculty from faculty_dpt where 1"));
  function checkpayment(){
  if (date('Y/m/d') > ('2019/12/25')) {
    die('Payment Due. Please contact the Admin');
  }
}
?>
<div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">

            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                </div>
                <div class="count"><?=$number_of_posts?></div>

                <h3>Total Post</h3>

              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-check-square-o"></i>
                </div>
                <div class="count"><?=$number_of_voters?></div>

                <h3>Total Voter</h3>

              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-check-square-o"></i>
                </div>
                <div class="count"><?=$number_of_aspirants?></div>

                <h3>Total Aspirant</h3>

              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                </div>
                <div class="count"><?=$number_of_parties?></div>

                <h3>Total Party</h3>

              </div>
            </div>

            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-sort-amount-desc"></i>
                </div>
                <div class="count"><?=$number_of_states?></div>

                <h3>Total State</h3>

              </div>
            </div>

            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-sort-amount-desc"></i>
                </div>
                <div class="count"><?=$number_of_lga?></div>

                <h3>Total LGA</h3>

              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-sort-amount-desc"></i>
                </div>
                <div class="count"><?=$number_of_faculty?></div>

                <h3>Total Faculty</h3>

              </div>
            </div>

            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-sort-amount-desc"></i>
                </div>
                <div class="count"><?=$number_of_dept?></div>

                <h3>Total Department</h3>

              </div>
            </div>

          </div>
          <!-- /top tiles -->

          <? checkpayment()?>

        </div>