
<?php
require_once('inc/ensure_login.php');
require_once('connect.inc.php');
  if(isset($_SESSION['isvoter'])){
    $session_username = $_SESSION['isvoter'];
    $sql = mysqli_fetch_assoc(mysqli_query($con,"select * from users where username='$session_username'"));
    $passport_sql = mysqli_fetch_assoc(mysqli_query($con,"select * from registeration where email_id='$session_username'"));
    $session_image_path = $passport_sql['passport'];
  }


?>


<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><i class="fa fa-paw"></i> <span>E-VOTING</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <?php if(isset($_SESSION['isvoter']) && $session_image_path !='') { ?>
                <img src="<?= $session_image_path ?>" alt="..." class="img-circle profile_img">
                <?php }else{ ?>
                  <img src="images/user.png" alt="..." class="img-circle profile_img">
                <?php } ?>
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <?php if(isset($_SESSION['isvoter'])) { ?>
                  <h2><?= 'VOTER';?></h2>
                <?php }else{ ?>
                  <h2>Admin</h2>
                <?php } ?>

              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="index.php">Home</a></li>

                  <?php if($_SESSION['isadmin']) { ?>
                  <li><a href="aspirant_reg.php">Register Candidate</a></li>
                  <!-- <li><a href="users.php">Register Staff</a></li> -->
                  <li><a href="post.php">Register Post</a></li>
                  <li><a href="vote_casting.php">Vote</a></li>
                  <li><a href="election_date.php">Schedule Election</a></li>
                  <li><a href="view_voters.php">Registered Voters</a></li>
                  <?php } ?>
                  <?php if($_SESSION['isvoter']) { ?>
                    <li><a href="voters_reg.php">Profile</a></li>
                    <li><a href="cast_vote.php">Cast Vote</a></li>
                    <li><a href="vote_result.php">Vote Result</a></li>
                  <?php } ?>

                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <!-- /menu footer buttons -->
          </div>
        </div>