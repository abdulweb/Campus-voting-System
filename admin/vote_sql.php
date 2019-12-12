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
$res = mysqli_query($con, "Select sn from party where sn='$get_id'");
if( mysqli_num_rows($res) > 0 ){
	$row = mysqli_fetch_assoc();
	 $aspirant_Name =$row['full_name'];
	 $action = "Voted"
    mysqli_query($con, "insert into vote value('$aspirant_Name','$action')");
    header('Location: voting.php?vd=true');
}