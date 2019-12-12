<?php
/**
 * Created by PhpStorm.
 * User: Abu Sumayyah
 * Date: 27-Mar-17
 * Time: 2:46 PM
 */
require_once('inc/ensure_login.php');
require('inc/connect.inc.php');
$get_id = $_POST['pr'];
echo $get_id;
/*$res = mysqli_query($con, "Select sn from party where sn='$get_id'");
if( mysqli_num_rows($res) > 0 ){
    mysqli_query($con, "delete from party where sn='$get_id'");
    header('Location: party_reg.php?vd=true');
}