<?php
/**
 * Created by PhpStorm.
 * User: Abu Sumayyah
 * Date: 21-Mar-17
 * Time: 9:34 PM
 */
error_reporting(0);

$host = 'localhost';
$user = 'root';
$password = 'root';
$db_name = 'evoting';

$con = mysqli_connect($host, $user, $password);
if (!$con) {
    die('Connection to database failed. Please contact the Admin');
}
mysqli_select_db($con, $db_name);
?>