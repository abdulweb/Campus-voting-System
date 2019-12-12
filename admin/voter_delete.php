<?php
/**
 * Created by PhpStorm.
 * User: Abu Sumayyah
 * Date: 26-Mar-17
 * Time: 12:46 PM
 */
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');
$get_id = $_GET['v'];
$res = mysqli_query($con, "Select sn from registeration where sn='$get_id'");
if( mysqli_num_rows($res) > 0 ){
    mysqli_query($con, "delete from registeration where sn='$get_id'");
    header('Location: voters_reg.php?vd=true');
}