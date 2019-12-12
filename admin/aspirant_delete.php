<?php
/**
 * Created by PhpStorm.
 * User: Abu Sumayyah
 * Date: 27-Mar-17
 * Time: 5:41 PM
 */
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');
$get_id = $_POST['asn'];
$res = mysqli_query($con, "Select sn from aspirant where sn='$get_id'");
if( mysqli_num_rows($res) > 0 ){
    mysqli_query($con, "delete from aspirant where sn='$get_id'");
    header('Location: aspirant_reg.php?vd=true');
}